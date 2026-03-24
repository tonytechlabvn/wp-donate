<?php
/**
 * TonyTechLab Child Theme — Functions
 *
 * Enqueues parent theme styles and conditionally loads donate page assets.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Enqueue parent LearnPress theme stylesheet.
 */
function tonytechlab_child_enqueue_parent_styles() {
    wp_enqueue_style(
        'learnpress-parent-style',
        get_template_directory_uri() . '/style.css',
        array(),
        wp_get_theme( 'learnpress' )->get( 'Version' )
    );
}
add_action( 'wp_enqueue_scripts', 'tonytechlab_child_enqueue_parent_styles' );

/**
 * Safe filemtime with fallback to theme version.
 */
function tonytechlab_child_file_version( $path ) {
    return file_exists( $path ) ? filemtime( $path ) : wp_get_theme()->get( 'Version' );
}

/**
 * Conditionally enqueue donate page assets (CSS + JS + PayPal SDK) on the donate template.
 */
function tonytechlab_child_enqueue_donate_assets() {
    if ( ! is_page_template( 'page-templates/template-donate.php' ) ) {
        return;
    }

    $theme_uri = get_stylesheet_directory_uri();
    $theme_dir = get_stylesheet_directory();

    // Google Fonts — Inter (clean sans-serif)
    wp_enqueue_style(
        'tonytechlab-google-fonts',
        'https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap',
        array(),
        null
    );

    // Donate page styles
    wp_enqueue_style(
        'tonytechlab-donate',
        $theme_uri . '/assets/donate/donate-page.css',
        array( 'learnpress-parent-style' ),
        tonytechlab_child_file_version( $theme_dir . '/assets/donate/donate-page.css' )
    );

    // Donate page scripts (loaded in footer)
    wp_enqueue_script(
        'tonytechlab-donate',
        $theme_uri . '/assets/donate/donate-page.js',
        array(),
        tonytechlab_child_file_version( $theme_dir . '/assets/donate/donate-page.js' ),
        true
    );

    // PayPal Donate Button SDK (loaded in footer, defer)
    wp_enqueue_script(
        'tonytechlab-paypal-sdk',
        'https://www.paypalobjects.com/donate/sdk/donate-sdk.js',
        array(),
        null,
        true
    );

    // PayPal button initialization (inline, after SDK loads)
    $paypal_button_id = defined( 'TONYTECHLAB_PAYPAL_BUTTON_ID' )
        ? TONYTECHLAB_PAYPAL_BUTTON_ID
        : 'YOUR_BUTTON_ID';

    wp_add_inline_script(
        'tonytechlab-paypal-sdk',
        sprintf(
            'document.addEventListener("DOMContentLoaded",function(){' .
                'if(typeof PayPal!=="undefined"&&PayPal.Donation){' .
                    'PayPal.Donation.Button({' .
                        'env:"production",' .
                        'hosted_button_id:"%s",' .
                        'image:{src:"https://www.paypalobjects.com/en_US/i/btn/btn_donateCC_LG.gif",alt:"Donate with PayPal"}' .
                    '}).render("#donate-button-container")' .
                '}' .
            '});',
            esc_js( $paypal_button_id )
        )
    );
}
add_action( 'wp_enqueue_scripts', 'tonytechlab_child_enqueue_donate_assets' );

/**
 * Add preconnect hints for Google Fonts domains.
 */
function tonytechlab_child_preconnect_hints() {
    if ( ! is_page_template( 'page-templates/template-donate.php' ) ) {
        return;
    }
    echo '<link rel="preconnect" href="https://fonts.googleapis.com" />' . "\n";
    echo '<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />' . "\n";
}
add_action( 'wp_head', 'tonytechlab_child_preconnect_hints', 1 );
