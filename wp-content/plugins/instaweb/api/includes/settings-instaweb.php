<?php

/**
 * Configuración de Insta Web.
 *
 * @category Admin
 *
 * @author     IQ <contact@iqtsystems.com>
 * @copyright Copyright (C) IQ <contact@iqtsystems.com> and WooCommerce
 */
if (!defined('ABSPATH')) {
	exit;
}

/*
 * Settings for Insta Web Gateway.
 */
return [
	'enabled' => [
		'title'   => __('Enable/Disable', 'instaweb'),
		'type'    => 'checkbox',
		'label'   => __('Habilitar Insta Web', 'instaweb'),
		'default' => 'no',
	],
	'title' => [
		'title'       => __('Título', 'instaweb'),
		'type'        => 'text',
		'description' => __('Esto controla el título que el usuario ve durante la compra.', 'instaweb'),
		'default'     => __('Insta Web', 'instaweb'),
		'desc_tip'    => true,
	],
	'description' => [
		'title'       => __('Descripción', 'instaweb'),
		'type'        => 'text',
		'desc_tip'    => true,
		'description' => __('Esto controla la descripción que el usuario ve durante la compra.', 'instaweb'),
		'default'     => __('Puedes pagar con tu tarjeta de crédito.', 'instaweb'),
	],
	'api_details' => [
		'title'       => __('Credenciales de la API de Insta Web', 'instaweb'),
		'type'        => 'title',
		'description' => sprintf(__('Ingrese su <strong>keyId</strong>, su <strong>publicKeyId</strong> y su <strong>keyplugin</strong>  puede obtenerlas haciendo clic %saquí%s.', 'instaweb'), '<a href="https://instapago.com" target="_blank">', '</a>'),
	],
	'api_keyId' => [
		'title'       => __('keyId', 'instaweb'),
		'type'        => 'text',
		'description' => __('Se encuentra en su panel de usuario en instapago.com', 'instaweb'),
		'default'     => '',
		'desc_tip'    => true,
		'placeholder' => __('Requerido', 'instaweb'),
	],
	'api_publicKeyId' => [
		'title'       => __('publicKeyId', 'instaweb'),
		'type'        => 'text',
		'description' => __('Se encuentra en su buzón de correo.', 'instaweb'),
		'default'     => '',
		'desc_tip'    => true,
		'placeholder' => __('Requerido', 'instaweb'),
	],
	'key_plugin' => [
		'title'       => __('keyplugin', 'instaweb'),
		'type'        => 'text',
		'description' => __('Se encuentra en su buzón de correo.', 'instaweb'),
		'default'     => '',
		'desc_tip'    => true,
		'placeholder' => __('Requerido', 'instaweb'),
	],
	'api_debug' => [
		'title'       => __('Modo de depuración', 'instaweb'),
		'type'        => 'title',
		'description' => sprintf(__('Desactivar cuando terminen las pruebas de integración', 'instaweb')),
	],
	'debug' => [
		'title'       => __('Debug Log', 'instaweb'),
		'type'        => 'checkbox',
		'label'       => __('Enable logging', 'instaweb'),
		'default'     => 'yes',
		'description' => sprintf(__('Save Insta Web events inside <code>%s</code>', 'instaweb'), wc_get_log_file_path('instaweb')),
	],
];
