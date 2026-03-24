<?php
/**
 * Frontend — Hero section (two-column with image and floating badge).
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

$tag_text           = $hero['tag_text'] ?? '';
$secondary_cta      = $hero['secondary_cta_text'] ?? '';
$image_url          = $hero['image_url'] ?? '';
$badge_title        = $hero['badge_title'] ?? '';
$badge_description  = $hero['badge_description'] ?? '';
?>

<section class="donate-hero">
    <div class="donate-container">
        <div class="donate-hero__grid">
            <!-- Left column: text -->
            <div class="donate-hero__content">
                <?php if ( $tag_text ) : ?>
                    <span class="donate-hero__tag"><?php echo esc_html( $tag_text ); ?></span>
                <?php endif; ?>

                <h1 class="donate-hero__title"><?php echo $title_html; ?></h1>
                <p class="donate-hero__subtitle"><?php echo esc_html( $hero['subtitle'] ); ?></p>

                <div class="donate-hero__actions">
                    <a href="#donate-section" class="donate-btn donate-btn--primary">
                        <?php echo esc_html( $hero['cta_text'] ); ?>
                    </a>
                    <?php if ( $secondary_cta ) : ?>
                        <a href="#donate-mission" class="donate-btn donate-btn--outline">
                            <?php echo esc_html( $secondary_cta ); ?>
                        </a>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Right column: image -->
            <div class="donate-hero__visual">
                <div class="donate-hero__image-wrap">
                    <img src="<?php echo esc_url( $image_url ?: TONYTECHLAB_DONATE_URL . 'public/images/hero-classroom.jpg' ); ?>"
                         alt="<?php echo esc_attr( $hero['title'] ); ?>"
                         class="donate-hero__image" loading="eager" />

                    <?php if ( $badge_title ) : ?>
                        <div class="donate-hero__badge">
                            <span class="donate-hero__badge-icon" aria-hidden="true">&#127760;</span>
                            <div class="donate-hero__badge-text">
                                <strong><?php echo esc_html( $badge_title ); ?></strong>
                                <?php if ( $badge_description ) : ?>
                                    <p><?php echo esc_html( $badge_description ); ?></p>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>
