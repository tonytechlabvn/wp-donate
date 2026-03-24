<?php
/**
 * Frontend — Impact Stats section (clean horizontal row).
 * HTML shows real values for SEO/no-JS; JS resets to 0 and animates.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$stats = TonyTechLab_Donate_Settings_Manager::get( 'stats' );
$items = $stats['items'] ?? array();
?>

<section class="donate-stats">
    <div class="donate-container">
        <div class="donate-stats__grid">
            <?php foreach ( $items as $item ) : ?>
                <div class="donate-stats__card">
                    <span class="donate-stats__number" data-target="<?php echo absint( $item['number'] ); ?>">
                        <?php echo esc_html( number_format( $item['number'] ) ); ?>
                    </span>
                    <?php if ( ! empty( $item['suffix'] ) ) : ?>
                        <span class="donate-stats__suffix"><?php echo esc_html( $item['suffix'] ); ?></span>
                    <?php endif; ?>
                    <span class="donate-stats__label"><?php echo esc_html( $item['label'] ); ?></span>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
