<?php
/**
 * Color utility helpers for design settings.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Darken a hex color by a percentage (0–100).
 *
 * @param string $hex     Hex color (e.g. '#2563eb').
 * @param int    $percent Amount to darken (0–100).
 * @return string Darkened hex color.
 */
function tonytechlab_donate_darken_hex( $hex, $percent ) {
    $hex = ltrim( $hex, '#' );
    if ( strlen( $hex ) !== 6 ) {
        return '#' . $hex;
    }
    $amount = round( 255 * $percent / 100 );
    $r = max( 0, hexdec( substr( $hex, 0, 2 ) ) - $amount );
    $g = max( 0, hexdec( substr( $hex, 2, 2 ) ) - $amount );
    $b = max( 0, hexdec( substr( $hex, 4, 2 ) ) - $amount );
    return sprintf( '#%02x%02x%02x', $r, $g, $b );
}

/**
 * Font family map — key to CSS font stack.
 */
function tonytechlab_donate_font_stacks() {
    return array(
        'inter'     => "'Inter', system-ui, -apple-system, sans-serif",
        'system'    => "system-ui, -apple-system, 'Segoe UI', Roboto, sans-serif",
        'roboto'    => "'Roboto', system-ui, sans-serif",
        'open-sans' => "'Open Sans', system-ui, sans-serif",
        'lato'      => "'Lato', system-ui, sans-serif",
    );
}

/**
 * Google Fonts URLs — key to CDN URL (null = no external font).
 */
function tonytechlab_donate_font_urls() {
    return array(
        'inter'     => 'https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Manrope:wght@700;800&display=swap',
        'system'    => null,
        'roboto'    => 'https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap',
        'open-sans' => 'https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600;700&display=swap',
        'lato'      => 'https://fonts.googleapis.com/css2?family=Lato:wght@400;700;900&display=swap',
    );
}
