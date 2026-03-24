<?php
/**
 * Frontend — Mission section (two-column with image and badges).
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$mission    = TonyTechLab_Donate_Settings_Manager::get( 'mission' );
$paragraphs = $mission['paragraphs'] ?? array();
$bullets    = $mission['bullets'] ?? array();
$image_url  = $mission['image_url'] ?? '';
$badge_top  = $mission['badge_top'] ?? '';
$badge_bot  = $mission['badge_bottom'] ?? '';
?>

<section class="donate-mission" id="donate-mission">
    <div class="donate-container">
        <div class="donate-mission__grid">
            <!-- Left column: text -->
            <div class="donate-mission__content">
                <h2 class="donate-section-title"><?php echo esc_html( $mission['heading'] ); ?></h2>

                <?php foreach ( $paragraphs as $p ) : ?>
                    <p><?php echo esc_html( $p ); ?></p>
                <?php endforeach; ?>

                <?php if ( ! empty( $bullets ) ) : ?>
                    <ul class="donate-mission__bullets">
                        <?php foreach ( $bullets as $bullet ) : ?>
                            <li>
                                <span class="donate-mission__bullet-icon" aria-hidden="true">&#10003;</span>
                                <?php echo esc_html( $bullet ); ?>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
            </div>

            <!-- Right column: image with badges -->
            <div class="donate-mission__visual">
                <div class="donate-mission__image-wrap">
                    <img src="<?php echo esc_url( $image_url ?: TONYTECHLAB_DONATE_URL . 'public/images/mission-developer.jpg' ); ?>"
                         alt="<?php echo esc_attr( $mission['heading'] ); ?>"
                         class="donate-mission__image" loading="lazy" />

                    <?php if ( $badge_top ) : ?>
                        <div class="donate-mission__badge donate-mission__badge--top">
                            <?php echo esc_html( $badge_top ); ?>
                            <small>Changing lives through code</small>
                        </div>
                    <?php endif; ?>

                    <?php if ( $badge_bot ) : ?>
                        <div class="donate-mission__badge donate-mission__badge--bottom">
                            <?php echo esc_html( $badge_bot ); ?>
                            <small>Minh bạch tài chính</small>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>
