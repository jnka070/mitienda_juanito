<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       contact@iqtsystems.com
 * @since      1.0.0
 *
 * @package    Insta Web
 * @subpackage instaweb/admin/partials
 * @author     IQ <contact@iqtsystems.com>
 */
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->

<div class="wrap">
    <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
    
    <div class="instaweb-settings-container">
        <p class="description">
            <?php esc_html_e('Configure the Insta Web settings below.', 'instaweb'); ?>
        </p>
        <hr>
        <p><?php echo('instaweb-settings')?></p>
        <form method="post" action="options.php" class="instaweb-settings-form">
            <?php
            settings_fields('instaweb_settings'); // Seguridad en los ajustes
            do_settings_sections('instaweb-settings'); // Sección de ajustes
            wp_nonce_field('instaweb_settings_action', 'instaweb_nonce'); // Protección CSRF
            submit_button(__('Save Settings', 'instaweb')); // Botón de guardar
            ?>
        </form>
    </div>
</div>
