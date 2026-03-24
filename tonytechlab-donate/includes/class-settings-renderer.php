<?php
/**
 * Settings Renderer — admin page with tabbed interface (9 tabs).
 * Tab content delegated to admin/partials/tab-*.php files.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class TonyTechLab_Donate_Settings_Renderer {

    /** Tab definitions: slug => label. */
    private $tabs = array(
        'hero'         => 'Hero',
        'mission'      => 'Mission',
        'stats'        => 'Stats',
        'funds'        => 'Funds',
        'testimonials' => 'Testimonials',
        'payment'      => 'Payment',
        'faq'          => 'FAQ',
        'footer'       => 'Footer',
        'design'       => 'Design',
    );

    /**
     * Register the settings page under Settings menu.
     */
    public function add_admin_menu() {
        add_options_page(
            'TonyTechLab Donate Settings',
            'TonyTechLab Donate',
            'manage_options',
            'tonytechlab-donate',
            array( $this, 'render_page' )
        );
    }

    /**
     * Render the settings page with tab navigation.
     */
    public function render_page() {
        $active_tab = isset( $_GET['tab'] ) ? sanitize_key( $_GET['tab'] ) : 'hero';
        if ( ! array_key_exists( $active_tab, $this->tabs ) ) {
            $active_tab = 'hero';
        }

        echo '<div class="wrap">';
        echo '<h1>TonyTechLab Donate Settings</h1>';

        /* Tab navigation */
        echo '<nav class="nav-tab-wrapper">';
        foreach ( $this->tabs as $slug => $label ) {
            $url   = add_query_arg( array( 'page' => 'tonytechlab-donate', 'tab' => $slug ), admin_url( 'options-general.php' ) );
            $class = ( $slug === $active_tab ) ? 'nav-tab nav-tab-active' : 'nav-tab';
            printf( '<a href="%s" class="%s">%s</a>', esc_url( $url ), esc_attr( $class ), esc_html( $label ) );
        }
        echo '</nav>';

        /* Tab content partial */
        echo '<div class="ttl-admin-tab-content">';
        $partial = TONYTECHLAB_DONATE_PATH . 'admin/partials/tab-' . $active_tab . '.php';
        if ( file_exists( $partial ) ) {
            include $partial;
        }
        echo '</div>';

        echo '</div>';
    }

    /**
     * Enqueue admin assets only on our settings page.
     */
    public function enqueue_admin_assets( $hook ) {
        if ( 'settings_page_tonytechlab-donate' !== $hook ) {
            return;
        }

        /* WordPress color picker */
        wp_enqueue_style( 'wp-color-picker' );
        wp_enqueue_script( 'wp-color-picker' );

        /* jQuery UI Sortable for repeater drag-reorder */
        wp_enqueue_script( 'jquery-ui-sortable' );

        /* Plugin admin styles */
        wp_enqueue_style(
            'tonytechlab-admin',
            TONYTECHLAB_DONATE_URL . 'admin/admin-page.css',
            array( 'wp-color-picker' ),
            TONYTECHLAB_DONATE_VERSION
        );

        /* Repeater JS */
        wp_enqueue_script(
            'tonytechlab-admin-repeater',
            TONYTECHLAB_DONATE_URL . 'admin/admin-repeater.js',
            array( 'jquery-ui-sortable', 'wp-color-picker' ),
            TONYTECHLAB_DONATE_VERSION,
            true
        );
    }
}
