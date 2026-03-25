<?php
/**
 * Frontend — Hero section (dark gradient, centered text with icon).
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$hero           = TonyTechLab_Donate_Settings_Manager::get( 'hero' );
$highlight      = $hero['title_highlight'] ?? '';
$title_html     = esc_html( $hero['title'] );

/* Wrap the highlight portion in a gradient span */
if ( $highlight ) {
    $title_html = str_replace(
        esc_html( $highlight ),
        '<span class="donate-hero__highlight">' . esc_html( $highlight ) . '</span>',
        $title_html
    );
}
?>

<section class="donate-hero">
    <div class="donate-hero__dots" aria-hidden="true"></div>
    <div class="donate-container">
        <div class="donate-hero__center">
            <div class="donate-hero__icon-wrap" aria-hidden="true">
                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z"/>
                    <path d="M12 5 9.04 7.96a2.17 2.17 0 0 0 0 3.08c.82.82 2.13.85 3 .07l2.07-1.9a2.82 2.82 0 0 1 3.79 0l2.96 2.66"/>
                    <path d="m18 15-2-2"/>
                    <path d="m15 18-2-2"/>
                </svg>
            </div>

            <h1 class="donate-hero__title"><?php echo $title_html; ?></h1>
            <p class="donate-hero__subtitle"><?php echo esc_html( $hero['subtitle'] ); ?></p>
        </div>
    </div>
</section>
