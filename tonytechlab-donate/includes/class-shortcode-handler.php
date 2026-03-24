<?php
/**
 * Shortcode Handler — registers [tonytechlab_donate] and enqueues frontend assets.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class TonyTechLab_Donate_Shortcode_Handler {

    /**
     * Register the shortcode with WordPress.
     */
    public function register() {
        add_shortcode( 'tonytechlab_donate', array( $this, 'render' ) );
    }

    /**
     * Render the full donate page via shortcode.
     * Also enqueues assets as fallback when has_shortcode() missed it (widgets, blocks).
     */
    public function render( $atts ) {
        /* Fallback enqueue for contexts where has_shortcode() fails (widgets, nested content) */
        if ( ! wp_style_is( 'tonytechlab-donate', 'enqueued' ) ) {
            $this->do_enqueue();
        }

        ob_start();
        echo '<main class="donate-page">';

        $dir = TONYTECHLAB_DONATE_PATH . 'public/partials/';
        include $dir . 'section-hero.php';
        include $dir . 'section-mission.php';
        include $dir . 'section-stats.php';
        include $dir . 'section-funds.php';
        include $dir . 'section-testimonials.php';
        include $dir . 'section-payment.php';
        include $dir . 'section-faq.php';
        include $dir . 'section-footer.php';

        echo '</main>';
        return ob_get_clean();
    }

    /**
     * Enqueue frontend CSS/JS on pages containing the shortcode (early detection).
     */
    public function enqueue_assets() {
        global $post;
        if ( ! is_a( $post, 'WP_Post' ) || ! has_shortcode( $post->post_content, 'tonytechlab_donate' ) ) {
            return;
        }
        $this->do_enqueue();
    }

    /**
     * Actual enqueue logic — called from enqueue_assets() or as fallback from render().
     */
    private function do_enqueue() {
        $design      = TonyTechLab_Donate_Settings_Manager::get( 'design' );
        $font_key    = $design['font_family'] ?: 'inter';
        $font_urls   = tonytechlab_donate_font_urls();
        $font_stacks = tonytechlab_donate_font_stacks();

        /* Google Fonts (skip for system fonts) */
        $font_url = $font_urls[ $font_key ] ?? null;
        if ( $font_url ) {
            wp_enqueue_style( 'tonytechlab-google-fonts', $font_url, array(), null );
        }

        /* Plugin CSS */
        wp_enqueue_style(
            'tonytechlab-donate',
            TONYTECHLAB_DONATE_URL . 'public/donate-page.css',
            array(),
            TONYTECHLAB_DONATE_VERSION
        );

        /* Dynamic CSS variable overrides */
        $primary   = $design['primary_color'] ?: '#2563eb';
        $secondary = $design['secondary_color'] ?: '#f59e0b';
        $font_css  = $font_stacks[ $font_key ] ?? $font_stacks['inter'];

        $css = sprintf(
            '.donate-page{--donate-primary:%s;--donate-primary-dark:%s;--donate-secondary:%s;--donate-secondary-dark:%s;--donate-font:%s}',
            esc_attr( $primary ),
            esc_attr( tonytechlab_donate_darken_hex( $primary, 15 ) ),
            esc_attr( $secondary ),
            esc_attr( tonytechlab_donate_darken_hex( $secondary, 15 ) ),
            esc_attr( $font_css )
        );
        wp_add_inline_style( 'tonytechlab-donate', $css );

        /* Plugin JS */
        wp_enqueue_script(
            'tonytechlab-donate',
            TONYTECHLAB_DONATE_URL . 'public/donate-page.js',
            array(),
            TONYTECHLAB_DONATE_VERSION,
            true
        );

        /* PayPal SDK (only if configured) */
        $payment   = TonyTechLab_Donate_Settings_Manager::get( 'payment' );
        $button_id = $payment['paypal_button_id'] ?? '';
        if ( ! empty( $button_id ) && 'YOUR_BUTTON_ID' !== $button_id ) {
            wp_enqueue_script( 'tonytechlab-paypal-sdk', 'https://www.paypalobjects.com/donate/sdk/donate-sdk.js', array(), null, true );
            wp_add_inline_script(
                'tonytechlab-paypal-sdk',
                sprintf(
                    'document.addEventListener("DOMContentLoaded",function(){if(typeof PayPal!=="undefined"&&PayPal.Donation){PayPal.Donation.Button({env:"production",hosted_button_id:"%s",image:{src:"https://www.paypalobjects.com/en_US/i/btn/btn_donateCC_LG.gif",alt:"Donate with PayPal"}}).render("#donate-button-container")}});',
                    esc_js( $button_id )
                )
            );
        }
    }

    /**
     * Output preconnect hints for Google Fonts (if applicable).
     */
    public function preconnect_hints() {
        global $post;
        if ( ! is_a( $post, 'WP_Post' ) || ! has_shortcode( $post->post_content, 'tonytechlab_donate' ) ) {
            return;
        }

        $design   = TonyTechLab_Donate_Settings_Manager::get( 'design' );
        $font_url = tonytechlab_donate_font_urls()[ $design['font_family'] ?? 'inter' ] ?? null;
        if ( $font_url ) {
            echo '<link rel="preconnect" href="https://fonts.googleapis.com" />' . "\n";
            echo '<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />' . "\n";
        }
    }
}
