<?php

use Automattic\WooCommerce\Blocks\Payments\PaymentMethodRegistry;
use Automattic\WooCommerce\Utilities\FeaturesUtil;

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Insta Web
 * @subpackage instaweb/admin
 * @author     IQ <contact@iqtsystems.com>
 */

class Instaweb_Admin
{

    /**
     * The ID of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $plugin_name    The ID of this plugin.
     */
    private $plugin_name;

    /**
     * The version of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $version    The current version of this plugin.
     */
    private $version;

    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     * @param      string    $plugin_name       The name of this plugin.
     * @param      string    $version    The version of this plugin.
     */
    public function __construct($plugin_name, $version)
    {
        $this->plugin_name = $plugin_name;
        $this->version = $version;
    }

    /**
     * Register the stylesheets for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_styles()
    {

        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in instaweb_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The instaweb_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */

        wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/instaweb-admin.css', array(), $this->version, 'all');
    }

    /**
     * Register the JavaScript for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_scripts()
    {

        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in instaweb_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The instaweb_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */

        wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/instaweb-admin.js', array('jquery'), $this->version, false);
    }
    /**
     * Undocumented function
     *
     * @param array $links
     * @return void
     */

    public function instaweb_action_links($links)
    {
        $pluginLinks = [
            '<a href="' . admin_url('admin.php?page=wc-settings&tab=checkout&section=instaweb') . '">' . __('Settings', 'instaweb') . '</a>',
        ];

        // Merge our new link with the default ones
        return array_merge($pluginLinks, $links);
    }

    /**
     * Add the gateway to WC Available Gateways.
     *
     * @since 1.0.0
     *
     * @param array $methods all available WC gateways
     *
     * @return string[] $methods all WC gateways + WC_Gateway_Instaweb_Commerce
     */
    public function add_instaweb_class($methods)
    {
        $methods[] = 'WC_Gateway_Instaweb_Commerce';

        return $methods;
    }

    public function init_instaweb_bank_class()
    {
        require_once plugin_dir_path(dirname(__FILE__)) . 'api/WC_Gateway_Instaweb_Commerce.php';

        return new WC_Gateway_Instaweb_Commerce();
    }

    public function custom_admin_notices()
    {
        if (!get_option('instaweb_keyid') || !get_option('instaweb_public_keyid')) {
            echo '<div class="notice notice-error">
			<p>Los parámetros "keyId", "publicKeyId" y "keyplugin" son obligatorios para la configuración inicial de Insta Web.</p>
			</div>';
        }
    }

    public function add_instaweb_settings_page()
    {
        add_menu_page(
            __('Insta Web Settings', 'instaweb'), // Título de la página
            __('Insta Web', 'instaweb'), // Texto del menú
            'manage_options', // Capacidad necesaria para acceder a la página
            'instaweb-settings', // Slug de la página
            [$this, 'load_instaweb_settings'], // Función para mostrar la página
            plugins_url('instaweb/admin/img/icon-20x20.png') // Icono
        );
    }

    public function load_instaweb_settings()
    {
        require_once plugin_dir_path(dirname(__FILE__)) . 'admin/instaweb-settings.php';
    }

    public function display_instaweb_settings_notice()
    {
        if (
            isset($_GET['page'])
            && 'instaweb-settings' == $_GET['page']
            && isset($_GET['settings-updated'])
            && true == $_GET['settings-updated']
        ) {
            echo '
			<div class="notice notice-success is-dismissible">
				<p>
					<strong>instaweb settings saved.</strong>
				</p>
			</div>
			';
        }
    }

    public function instaweb_settings_fields()
    {
        // I created variables to make the things clearer
        $page_slug = 'instaweb-settings';
        $option_group = 'instaweb_settings';
        //
        add_settings_section(
            'instaweb_apikeys', // section ID
            '', // title (optional)
            '', // callback function to display the section (optional)
            $page_slug
        );

        register_setting(
            $option_group,
            'instaweb_keyid',
        );

        register_setting(
            $option_group,
            'instaweb_public_keyid',
        );

        register_setting(
            $option_group,
            'instaweb_keyplugin',
        );

        add_settings_field(
            'instaweb_keyid',
            'Key ID: ',
            [$this, 'input_text'], // function to print the field
            $page_slug,
            'instaweb_apikeys',
            [
                'label_for' => 'instaweb_keyid',
                'class' => 'hello', // for <tr> element
                'name' => 'instaweb_keyid', // pass any custom parameters
                'type' => 'text', // text, textarea, select, checkbox, radio
                'value' => get_option('instaweb_keyid')
            ]
        );

        add_settings_field(
            'instaweb_public_keyid',
            'Public Key ID: ',
            [$this, 'input_text'], // function to print the field
            $page_slug,
            'instaweb_apikeys',
            [
                'label_for' => 'instaweb_public_keyid',
                'class' => 'hello', // for <tr> element
                'name' => 'instaweb_public_keyid', // pass any custom parameters
                'type' => 'text', // text, textarea, select, checkbox, radio
                'value' => get_option('instaweb_public_keyid')
            ]
        );

        add_settings_field(
            'instaweb_keyplugin',
            'Key Plugin: ',
            [$this, 'input_text'], // function to print the field
            $page_slug,
            'keyplugin',
            [
                'label_for' => 'key_plugin',
                'class' => 'hello', // for <tr> element
                'name' => 'instaweb_keyplugin', // pass any custom parameters
                'type' => 'text', // text, textarea, select, checkbox, radio
                'value' => get_option('instaweb_keyplugin')
            ]
        );
    }

    // custom callback function to print field HTML
    public function input_text($args)
    {
        // print("<pre>" . print_r($options, true) . "</pre>");
        echo '<input type="' . $args['type'] . '" id="' . $args['name'] . '" class="' . $args['name'] . '" name="' . $args['name'] . '" value="' . $args['value'] . '" />';
    }

    // public function instaweb_checkout_blocks_compatibility(): void {

    //     $path =  WP_PLUGIN_DIR.'/instaweb';
    //     if ( class_exists( '\Automattic\WooCommerce\Utilities\FeaturesUtil' ) ) {
    //         FeaturesUtil::declare_compatibility(
    //             'cart_checkout_blocks',
    //             $path,
    //             true // true (compatible, default) or false (not compatible)
    //         );

    //         FeaturesUtil::declare_compatibility(
    //             'custom_order_tables',
    //             $path,
    //             true
    //         );
    //     }

    // }

    function instaweb_declare_woocommerce_compatibility()
    {
        // Verificar si WooCommerce está activo y si FeaturesUtil existe
        if ( class_exists(FeaturesUtil::class)) {
            $path = WP_PLUGIN_DIR . '/instaweb';
    
            try {
                // Verificar si las constantes están definidas antes de usarlas
                if (defined('INSTAWEB_CART_CHECKOUT_BLOCKS') && defined('INSTAWEB_CUSTOM_ORDER_TABLES')) {
                    // Declarar la compatibilidad con cart_checkout_blocks
                    FeaturesUtil::declare_compatibility(
                        INSTAWEB_CART_CHECKOUT_BLOCKS,
                        $path,
                        true // Compatible
                    );
    
                    // Declarar la compatibilidad con custom_order_tables
                    FeaturesUtil::declare_compatibility(
                        INSTAWEB_CUSTOM_ORDER_TABLES,
                        $path,
                        true // Compatible
                    );
                } else {
                    // Registrar un error si las constantes no están definidas
                    error_log('Las constantes de compatibilidad no están definidas: INSTAWEB_CART_CHECKOUT_BLOCKS o INSTAWEB_CUSTOM_ORDER_TABLES');
                }
            } catch (\Exception $e) {
                // Manejar cualquier error que ocurra durante la declaración
                error_log('Error declarando la compatibilidad de instaweb con WooCommerce: ' . $e->getMessage());
            }
        } else {
            // Registrar un error si WooCommerce o FeaturesUtil no están presentes
            error_log('WooCommerce blocks o FeaturesUtil no están disponibles.');
        }
    }
    

    // public function instapago_gateway_block_support(): void {

    //     // here we're including our "gateway block support class"
    //     require_once WP_PLUGIN_DIR.'/instaweb/support/class-wc-instapago-gateway-blocks-support.php';

    //     // registering the PHP class we have just included
    //     add_action(
    //         'woocommerce_blocks_payment_method_type_registration',
    //         function ( Automattic\WooCommerce\Blocks\Payments\PaymentMethodRegistry $payment_method_registry ) {
    //             $payment_method_registry->register( new WC_Instaweb_Gateway_Blocks_Support );
    //         }
    //     );

    // }
    function instaweb_include_gateway_blocks_support() {
        if ( file_exists( INSTAWEB_GATEWAY_BLOCKS_SUPPORT_FILE ) ) {
            require_once INSTAWEB_GATEWAY_BLOCKS_SUPPORT_FILE;
        } else {
            error_log( 'Instaweb: No se encontró el archivo de soporte de bloques de pago: ' . INSTAWEB_GATEWAY_BLOCKS_SUPPORT_FILE );
        }
    }
    
    /**
     * Registra el método de pago de Instapago para bloques de WooCommerce.
     */
    function instaweb_register_gateway_blocks_support( PaymentMethodRegistry $payment_method_registry ) {

        if ( class_exists( 'WC_Instaweb_Gateway_Blocks_Support' ) ) {
            $payment_method_registry->register( new WC_Instaweb_Gateway_Blocks_Support );
        } else {
            error_log( 'Instaweb: La clase WC_Instaweb_Gateway_Blocks_Support no está definida.' );
        }
    }
    
    /**
     * Inicializa el soporte para bloques de pago de Instapago.
     */
    public function instapago_gateway_block_support(): void {
        // Verificar si WooCommerce Blocks está activo
        if ( class_exists( PaymentMethodRegistry::class ) ) {
            $this->instaweb_include_gateway_blocks_support();
            
            add_action(
                'woocommerce_blocks_payment_method_type_registration',
                [ $this, 'instaweb_register_gateway_blocks_support' ]
            );
            
        } else {
            error_log( 'Instaweb: WooCommerce Blocks no está activo.' );
        }
    }
}
