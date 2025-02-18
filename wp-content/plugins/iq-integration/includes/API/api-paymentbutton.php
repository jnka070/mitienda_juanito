<?php

function iq_api_paymantbutton(){
    register_rest_route(
        "iq",
        "button",
        array(
            'methods'=>'POST',
            'callback'=> 'iq_paymantbutton_callback'
        )
        );
}


function iq_paymantbutton_callback($REQUEST){
    
    $api_enpoint = 'https://api.instapago.com/payment';

    $REQUEST = array(
         'KeyId'=> get_option("KeyId"),
         'PublicKeyId' => get_option("PublicKeyId"),
         'Amount' => $REQUEST["Amount"],
         'Description'=> $REQUEST["Description"],
         'CardHolder'=> $REQUEST["CardHolder"],
         'CardHolderID'=> $REQUEST["CardHolderID"],
         'CardNumber'=> $REQUEST["CardNumber"],
         'CVC'=> $REQUEST["CVC"],
         'ExpirationDate'=> $REQUEST["ExpirationDate"],
         'StatusId'=> get_option("StatusId"),
         'IP'=>'user_ip',
         'OrderNumber'=>$REQUEST["OrderNumber"],

     );

    $spi_arg = array(
        'method' => 'POST',
        'headers' => array(
            'Cache-Control'=> 'no-cache',
            'Content-Type' => 'application/x-www-form-urlencoded',
          
        ),
        'body' => $REQUEST
        
    );
    $response = wp_remote_request($api_enpoint, $spi_arg);

    $data = json_decode( wp_remote_retrieve_body( $response ), true );
    
   

    if (isset($data['message'])) {
        $vista = array(
            'success' => $data['success'],
            'mensaje'=> $data['message'],
            'recerence' => $data['reference'],
            'Orden_Data' => $data['ordernumber'],
            'Amount' => $data['amount'],
            
        );
        if (isset( $data['success']))
        { 
            $ref = $data['reference'];
            $order_id= $data['ordernumber'];
            actualiza_estado_pedidos_a_procesado( $order_id);
            
            enviar_detalles_orden_al_cliente( $order_id);

            cambiorefencia($order_id, $ref);

        }    
       
       
    } else {
        $vista = '<h1>No message found</h1>';
    }


    return $vista;
    
}

add_action('rest_api_init', "iq_api_paymantbutton");



function get_the_user_ip() {
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    return apply_filters('wpb_get_ip', $ip);
}

function show_user_ip() {
    $user_ip = get_the_user_ip();
    echo 'Tu dirección IP es: ' . $user_ip;
}

add_shortcode('user_ip', 'show_user_ip');



add_action( 'woocommerce_order_status_pending', 'actualiza_estado_pedidos_a_procesado' );

function actualiza_estado_pedidos_a_procesado( $order_id) {
    if(!$order_id)return;
    
    $order = wc_get_order( $order_id );
    
    $order->update_status( 'wc-processing' );
 
    
}



add_action( 'woocommerce_order_status_processing', 'enviar_detalles_orden_al_cliente' );

function enviar_detalles_orden_al_cliente( $order_id) {
    if ( !$order_id ) return;
   
    
    $order = wc_get_order( $order_id );
    $to_email = $order->get_billing_email();
    $subject = 'Detalles de tu pedido';
    $headers = array('Content-Type: text/html; charset=UTF-8');
    
    $message = '<h2>Detalles de tu pedido</h2>';
    $message .= '<p>Gracias por tu compra. Aquí están los detalles de tu pedido:</p>';
    $message .= '<ul>';
    foreach ( $order->get_items() as $item_id => $item ) {
        $product_name = $item->get_name();
        $quantity = $item->get_quantity();
        $total = $item->get_total();
        $message .= "<li>Producto: $product_name, Cantidad: $quantity, Total: $total</li>";
    }
    $message .= '</ul>';
    $message .= '<p>Total del pedido: ' . $order->get_total() . '</p>';
    $message .= '<p> Aquí están los detalles de tu pago:</p>';
    
   
   
   
   
  




    wp_mail( $to_email, $subject, $message, $headers );
}




function cambiorefencia($order_id, $ref) {
    
    global $wpdb;


    $wpdb->query('START TRANSACTION');



    $result2 = $wpdb->query("UPDATE wp_wc_orders SET transaction_id = $ref WHERE id = $order_id");


    if ($result2 !== false) {
   
    $wpdb->query('COMMIT');
    } else {
   
    $wpdb->query('ROLLBACK');
    }

    
}

add_action('iq_cambiorefencia', 'cambiorefencia');











