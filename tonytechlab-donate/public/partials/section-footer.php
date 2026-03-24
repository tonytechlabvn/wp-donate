<?php
/**
 * Frontend — Page footer section (horizontal columns with brand, links, social).
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$footer       = TonyTechLab_Donate_Settings_Manager::get( 'footer' );
$social_links = $footer['social_links'] ?? array();
$links        = $footer['links'] ?? array();

/* SVG icon map for social platforms */
$social_icons = array(
    'facebook' => '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>',
    'youtube'  => '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>',
    'github'   => '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23A11.509 11.509 0 0 1 12 5.803c1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576C20.566 21.797 24 17.3 24 12c0-6.627-5.373-12-12-12z"/></svg>',
);
?>

<section class="donate-page-footer">
    <div class="donate-container">
        <div class="donate-page-footer__grid">
            <!-- Brand -->
            <div class="donate-page-footer__brand">
                <h2 class="donate-page-footer__brand-name"><?php echo esc_html( $footer['heading'] ); ?></h2>
                <p class="donate-page-footer__disclaimer"><?php echo esc_html( $footer['disclaimer'] ); ?></p>
            </div>

            <!-- Links -->
            <?php if ( ! empty( $links ) ) : ?>
                <nav class="donate-page-footer__links" aria-label="Footer navigation">
                    <?php foreach ( $links as $link ) : ?>
                        <a href="<?php echo esc_url( $link['url'] ); ?>">
                            <?php echo esc_html( $link['label'] ); ?>
                        </a>
                    <?php endforeach; ?>
                </nav>
            <?php endif; ?>

            <!-- Social icons -->
            <?php if ( ! empty( $social_links ) ) : ?>
                <div class="donate-page-footer__social">
                    <?php foreach ( $social_links as $link ) :
                        $key  = strtolower( $link['label'] );
                        $icon = $social_icons[ $key ] ?? esc_html( mb_substr( $link['label'], 0, 1 ) );
                    ?>
                        <a href="<?php echo esc_url( $link['url'] ); ?>"
                           target="_blank" rel="noopener noreferrer"
                           aria-label="<?php echo esc_attr( $link['label'] ); ?>">
                            <?php echo $icon; ?>
                        </a>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>

        <p class="donate-page-footer__copyright">
            &copy; <?php echo esc_html( gmdate( 'Y' ) ); ?> <?php echo esc_html( $footer['heading'] ); ?>.
            <?php echo esc_html( $footer['disclaimer'] ); ?>
        </p>
    </div>
</section>
