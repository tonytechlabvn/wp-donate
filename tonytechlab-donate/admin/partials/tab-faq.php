<?php
/**
 * Admin tab — FAQ repeater settings.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$faq   = TonyTechLab_Donate_Settings_Manager::get( 'faq' );
$items = $faq['items'] ?? array();
?>
<form method="post" action="options.php">
    <?php settings_fields( 'tonytechlab_faq_group' ); ?>
    <table class="form-table">
        <tr>
            <th><label for="ttl-faq-heading">Section Heading</label></th>
            <td>
                <input type="text" id="ttl-faq-heading" name="tonytechlab_faq[heading]"
                       value="<?php echo esc_attr( $faq['heading'] ); ?>" class="large-text" />
            </td>
        </tr>
    </table>

    <h3>Questions &amp; Answers</h3>
    <div class="ttl-repeater" data-option="tonytechlab_faq" data-field="items">
        <div class="ttl-repeater__rows">
            <?php foreach ( $items as $i => $item ) : ?>
                <div class="ttl-repeater__row" data-index="<?php echo (int) $i; ?>">
                    <span class="ttl-repeater__handle dashicons dashicons-menu"></span>
                    <div class="ttl-field">
                        <label>Question</label>
                        <input type="text" name="tonytechlab_faq[items][<?php echo (int) $i; ?>][question]"
                               value="<?php echo esc_attr( $item['question'] ); ?>" />
                    </div>
                    <div class="ttl-field">
                        <label>Answer</label>
                        <textarea name="tonytechlab_faq[items][<?php echo (int) $i; ?>][answer]"
                                  rows="3"><?php echo esc_textarea( $item['answer'] ); ?></textarea>
                    </div>
                    <button type="button" class="button ttl-repeater__remove">Remove</button>
                </div>
            <?php endforeach; ?>
        </div>

        <script type="text/html" class="ttl-repeater__template">
            <div class="ttl-repeater__row" data-index="__INDEX__">
                <span class="ttl-repeater__handle dashicons dashicons-menu"></span>
                <div class="ttl-field">
                    <label>Question</label>
                    <input type="text" name="tonytechlab_faq[items][__INDEX__][question]" value="" />
                </div>
                <div class="ttl-field">
                    <label>Answer</label>
                    <textarea name="tonytechlab_faq[items][__INDEX__][answer]" rows="3"></textarea>
                </div>
                <button type="button" class="button ttl-repeater__remove">Remove</button>
            </div>
        </script>
        <button type="button" class="button button-secondary ttl-repeater__add">Add Question</button>
    </div>

    <?php submit_button(); ?>
</form>
