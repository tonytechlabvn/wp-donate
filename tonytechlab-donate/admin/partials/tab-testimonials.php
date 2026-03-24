<?php
/**
 * Admin tab — Testimonials repeater settings.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$testimonials = TonyTechLab_Donate_Settings_Manager::get( 'testimonials' );
$items        = $testimonials['items'] ?? array();
?>
<form method="post" action="options.php">
    <?php settings_fields( 'tonytechlab_testimonials_group' ); ?>
    <table class="form-table">
        <tr>
            <th><label for="ttl-testimonials-heading">Section Heading</label></th>
            <td>
                <input type="text" id="ttl-testimonials-heading" name="tonytechlab_testimonials[heading]"
                       value="<?php echo esc_attr( $testimonials['heading'] ); ?>" class="large-text" />
            </td>
        </tr>
    </table>

    <h3>Student Quotes</h3>
    <div class="ttl-repeater" data-option="tonytechlab_testimonials" data-field="items">
        <div class="ttl-repeater__rows">
            <?php foreach ( $items as $i => $item ) : ?>
                <div class="ttl-repeater__row" data-index="<?php echo (int) $i; ?>">
                    <span class="ttl-repeater__handle dashicons dashicons-menu"></span>
                    <div class="ttl-field">
                        <label>Quote</label>
                        <textarea name="tonytechlab_testimonials[items][<?php echo (int) $i; ?>][quote]"
                                  rows="3"><?php echo esc_textarea( $item['quote'] ); ?></textarea>
                    </div>
                    <div class="ttl-field">
                        <label>Name</label>
                        <input type="text" name="tonytechlab_testimonials[items][<?php echo (int) $i; ?>][name]"
                               value="<?php echo esc_attr( $item['name'] ); ?>" />
                    </div>
                    <div class="ttl-field">
                        <label>Course</label>
                        <input type="text" name="tonytechlab_testimonials[items][<?php echo (int) $i; ?>][course]"
                               value="<?php echo esc_attr( $item['course'] ); ?>" />
                    </div>
                    <button type="button" class="button ttl-repeater__remove">Remove</button>
                </div>
            <?php endforeach; ?>
        </div>

        <script type="text/html" class="ttl-repeater__template">
            <div class="ttl-repeater__row" data-index="__INDEX__">
                <span class="ttl-repeater__handle dashicons dashicons-menu"></span>
                <div class="ttl-field">
                    <label>Quote</label>
                    <textarea name="tonytechlab_testimonials[items][__INDEX__][quote]" rows="3"></textarea>
                </div>
                <div class="ttl-field">
                    <label>Name</label>
                    <input type="text" name="tonytechlab_testimonials[items][__INDEX__][name]" value="" />
                </div>
                <div class="ttl-field">
                    <label>Course</label>
                    <input type="text" name="tonytechlab_testimonials[items][__INDEX__][course]" value="" />
                </div>
                <button type="button" class="button ttl-repeater__remove">Remove</button>
            </div>
        </script>
        <button type="button" class="button button-secondary ttl-repeater__add">Add Quote</button>
    </div>

    <?php submit_button(); ?>
</form>
