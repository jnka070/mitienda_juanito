<?php

function iq_personalizado_enqueue_styles() {
    // Registrar el archivo CSS
    wp_register_style('custom-style', plugins_url('../assets/css/style.css', __FILE__));
    // Encolar el archivo CSS
    wp_enqueue_style('custom-style');
}

// Añadir la acción para encolar el archivo CSS en el hook wp_enqueue_scripts
add_action('wp_enqueue_scripts', 'iq_personalizado_enqueue_styles');



function iq_script_create_payment() {
    $script_url = plugin_dir_url(__FILE__) . '../assets/js/payment.js';
    wp_register_script('iq_payment', $script_url, array(), '6.6.2', true);

    // Pasar datos de PHP a JavaScript
    wp_localize_script('iq_payment', 'iqPaymentData', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'order_total' => WC()->cart->get_total(''),
    ));
}

add_action('wp_enqueue_scripts', 'iq_script_create_payment');

function iq_add_payment_button() {
    wp_enqueue_script('iq_payment');

   
$order_id = isset($_GET['order']) ? intval($_GET['order']) : 0;


    if ($order_id > 0) {
   
        $order = wc_get_order($order_id);

   
        if ($order) {
            
            $order_total = $order->get_total();
        }
    }
    ob_start();
    ?>
    <div class="pay">
        <div class="pay__container" id="respay">
            <h1 class="pay__titulo" id="titulo">Pay Register</h1>
            <form class="pay__form" id="pay" method="post">
                <div class="order__number name--campo">
                    <label for="order_number">Order Number</label>
                  <input name="OrderNumber" type="text" id="order_number" required/>
                </div>
                <div class="amount name--campo">
                    <label for="amount">Amount</label>
                    <input name="Amount" type="text" id="amount" required pattern="^\d+(\.\d{1,2})?$" />
                </div>
                <div class="description name--campo">
                    <label for="description">Description</label>
                    <input name="Description" type="text" id="description" required />
                </div>
                <div class="card_holder name--campo">
                    <label for="card_holder">Card Holder</label>
                    <input name="CardHolder" type="text" id="card_holder" required />
                </div>
                <div class="card_holderid name--campo">
                    <label for="card_holderid">Card Holder ID</label>
                    <input name="CardHolderID" type="text" id="card_holderid" required />
                </div>
                <div class="card__number name--campo">
                    <label for="card_number">Card Number</label>
                    <input name="CardNumber" type="text" id="card_number" required />
                </div>
                <div class="cvc name--campo">
                    <label for="cvc">CVC</label>
                    <input name="CVC" type="text" id="cvc" required />
                </div>
                <div class="expiration_date name--campo">
                    <label for="expiration_date">Expiration Date</label>
                    <input name="ExpirationDate" type="text" id="expiration_date" required pattern="^(0[1-9]|1[0-2])\/\d{4}$" />
                </div>
                <br />
                <div class="pay__submit">
                    <button type="submit">Pagar</button>
                </div>
            </form>
        </div>
    </div>
    <?php
    return ob_get_clean();
}

add_shortcode('iq_payment', 'iq_add_payment_button');
?>






