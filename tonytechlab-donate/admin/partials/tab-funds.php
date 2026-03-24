<?php
/**
 * Admin tab — How Funds Help repeater settings (with color variant).
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$funds = TonyTechLab_Donate_Settings_Manager::get( 'funds' );
$items = $funds['items'] ?? array();
?>
<form method="post" action="options.php">
    <?php settings_fields( 'tonytechlab_funds_group' ); ?>
    <table class="form-table">
        <tr>
            <th><label for="ttl-funds-heading">Section Heading</label></th>
            <td>
                <input type="text" id="ttl-funds-heading" name="tonytechlab_funds[heading]"
                       value="<?php echo esc_attr( $funds['heading'] ); ?>" class="large-text" />
            </td>
        </tr>
        <tr>
            <th><label for="ttl-funds-subtitle">Subtitle</label></th>
            <td>
                <input type="text" id="ttl-funds-subtitle" name="tonytechlab_funds[subtitle]"
                       value="<?php echo esc_attr( $funds['subtitle'] ?? '' ); ?>" class="large-text" />
            </td>
        </tr>
    </table>

    <h3>Fund Allocation Cards</h3>
    <div class="ttl-repeater" data-option="tonytechlab_funds" data-field="items">
        <div class="ttl-repeater__rows">
            <?php foreach ( $items as $i => $item ) : ?>
                <div class="ttl-repeater__row" data-index="<?php echo (int) $i; ?>">
                    <span class="ttl-repeater__handle dashicons dashicons-menu"></span>
                    <div class="ttl-field ttl-field--small">
                        <label>Icon</label>
                        <input type="text" name="tonytechlab_funds[items][<?php echo (int) $i; ?>][icon]"
                               value="<?php echo esc_attr( $item['icon'] ); ?>" />
                    </div>
                    <div class="ttl-field">
                        <label>Title</label>
                        <input type="text" name="tonytechlab_funds[items][<?php echo (int) $i; ?>][title]"
                               value="<?php echo esc_attr( $item['title'] ); ?>" />
                    </div>
                    <div class="ttl-field">
                        <label>Description</label>
                        <textarea name="tonytechlab_funds[items][<?php echo (int) $i; ?>][description]"
                                  rows="2"><?php echo esc_textarea( $item['description'] ); ?></textarea>
                    </div>
                    <div class="ttl-field ttl-field--small">
                        <label>%</label>
                        <input type="number" name="tonytechlab_funds[items][<?php echo (int) $i; ?>][percentage]"
                               value="<?php echo absint( $item['percentage'] ); ?>" min="0" max="100" />
                    </div>
                    <div class="ttl-field ttl-field--small">
                        <label>Color</label>
                        <select name="tonytechlab_funds[items][<?php echo (int) $i; ?>][color]">
                            <?php foreach ( array( 'blue', 'green', 'purple', 'orange' ) as $c ) : ?>
                                <option value="<?php echo esc_attr( $c ); ?>"
                                    <?php selected( $item['color'] ?? 'blue', $c ); ?>>
                                    <?php echo esc_html( ucfirst( $c ) ); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <button type="button" class="button ttl-repeater__remove">Remove</button>
                </div>
            <?php endforeach; ?>
        </div>

        <script type="text/html" class="ttl-repeater__template">
            <div class="ttl-repeater__row" data-index="__INDEX__">
                <span class="ttl-repeater__handle dashicons dashicons-menu"></span>
                <div class="ttl-field ttl-field--small">
                    <label>Icon</label>
                    <input type="text" name="tonytechlab_funds[items][__INDEX__][icon]" value="" />
                </div>
                <div class="ttl-field">
                    <label>Title</label>
                    <input type="text" name="tonytechlab_funds[items][__INDEX__][title]" value="" />
                </div>
                <div class="ttl-field">
                    <label>Description</label>
                    <textarea name="tonytechlab_funds[items][__INDEX__][description]" rows="2"></textarea>
                </div>
                <div class="ttl-field ttl-field--small">
                    <label>%</label>
                    <input type="number" name="tonytechlab_funds[items][__INDEX__][percentage]" value="0" min="0" max="100" />
                </div>
                <div class="ttl-field ttl-field--small">
                    <label>Color</label>
                    <select name="tonytechlab_funds[items][__INDEX__][color]">
                        <option value="blue">Blue</option>
                        <option value="green">Green</option>
                        <option value="purple">Purple</option>
                        <option value="orange">Orange</option>
                    </select>
                </div>
                <button type="button" class="button ttl-repeater__remove">Remove</button>
            </div>
        </script>
        <button type="button" class="button button-secondary ttl-repeater__add">Add Card</button>
    </div>

    <?php submit_button(); ?>
</form>
