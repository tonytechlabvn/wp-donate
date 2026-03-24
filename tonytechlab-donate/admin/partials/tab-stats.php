<?php
/**
 * Admin tab — Impact Stats repeater settings.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$stats = TonyTechLab_Donate_Settings_Manager::get( 'stats' );
$items = $stats['items'] ?? array();
?>
<form method="post" action="options.php">
    <?php settings_fields( 'tonytechlab_stats_group' ); ?>
    <table class="form-table">
        <tr>
            <th><label for="ttl-stats-heading">Section Heading</label></th>
            <td>
                <input type="text" id="ttl-stats-heading" name="tonytechlab_stats[heading]"
                       value="<?php echo esc_attr( $stats['heading'] ); ?>" class="large-text" />
            </td>
        </tr>
    </table>

    <h3>Stat Items</h3>
    <div class="ttl-repeater" data-option="tonytechlab_stats" data-field="items">
        <div class="ttl-repeater__rows">
            <?php foreach ( $items as $i => $item ) : ?>
                <div class="ttl-repeater__row" data-index="<?php echo (int) $i; ?>">
                    <span class="ttl-repeater__handle dashicons dashicons-menu"></span>
                    <div class="ttl-field ttl-field--small">
                        <label>Number</label>
                        <input type="number" name="tonytechlab_stats[items][<?php echo (int) $i; ?>][number]"
                               value="<?php echo absint( $item['number'] ); ?>" min="0" />
                    </div>
                    <div class="ttl-field ttl-field--small">
                        <label>Suffix</label>
                        <input type="text" name="tonytechlab_stats[items][<?php echo (int) $i; ?>][suffix]"
                               value="<?php echo esc_attr( $item['suffix'] ); ?>" placeholder="e.g. %" />
                    </div>
                    <div class="ttl-field">
                        <label>Label</label>
                        <input type="text" name="tonytechlab_stats[items][<?php echo (int) $i; ?>][label]"
                               value="<?php echo esc_attr( $item['label'] ); ?>" />
                    </div>
                    <button type="button" class="button ttl-repeater__remove">Remove</button>
                </div>
            <?php endforeach; ?>
        </div>

        <script type="text/html" class="ttl-repeater__template">
            <div class="ttl-repeater__row" data-index="__INDEX__">
                <span class="ttl-repeater__handle dashicons dashicons-menu"></span>
                <div class="ttl-field ttl-field--small">
                    <label>Number</label>
                    <input type="number" name="tonytechlab_stats[items][__INDEX__][number]" value="0" min="0" />
                </div>
                <div class="ttl-field ttl-field--small">
                    <label>Suffix</label>
                    <input type="text" name="tonytechlab_stats[items][__INDEX__][suffix]" value="" placeholder="e.g. %" />
                </div>
                <div class="ttl-field">
                    <label>Label</label>
                    <input type="text" name="tonytechlab_stats[items][__INDEX__][label]" value="" />
                </div>
                <button type="button" class="button ttl-repeater__remove">Remove</button>
            </div>
        </script>
        <button type="button" class="button button-secondary ttl-repeater__add">Add Stat</button>
    </div>

    <?php submit_button(); ?>
</form>
