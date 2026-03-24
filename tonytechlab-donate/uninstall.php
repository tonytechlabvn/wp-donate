<?php
/**
 * Uninstall handler — removes all plugin options from wp_options.
 */

if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
    exit;
}

$option_names = array(
    'tonytechlab_hero',
    'tonytechlab_mission',
    'tonytechlab_stats',
    'tonytechlab_funds',
    'tonytechlab_testimonials',
    'tonytechlab_payment',
    'tonytechlab_faq',
    'tonytechlab_footer',
    'tonytechlab_design',
);

foreach ( $option_names as $option ) {
    delete_option( $option );
}
