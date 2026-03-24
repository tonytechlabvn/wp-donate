<?php
/**
 * Frontend — Mission section (two-column with dual image grid and badges).
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

/* Bundled fallback images */
$img_students  = TONYTECHLAB_DONATE_URL . 'public/images/mission-students.jpg';
$img_developer = $image_url ?: TONYTECHLAB_DONATE_URL . 'public/images/mission-developer.jpg';
?>

<section class="donate-mission" id="donate-mission">
    <div class="donate-container">
        <div class="donate-mission__grid">
            <!-- Left column: text -->
            <div class="donate-mission__content">
                <h2 class="donate-section-title"><?php echo esc_html( $mission['heading'] ); ?></h2>
                <div class="donate-mission__divider"></div>

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

            <!-- Right column: dual image grid with badges -->
            <div class="donate-mission__visual">
                <div class="donate-mission__image-grid">
                    <div class="donate-mission__image-grid-col">
                        <img src="<?php echo esc_url( $img_students ); ?>"
                             alt="Students collaborating"
                             class="donate-mission__image" loading="lazy" />

                        <?php if ( $badge_bot ) : ?>
                            <div class="donate-mission__badge donate-mission__badge--primary">
                                <span class="donate-mission__badge-value"><?php echo esc_html( $badge_bot ); ?></span>
                                <span class="donate-mission__badge-label">Minh bạch tài chính</span>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="donate-mission__image-grid-col">
                        <?php if ( $badge_top ) : ?>
                            <div class="donate-mission__badge donate-mission__badge--secondary">
                                <span class="donate-mission__badge-value"><?php echo esc_html( $badge_top ); ?></span>
                                <span class="donate-mission__badge-label">Changing lives through code</span>
                            </div>
                        <?php endif; ?>

                        <img src="<?php echo esc_url( $img_developer ); ?>"
                             alt="Developer coding"
                             class="donate-mission__image" loading="lazy" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
