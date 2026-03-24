<?php
/**
 * Admin tab — Mission section settings (two-column with image and bullets).
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$mission    = TonyTechLab_Donate_Settings_Manager::get( 'mission' );
$paragraphs = $mission['paragraphs'] ?? array( '' );
$bullets    = $mission['bullets'] ?? array( '' );
if ( empty( $paragraphs ) ) {
    $paragraphs = array( '' );
}
if ( empty( $bullets ) ) {
    $bullets = array( '' );
}
?>
<form method="post" action="options.php">
    <?php settings_fields( 'tonytechlab_mission_group' ); ?>
    <table class="form-table">
        <tr>
            <th><label for="ttl-mission-heading">Section Heading</label></th>
            <td>
                <input type="text" id="ttl-mission-heading" name="tonytechlab_mission[heading]"
                       value="<?php echo esc_attr( $mission['heading'] ); ?>" class="large-text" />
            </td>
        </tr>
        <tr>
            <th>Paragraphs</th>
            <td>
                <div class="ttl-paragraphs">
                    <div class="ttl-paragraphs__list">
                        <?php foreach ( $paragraphs as $i => $p ) : ?>
                            <div class="ttl-paragraphs__item">
                                <textarea name="tonytechlab_mission[paragraphs][<?php echo (int) $i; ?>]"
                                          rows="3" class="large-text"><?php echo esc_textarea( $p ); ?></textarea>
                                <button type="button" class="button ttl-paragraphs__remove">Remove</button>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <button type="button" class="button button-secondary ttl-paragraphs__add">Add Paragraph</button>
                </div>
            </td>
        </tr>
        <tr>
            <th>Bullet Points</th>
            <td>
                <div class="ttl-paragraphs" data-type="bullets">
                    <div class="ttl-paragraphs__list">
                        <?php foreach ( $bullets as $i => $b ) : ?>
                            <div class="ttl-paragraphs__item">
                                <input type="text" name="tonytechlab_mission[bullets][<?php echo (int) $i; ?>]"
                                       value="<?php echo esc_attr( $b ); ?>" class="large-text" />
                                <button type="button" class="button ttl-paragraphs__remove">Remove</button>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <button type="button" class="button button-secondary ttl-paragraphs__add">Add Bullet</button>
                </div>
            </td>
        </tr>
        <tr>
            <th><label for="ttl-mission-image">Mission Image URL</label></th>
            <td>
                <input type="url" id="ttl-mission-image" name="tonytechlab_mission[image_url]"
                       value="<?php echo esc_url( $mission['image_url'] ?? '' ); ?>" class="large-text" />
                <p class="description">URL of the mission section image. Leave empty for a gradient placeholder.</p>
            </td>
        </tr>
        <tr>
            <th><label for="ttl-mission-badge-top">Top Badge Text</label></th>
            <td>
                <input type="text" id="ttl-mission-badge-top" name="tonytechlab_mission[badge_top]"
                       value="<?php echo esc_attr( $mission['badge_top'] ?? '' ); ?>" class="regular-text" />
                <p class="description">Floating badge on top-right of the image (e.g. "Impactful").</p>
            </td>
        </tr>
        <tr>
            <th><label for="ttl-mission-badge-bottom">Bottom Badge Text</label></th>
            <td>
                <input type="text" id="ttl-mission-badge-bottom" name="tonytechlab_mission[badge_bottom]"
                       value="<?php echo esc_attr( $mission['badge_bottom'] ?? '' ); ?>" class="regular-text" />
                <p class="description">Floating badge on bottom-left of the image (e.g. "100%").</p>
            </td>
        </tr>
    </table>
    <?php submit_button(); ?>
</form>
