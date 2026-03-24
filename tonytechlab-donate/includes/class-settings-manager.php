<?php
/**
 * Settings Manager — registers WP Settings API groups and provides static getter.
 * Sanitization callbacks for all 9 option groups.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class TonyTechLab_Donate_Settings_Manager {

    /** Option names mapped to setting groups. */
    private static $sections = array(
        'hero', 'mission', 'stats', 'funds', 'testimonials',
        'payment', 'faq', 'footer', 'design',
    );

    /**
     * Register all settings with WordPress.
     * Called on admin_init.
     */
    public function register_settings() {
        foreach ( self::$sections as $section ) {
            register_setting(
                'tonytechlab_' . $section . '_group',
                'tonytechlab_' . $section,
                array(
                    'type'              => 'array',
                    'sanitize_callback' => array( $this, 'sanitize_' . $section ),
                    'default'           => array(),
                )
            );
        }
    }

    /**
     * Get merged option values (saved + defaults fallback).
     *
     * @param string $section Section key (e.g. 'hero', 'stats').
     * @return array
     */
    public static function get( $section ) {
        $defaults    = tonytechlab_donate_get_defaults();
        $option_name = 'tonytechlab_' . $section;
        $saved       = get_option( $option_name, array() );
        return wp_parse_args( $saved, $defaults[ $option_name ] ?? array() );
    }

    /* ── Sanitization callbacks ── */

    public function sanitize_hero( $input ) {
        return array(
            'title'              => sanitize_text_field( $input['title'] ?? '' ),
            'title_highlight'    => sanitize_text_field( $input['title_highlight'] ?? '' ),
            'tag_text'           => sanitize_text_field( $input['tag_text'] ?? '' ),
            'subtitle'           => sanitize_textarea_field( $input['subtitle'] ?? '' ),
            'cta_text'           => sanitize_text_field( $input['cta_text'] ?? '' ),
            'secondary_cta_text' => sanitize_text_field( $input['secondary_cta_text'] ?? '' ),
            'image_url'          => esc_url_raw( $input['image_url'] ?? '' ),
            'badge_title'        => sanitize_text_field( $input['badge_title'] ?? '' ),
            'badge_description'  => sanitize_text_field( $input['badge_description'] ?? '' ),
        );
    }

    public function sanitize_mission( $input ) {
        $clean = array(
            'heading'      => sanitize_text_field( $input['heading'] ?? '' ),
            'image_url'    => esc_url_raw( $input['image_url'] ?? '' ),
            'badge_top'    => sanitize_text_field( $input['badge_top'] ?? '' ),
            'badge_bottom' => sanitize_text_field( $input['badge_bottom'] ?? '' ),
        );
        $clean['paragraphs'] = array();
        if ( isset( $input['paragraphs'] ) && is_array( $input['paragraphs'] ) ) {
            foreach ( $input['paragraphs'] as $p ) {
                $text = sanitize_textarea_field( $p );
                if ( '' !== $text ) {
                    $clean['paragraphs'][] = $text;
                }
            }
        }
        $clean['bullets'] = array();
        if ( isset( $input['bullets'] ) && is_array( $input['bullets'] ) ) {
            foreach ( $input['bullets'] as $b ) {
                $text = sanitize_text_field( $b );
                if ( '' !== $text ) {
                    $clean['bullets'][] = $text;
                }
            }
        }
        return $clean;
    }

    public function sanitize_stats( $input ) {
        return $this->sanitize_repeater( $input, function ( $item ) {
            return array(
                'number' => absint( $item['number'] ?? 0 ),
                'suffix' => sanitize_text_field( $item['suffix'] ?? '' ),
                'label'  => sanitize_text_field( $item['label'] ?? '' ),
            );
        } );
    }

    public function sanitize_funds( $input ) {
        $clean = $this->sanitize_repeater( $input, function ( $item ) {
            $allowed_colors = array( 'blue', 'green', 'purple', 'orange' );
            $color = sanitize_text_field( $item['color'] ?? 'blue' );
            return array(
                'icon'        => wp_kses_post( $item['icon'] ?? '' ),
                'title'       => sanitize_text_field( $item['title'] ?? '' ),
                'description' => sanitize_textarea_field( $item['description'] ?? '' ),
                'percentage'  => min( 100, absint( $item['percentage'] ?? 0 ) ),
                'color'       => in_array( $color, $allowed_colors, true ) ? $color : 'blue',
            );
        } );
        $clean['subtitle'] = sanitize_text_field( $input['subtitle'] ?? '' );
        return $clean;
    }

    public function sanitize_testimonials( $input ) {
        return $this->sanitize_repeater( $input, function ( $item ) {
            return array(
                'quote'      => sanitize_textarea_field( $item['quote'] ?? '' ),
                'name'       => sanitize_text_field( $item['name'] ?? '' ),
                'course'     => sanitize_text_field( $item['course'] ?? '' ),
                'avatar_url' => esc_url_raw( $item['avatar_url'] ?? '' ),
            );
        } );
    }

    public function sanitize_payment( $input ) {
        return array(
            'bank_name'        => sanitize_text_field( $input['bank_name'] ?? '' ),
            'bank_bin'         => sanitize_text_field( $input['bank_bin'] ?? '' ),
            'account_number'   => sanitize_text_field( $input['account_number'] ?? '' ),
            'account_holder'   => sanitize_text_field( $input['account_holder'] ?? '' ),
            'transfer_note'    => sanitize_text_field( $input['transfer_note'] ?? '' ),
            'paypal_button_id' => sanitize_text_field( $input['paypal_button_id'] ?? '' ),
            'qr_label'         => sanitize_text_field( $input['qr_label'] ?? '' ),
            'qr_description'   => sanitize_text_field( $input['qr_description'] ?? '' ),
        );
    }

    public function sanitize_faq( $input ) {
        return $this->sanitize_repeater( $input, function ( $item ) {
            return array(
                'question' => sanitize_text_field( $item['question'] ?? '' ),
                'answer'   => sanitize_textarea_field( $item['answer'] ?? '' ),
            );
        } );
    }

    public function sanitize_footer( $input ) {
        $clean = array(
            'heading'    => sanitize_text_field( $input['heading'] ?? '' ),
            'email'      => sanitize_email( $input['email'] ?? '' ),
            'disclaimer' => sanitize_textarea_field( $input['disclaimer'] ?? '' ),
        );
        $clean['social_links'] = array();
        if ( isset( $input['social_links'] ) && is_array( $input['social_links'] ) ) {
            foreach ( $input['social_links'] as $link ) {
                $label = sanitize_text_field( $link['label'] ?? '' );
                $url   = esc_url_raw( $link['url'] ?? '' );
                if ( '' !== $label && '' !== $url ) {
                    $clean['social_links'][] = array( 'label' => $label, 'url' => $url );
                }
            }
        }
        $clean['links'] = array();
        if ( isset( $input['links'] ) && is_array( $input['links'] ) ) {
            foreach ( $input['links'] as $link ) {
                $label = sanitize_text_field( $link['label'] ?? '' );
                $url   = esc_url_raw( $link['url'] ?? '' );
                if ( '' !== $label && '' !== $url ) {
                    $clean['links'][] = array( 'label' => $label, 'url' => $url );
                }
            }
        }
        return $clean;
    }

    public function sanitize_design( $input ) {
        $allowed_fonts = array_keys( tonytechlab_donate_font_stacks() );
        $font = sanitize_text_field( $input['font_family'] ?? 'inter' );
        return array(
            'primary_color'   => sanitize_hex_color( $input['primary_color'] ?? '' ) ?: '#2563eb',
            'secondary_color' => sanitize_hex_color( $input['secondary_color'] ?? '' ) ?: '#f59e0b',
            'font_family'     => in_array( $font, $allowed_fonts, true ) ? $font : 'inter',
        );
    }

    /* ── Shared repeater sanitizer ── */

    private function sanitize_repeater( $input, $item_callback ) {
        $clean = array( 'heading' => sanitize_text_field( $input['heading'] ?? '' ) );
        $clean['items'] = array();
        if ( isset( $input['items'] ) && is_array( $input['items'] ) ) {
            foreach ( $input['items'] as $item ) {
                $clean['items'][] = $item_callback( $item );
            }
        }
        return $clean;
    }
}
