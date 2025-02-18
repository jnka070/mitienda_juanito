<?php
/*
* Angel Cruz <me@abr4xas.org> 03/22/2017
*/

$paymentMethod = get_post_meta( $order->id, '_payment_method', true );
			
if ( $paymentMethod == 'instapago' ) : ?>
<?php _e( 'Este es el voucher por tu compra realizada:', 'woocommerce' ); ?>
<?php echo $my_value = get_post_meta( $order->id, 'instapago_voucher', true ); ?>
<?php endif; ?>