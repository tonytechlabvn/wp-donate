<?php
/**
 * Frontend — How Funds Help section (4-column colored icon cards).
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$funds = TonyTechLab_Donate_Settings_Manager::get( 'funds' );
$items = $funds['items'] ?? array();
?>

<section class="donate-funds">
    <div class="donate-container">
        <h2 class="donate-section-title"><?php echo esc_html( $funds['heading'] ); ?></h2>
        <?php if ( ! empty( $funds['subtitle'] ) ) : ?>
            <p class="donate-section-subtitle"><?php echo esc_html( $funds['subtitle'] ); ?></p>
        <?php endif; ?>

        <div class="donate-funds__grid">
            <?php foreach ( $items as $item ) :
                $color = $item['color'] ?? 'blue';
            ?>
                <div class="donate-funds__card">
                    <div class="donate-funds__icon donate-funds__icon--<?php echo esc_attr( $color ); ?>" aria-hidden="true">
                        <?php echo wp_kses_post( $item['icon'] ); ?>
                    </div>
                    <h3 class="donate-funds__title"><?php echo esc_html( $item['title'] ); ?></h3>
                    <p class="donate-funds__desc"><?php echo esc_html( $item['description'] ); ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
