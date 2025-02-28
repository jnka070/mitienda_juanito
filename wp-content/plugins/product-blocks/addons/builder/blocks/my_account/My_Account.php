<?php
namespace WOPB\blocks;

defined('ABSPATH') || exit;

class My_Account{
    public function __construct() {
        add_action( 'init', array( $this, 'register' ) );
    }

    public function get_attributes() {
        return array(
            'showProfile' => true,
        );
    }

    public function register() {
        register_block_type( 'product-blocks/my-account',
            array(
                'editor_script' => 'wopb-blocks-builder-script',
                'editor_style'  => 'wopb-blocks-editor-css',
                'render_callback' => array( $this, 'content' )
            )
        );
    }

    public function content( $attr, $noAjax = false ) {
        $block_name = 'my-account';
        $user_id = get_current_user_id();
        $profileUrl = get_avatar_url($user_id);
        $userData = get_userdata($user_id);
        $wraper_before = $wraper_after = $content = '';
        $attr = wp_parse_args( $attr, $this->get_attributes() );

        if ( function_exists( 'WC' ) ) {
            $attr['className'] = !empty($attr['className']) ? preg_replace('/[^A-Za-z0-9_ -]/', '', $attr['className']) : '';

            $wraper_before .= '<div ' . ( isset($attr['advanceId']) ? 'id="' . sanitize_html_class($attr['advanceId']) . '" ' : '' ) . ' class="wp-block-product-blocks-' . $block_name . ' wopb-block-' . sanitize_html_class($attr["blockId"]) . ' ' . $attr['className'] . '">';
                $wraper_before .= '<div class="wopb-product-wrapper ">';
                
                if ( ! is_admin() ) {
                    ob_start();
                    require_once WOPB_PATH . 'addons/builder/blocks/my_account/Template.php';
                    $content .= ob_get_clean();
                }

                $wraper_after .= '</div>';
            $wraper_after .= '</div> ';
        }

        return $wraper_before.$content.$wraper_after;
    }
}