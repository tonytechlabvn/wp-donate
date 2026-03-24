<?php
/**
 * Admin tab — Footer section settings (contact + social links repeater).
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$footer       = TonyTechLab_Donate_Settings_Manager::get( 'footer' );
$social_links = $footer['social_links'] ?? array();
?>
<form method="post" action="options.php">
    <?php settings_fields( 'tonytechlab_footer_group' ); ?>
    <table class="form-table">
        <tr>
            <th><label for="ttl-footer-heading">Section Heading</label></th>
            <td>
                <input type="text" id="ttl-footer-heading" name="tonytechlab_footer[heading]"
                       value="<?php echo esc_attr( $footer['heading'] ); ?>" class="large-text" />
            </td>
        </tr>
        <tr>
            <th><label for="ttl-footer-email">Contact Email</label></th>
            <td>
                <input type="email" id="ttl-footer-email" name="tonytechlab_footer[email]"
                       value="<?php echo esc_attr( $footer['email'] ); ?>" class="regular-text" />
            </td>
        </tr>
        <tr>
            <th><label for="ttl-footer-disclaimer">Disclaimer</label></th>
            <td>
                <textarea id="ttl-footer-disclaimer" name="tonytechlab_footer[disclaimer]"
                          rows="3" class="large-text"><?php echo esc_textarea( $footer['disclaimer'] ); ?></textarea>
            </td>
        </tr>
    </table>

    <h3>Social Links</h3>
    <div class="ttl-repeater" data-option="tonytechlab_footer" data-field="social_links">
        <div class="ttl-repeater__rows">
            <?php foreach ( $social_links as $i => $link ) : ?>
                <div class="ttl-repeater__row" data-index="<?php echo (int) $i; ?>">
                    <span class="ttl-repeater__handle dashicons dashicons-menu"></span>
                    <div class="ttl-field">
                        <label>Label</label>
                        <input type="text" name="tonytechlab_footer[social_links][<?php echo (int) $i; ?>][label]"
                               value="<?php echo esc_attr( $link['label'] ); ?>" />
                    </div>
                    <div class="ttl-field">
                        <label>URL</label>
                        <input type="url" name="tonytechlab_footer[social_links][<?php echo (int) $i; ?>][url]"
                               value="<?php echo esc_url( $link['url'] ); ?>" />
                    </div>
                    <button type="button" class="button ttl-repeater__remove">Remove</button>
                </div>
            <?php endforeach; ?>
        </div>

        <script type="text/html" class="ttl-repeater__template">
            <div class="ttl-repeater__row" data-index="__INDEX__">
                <span class="ttl-repeater__handle dashicons dashicons-menu"></span>
                <div class="ttl-field">
                    <label>Label</label>
                    <input type="text" name="tonytechlab_footer[social_links][__INDEX__][label]" value="" />
                </div>
                <div class="ttl-field">
                    <label>URL</label>
                    <input type="url" name="tonytechlab_footer[social_links][__INDEX__][url]" value="" />
                </div>
                <button type="button" class="button ttl-repeater__remove">Remove</button>
            </div>
        </script>
        <button type="button" class="button button-secondary ttl-repeater__add">Add Link</button>
    </div>

    <?php submit_button(); ?>
</form>
