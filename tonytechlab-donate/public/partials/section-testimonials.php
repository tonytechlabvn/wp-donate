<?php
/**
 * Frontend — Testimonials section (3-column cards with avatars).
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$testimonials = TonyTechLab_Donate_Settings_Manager::get( 'testimonials' );
$items        = $testimonials['items'] ?? array();

/* Bundled avatar fallbacks keyed by lowercase name */
$bundled_avatars = array(
    'minh anh'   => TONYTECHLAB_DONATE_URL . 'public/images/avatar-minh-anh.jpg',
    'thanh thảo' => TONYTECHLAB_DONATE_URL . 'public/images/avatar-thanh-thao.jpg',
    'tuấn kiệt'  => TONYTECHLAB_DONATE_URL . 'public/images/avatar-tuan-kiet.jpg',
);
?>

<section class="donate-testimonials">
    <div class="donate-container">
        <h2 class="donate-section-title"><?php echo esc_html( $testimonials['heading'] ); ?></h2>

        <div class="donate-testimonials__grid">
            <?php foreach ( $items as $item ) :
                $avatar_url = $item['avatar_url'] ?? '';
                /* Generate initials from name for the fallback avatar */
                $name_parts = explode( ' ', $item['name'] );
                $initials   = '';
                foreach ( $name_parts as $part ) {
                    if ( $part !== '' ) {
                        $initials .= mb_substr( $part, 0, 1 );
                    }
                }
                $initials = mb_strtoupper( mb_substr( $initials, 0, 2 ) );
            ?>
                <blockquote class="donate-testimonials__card">
                    <p class="donate-testimonials__quote">
                        &ldquo;<?php echo esc_html( $item['quote'] ); ?>&rdquo;
                    </p>
                    <footer class="donate-testimonials__author">
                        <div class="donate-testimonials__avatar">
                            <?php
                            $fallback  = $bundled_avatars[ mb_strtolower( $item['name'] ) ] ?? '';
                            $final_url = $avatar_url ?: $fallback;
                            ?>
                            <?php if ( $final_url ) : ?>
                                <img src="<?php echo esc_url( $final_url ); ?>"
                                     alt="<?php echo esc_attr( $item['name'] ); ?>" />
                            <?php else : ?>
                                <?php echo esc_html( $initials ); ?>
                            <?php endif; ?>
                        </div>
                        <div class="donate-testimonials__info">
                            <span class="donate-testimonials__name"><?php echo esc_html( $item['name'] ); ?></span>
                            <span class="donate-testimonials__course"><?php echo esc_html( $item['course'] ); ?></span>
                        </div>
                    </footer>
                </blockquote>
            <?php endforeach; ?>
        </div>
    </div>
</section>
