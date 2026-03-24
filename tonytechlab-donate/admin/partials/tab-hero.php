<?php
/**
 * Admin tab — Hero section settings (two-column design with image).
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$hero = TonyTechLab_Donate_Settings_Manager::get( 'hero' );
?>
<form method="post" action="options.php">
    <?php settings_fields( 'tonytechlab_hero_group' ); ?>
    <table class="form-table">
        <tr>
            <th><label for="ttl-hero-tag">Tag Text</label></th>
            <td>
                <input type="text" id="ttl-hero-tag" name="tonytechlab_hero[tag_text]"
                       value="<?php echo esc_attr( $hero['tag_text'] ?? '' ); ?>" class="regular-text" />
                <p class="description">Small label above the headline (e.g. "KỸ THUẬT & TƯƠNG LAI").</p>
            </td>
        </tr>
        <tr>
            <th><label for="ttl-hero-title">Headline</label></th>
            <td>
                <input type="text" id="ttl-hero-title" name="tonytechlab_hero[title]"
                       value="<?php echo esc_attr( $hero['title'] ); ?>" class="large-text" />
                <p class="description">Main heading displayed in the hero section.</p>
            </td>
        </tr>
        <tr>
            <th><label for="ttl-hero-highlight">Title Highlight</label></th>
            <td>
                <input type="text" id="ttl-hero-highlight" name="tonytechlab_hero[title_highlight]"
                       value="<?php echo esc_attr( $hero['title_highlight'] ?? '' ); ?>" class="regular-text" />
                <p class="description">Portion of the title to render with a gradient highlight effect.</p>
            </td>
        </tr>
        <tr>
            <th><label for="ttl-hero-subtitle">Subtitle</label></th>
            <td>
                <textarea id="ttl-hero-subtitle" name="tonytechlab_hero[subtitle]"
                          rows="3" class="large-text"><?php echo esc_textarea( $hero['subtitle'] ); ?></textarea>
            </td>
        </tr>
        <tr>
            <th><label for="ttl-hero-cta">Primary CTA Text</label></th>
            <td>
                <input type="text" id="ttl-hero-cta" name="tonytechlab_hero[cta_text]"
                       value="<?php echo esc_attr( $hero['cta_text'] ); ?>" class="regular-text" />
            </td>
        </tr>
        <tr>
            <th><label for="ttl-hero-cta2">Secondary CTA Text</label></th>
            <td>
                <input type="text" id="ttl-hero-cta2" name="tonytechlab_hero[secondary_cta_text]"
                       value="<?php echo esc_attr( $hero['secondary_cta_text'] ?? '' ); ?>" class="regular-text" />
                <p class="description">Leave empty to hide the secondary button.</p>
            </td>
        </tr>
        <tr>
            <th><label for="ttl-hero-image">Hero Image URL</label></th>
            <td>
                <input type="url" id="ttl-hero-image" name="tonytechlab_hero[image_url]"
                       value="<?php echo esc_url( $hero['image_url'] ?? '' ); ?>" class="large-text" />
                <p class="description">URL of the hero image. Leave empty for a gradient placeholder.</p>
            </td>
        </tr>
        <tr>
            <th><label for="ttl-hero-badge-title">Badge Title</label></th>
            <td>
                <input type="text" id="ttl-hero-badge-title" name="tonytechlab_hero[badge_title]"
                       value="<?php echo esc_attr( $hero['badge_title'] ?? '' ); ?>" class="regular-text" />
            </td>
        </tr>
        <tr>
            <th><label for="ttl-hero-badge-desc">Badge Description</label></th>
            <td>
                <input type="text" id="ttl-hero-badge-desc" name="tonytechlab_hero[badge_description]"
                       value="<?php echo esc_attr( $hero['badge_description'] ?? '' ); ?>" class="large-text" />
            </td>
        </tr>
    </table>
    <?php submit_button(); ?>
</form>
