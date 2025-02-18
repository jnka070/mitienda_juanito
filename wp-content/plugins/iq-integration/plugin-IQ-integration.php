<?php
/**
 * Plugin Name:       Integration IQ-InstaPago 
 * Plugin URI:        https://github.com/Deivison81
 * Description:       Formularios de integracion de Pago
 * Version:           1.0
 * Requires at least: 5.8
 * Requires PHP:      7.4
 * Author:            Deivison Jimenez
 * Author URI:        https://github.com/Deivison81
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       IQ
*/


//formulario Cliente
require_once plugin_dir_path(__FILE__)."public/shortcode/form-paymentbutton.php";


//formulario Admin
require_once plugin_dir_path(__FILE__)."admin/shorcode/Payment-setting.php";

//API
require_once plugin_dir_path(__FILE__)."includes/API/api-paymentbutton.php";


