<?php
/**
 * Template Name: Donate Page
 * Description: TonyTechLab donation page with VietQR and PayPal support.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

get_header();

$sections_dir = get_stylesheet_directory() . '/page-templates/donate-sections';
?>

<main class="donate-page">
    <?php require $sections_dir . '/section-hero.php'; ?>
    <?php require $sections_dir . '/section-mission.php'; ?>
    <?php require $sections_dir . '/section-stats.php'; ?>
    <?php require $sections_dir . '/section-funds.php'; ?>
    <?php require $sections_dir . '/section-testimonials.php'; ?>
    <?php require $sections_dir . '/section-payment.php'; ?>
    <?php require $sections_dir . '/section-faq.php'; ?>
    <?php require $sections_dir . '/section-footer.php'; ?>
</main>

<?php get_footer(); ?>
