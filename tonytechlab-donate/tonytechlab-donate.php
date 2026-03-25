<?php
/**
 * Plugin Name: TonyTechLab Donate Page
 * Plugin URI:  https://tonytechlab.com
 * Description: Embeddable donate landing page with admin settings panel, VietQR and PayPal support. Use shortcode [tonytechlab_donate].
 * Version:     1.4.0
 * Author:      TonyTechLab
 * Author URI:  https://tonytechlab.com
 * License:     GPL-2.0+
 * Text Domain: tonytechlab-donate
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/* Plugin constants */
define( 'TONYTECHLAB_DONATE_VERSION',  '1.4.0' );
define( 'TONYTECHLAB_DONATE_PATH',     plugin_dir_path( __FILE__ ) );
define( 'TONYTECHLAB_DONATE_URL',      plugin_dir_url( __FILE__ ) );
define( 'TONYTECHLAB_DONATE_BASENAME', plugin_basename( __FILE__ ) );

/* Autoload includes */
require_once TONYTECHLAB_DONATE_PATH . 'includes/default-settings.php';
require_once TONYTECHLAB_DONATE_PATH . 'includes/helper-color-utils.php';
require_once TONYTECHLAB_DONATE_PATH . 'includes/class-settings-manager.php';
require_once TONYTECHLAB_DONATE_PATH . 'includes/class-settings-renderer.php';
require_once TONYTECHLAB_DONATE_PATH . 'includes/class-shortcode-handler.php';

/* ── Activation: populate defaults + import wp-config constants ── */
function tonytechlab_donate_activate() {
    $defaults = tonytechlab_donate_get_defaults();

    $is_first_activation = ( false === get_option( 'tonytechlab_payment' ) );

    foreach ( $defaults as $option_name => $default_value ) {
        if ( false === get_option( $option_name ) ) {
            add_option( $option_name, $default_value );
        }
    }

    /* Import wp-config constants ONLY on first activation (payment option was just created above).
     * On re-activation the option already exists, so we skip to avoid overwriting user edits. */
    if ( $is_first_activation ) {
        $payment = get_option( 'tonytechlab_payment', array() );
        $constant_map = array(
            'TONYTECHLAB_BANK_NAME'        => 'bank_name',
            'TONYTECHLAB_BANK_BIN'         => 'bank_bin',
            'TONYTECHLAB_ACCOUNT_NUMBER'   => 'account_number',
            'TONYTECHLAB_ACCOUNT_HOLDER'   => 'account_holder',
            'TONYTECHLAB_TRANSFER_NOTE'    => 'transfer_note',
            'TONYTECHLAB_PAYPAL_BUTTON_ID' => 'paypal_button_id',
        );
        $changed = false;
        foreach ( $constant_map as $const => $key ) {
            if ( defined( $const ) && constant( $const ) !== $defaults['tonytechlab_payment'][ $key ] ) {
                $payment[ $key ] = constant( $const );
                $changed = true;
            }
        }
        if ( $changed ) {
            update_option( 'tonytechlab_payment', $payment );
        }
    }
}
register_activation_hook( __FILE__, 'tonytechlab_donate_activate' );

/* ── Boot plugin ── */
$ttl_settings_manager  = new TonyTechLab_Donate_Settings_Manager();
$ttl_settings_renderer = new TonyTechLab_Donate_Settings_Renderer();
$ttl_shortcode_handler = new TonyTechLab_Donate_Shortcode_Handler();

/* Admin hooks */
add_action( 'admin_init', array( $ttl_settings_manager, 'register_settings' ) );
add_action( 'admin_menu', array( $ttl_settings_renderer, 'add_admin_menu' ) );
add_action( 'admin_enqueue_scripts', array( $ttl_settings_renderer, 'enqueue_admin_assets' ) );

/* Frontend hooks */
add_action( 'init', array( $ttl_shortcode_handler, 'register' ) );
add_action( 'wp_enqueue_scripts', array( $ttl_shortcode_handler, 'enqueue_assets' ) );
add_action( 'wp_head', array( $ttl_shortcode_handler, 'preconnect_hints' ), 1 );
