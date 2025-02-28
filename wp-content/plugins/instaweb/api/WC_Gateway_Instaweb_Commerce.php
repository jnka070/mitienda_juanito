<?php

defined('WPINC') || exit;

// Make sure WooCommerce is active
if (!in_array(WP_PLUGIN_DIR . '/woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins')))) {
	return;
}

class WC_Gateway_Instaweb_Commerce extends WC_Payment_Gateway
{
	public string $medthod_title;
	private string $keyId;
	private string $publicKeyId;
	public string $debug;
	public string $paymod;
	public string $keyplugin;


	/**
	 * Constructor for the gateway.
	 */
	public function __construct()
	{
		global $woocommerce;
		$this->id = 'instaweb';
		$this->order_button_text = __('Pagar con Insta Web', 'instaweb');
		error_log(	$this->order_button_text);
		$this->medthod_title = __('Insta Web', 'instaweb');
		$this->method_description = sprintf(__('Nuestra plataforma te permite validar pagos vía Zelle, con la seguridad que deseas al recibir pagos a través de este canal. Al vincular la plataforma al correo de tu cuenta bancaria, r ecibirás correos de confirmación que se actualizarán automáticamente en nuestra plataforma de manera rápida y confiable.', 'instaweb'));
		$this->has_fields = true;
		// Load the settings.
		$this->init_form_fields();
		$this->init_settings();
		// Define user set variables.
		$this->title = $this->get_option('title');
		$this->description = $this->get_option('description');

		$this->keyId = $this->get_option('api_keyId');
		$this->publicKeyId  = $this->get_option('api_publicKeyId');
		$this->keyplugin  = $this->get_option('keyplugin');
		$this->debug = $this->get_option('debug', 'yes');
		$this->paymod = $this->get_option('paymentaction');

		//Save hook
		add_action('woocommerce_update_options_payment_gateways_' . $this->id, [$this, 'process_admin_options']);
		add_action('woocommerce_receipt_lamdaprocessing', [&$this, 'finalize_order'], 0);
		add_action('woocommerce_receipt_lamdaprocessing', [&$this, 'receipt_page']);
		add_filter('woocommerce_order_button_text', function($button_text){
			return __('Pagar con Insta Web', 'instaweb');
		});
		
	}

	
	/**
	 * Admin Panel Options.
	 */
	public function admin_options()
	{
		include 'includes/admin-options.php';
	}

	/**
	 * Initialise Gateway Settings Form Fields.
	 *
	 * @return void
	 */
	public function init_form_fields()
	{
		$this->form_fields = include 'includes/settings-instaweb.php';
	}

	/**
	 * Get gateway icon.
	 *
	 * @return string
	 */
	public function get_icon()
	{
		$icon_html = '<img src="' . plugins_url('instaweb/public/img/instapagoisotipodegrade-01.png') . '" alt="instapago" style="max-width: 28% !important;height: auto !important;max-height: none !important;>';

		return apply_filters('woocommerce_gateway_icon', $icon_html, $this->id);
	}

	public function payment_fields()
	{
		if ($this->debug === 'yes') {
			echo '<p style="color:red"><strong>MODO TEST ACTIVADO</strong></p>';
		}

		echo '<p class="instaweb-form--txt-help">' . $this->description . '</p>';

		include 'includes/payment-fields.php';
	}

	public function process_payment($order_id)
	{
		global $woocommerce;

		$url            = 'https://api.instapago.com/payment';
		$order          = wc_get_order($order_id);
		$cardHolder     = strip_tags(trim($_POST['card_holder_name']));
		$cardHolderId   = strip_tags(trim($_POST['user_dni']));
		$cardNumber     = strip_tags(trim($_POST['valid_card_number']));
		$cvc            = strip_tags(trim($_POST['cvc_code']));
		$exp_month      = strip_tags(trim($_POST['exp_month']));
		$exp_year       = strip_tags(trim($_POST['exp_year']));
		$expirationDate = $exp_month . '/' . $exp_year;

		$fields = [
			'KeyID'          => $this->keyId, //required
			'PublicKeyId'    => $this->publicKeyId, //required
			'keyPlugin' 	=> $this->keyplugin, //required
			'Amount'         => $order->get_total(), //required
			'Description'    => 'Generating payment for order #' . $order->get_order_number(), //required
			'CardHolder'     => $cardHolder, //required
			'CardHolderId'   => $cardHolderId, //required
			'CardNumber'     => $cardNumber, //required
			'CVC'            => $cvc, //required
			'ExpirationDate' => $expirationDate, //required
			'StatusId'       => 2, //required
			'IP'             => $_SERVER['REMOTE_ADDR'], //required
		];

		$obj = $this->curlTransaccion($url, $fields);
		$result = $this->checkResponseCode($obj);

		if ($result['code'] == 201) {
			// Payment received and stock has been reduced

			$order->payment_complete();
			$order->add_order_note(__('Mensaje del Banco:<br/> <strong>' . $result['msg_banco'] . '</strong><br/> Número de Identificación del Pago:<br/><strong>' . $result['id_pago'] . '</strong><br/>Referencia Bancaria: <br/><strong>' . $result['reference'] . '</strong>', 'woothemes'));

			if ($this->debug == 'yes') {

				$logger = wc_get_logger();

				$context = [
					'source' => 'instaweb',
				];

				$logger->log('debug', 'Se ha procesado un pago', $result);
				$logger->log('debug', print_r($result, true), $context);
			}

			$order->update_meta_data('instaweb_voucher', $result['voucher']);
			$order->update_meta_data('instaweb_bank_ref', $result['reference']);
			$order->update_meta_data('instaweb_id_payment', $result['id_pago']);
			$order->update_meta_data('instaweb_bank_msg', $result['msg_banco']);
			$order->update_meta_data('instaweb_sequence', $result['sequence']);
			$order->update_meta_data('instaweb_approval', $result['approval']);
			$order->update_meta_data('instaweb_lote', $result['lote']);

			// Reduce stock levels
			wc_reduce_stock_levels($order_id);

			// Remove cart
			WC()->cart->empty_cart();

			// Return thankyou redirect
			return [
				'result'      => 'success',
				'redirect'    => $this->get_return_url($order),
			];
		}
	}

	/**
	 * Realiza Transaccion
	 * Efectúa y retornar una respuesta a un metodo de pago.
	 *
	 * @param string $url endpoint a consultar
	 * @param $fields datos para la consulta
	 *
	 * @return $response array resultados de la transaccion
	 */
	private function curlTransaccion($url, $fields)
	{
		$args = [
			'method' => 'POST',
			'headers'  => [
				'Content-type: application/x-www-form-urlencoded'
			],
			'body' => http_build_query($fields)
		];

		$response = wp_remote_retrieve_body(wp_remote_post($url, $args));

		$response = json_decode($response, true);

		return $response;
	}

	/**
	 * Verifica Codigo de Estado de transaccion
	 * Verifica y retornar el resultado de la transaccion.
	 *
	 * @param $response datos de la consulta
	 *
	 * @return $result array datos de transaccion
	 */
	private function checkResponseCode($response)
	{
		$code = $response['code'];
		switch ($code) {
			case 400:
				wc_add_notice(__('Error al validar los datos enviados.', 'instaweb'), 'error');
				break;
			case 401:
				wc_add_notice(__('Error de autenticación, ha ocurrido un error con las llaves utilizadas.', 'instaweb'), 'error');
				break;
			case 403:
				wc_add_notice(__('Pago Rechazado por el banco.', 'instaweb'), 'error');
				break;
			case 500:
				wc_add_notice(__('Ha Ocurrido un error interno dentro del servidor.', 'instaweb'), 'error');
				break;
			case 503:
				wc_add_notice(__('Ha Ocurrido un error al procesar los parámetros de entrada. Revise los datos enviados y vuelva a intentarlo.', 'instaweb'), 'error');
				break;
			case 201:
				return [
					'code'      => $code,
					'msg_banco' => $response['message'],
					'voucher'   => html_entity_decode($response['voucher']),
					'id_pago'   => $response['id'],
					'reference' => $response['reference'],
					'sequence'  => $response['sequence'],
					'approval'  => $response['approval'],
					'lote'      => $response['lote'],
				];
				break;
			default:
				wc_add_notice(__('Error general.', 'instaweb'), 'error');
				break;
		}
	}
}
