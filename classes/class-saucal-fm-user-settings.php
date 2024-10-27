<?php

class Saucal_Fabio_Mezzomo_User_Settings {

    public function __construct() {
    }

    public function display_settings_form() {
        $user_id = get_current_user_id();
        $preferences = get_user_meta( $user_id, 'saucal_fm_user_preferences', true );
        ?>
        <form method="post" action="">
            <?php wp_nonce_field( 'saucal_fm_save_preferences', 'saucal_fm_nonce' ); ?>
            <label for="user_preferences">
                <?php echo __('Enter Your Preferences (comma-separated):', 'saucal-fabio-mezzomo'); ?>
            </label>
            <input type="text" id="user_preferences" name="user_preferences" value="<?php echo esc_attr( implode(',', (array) $preferences ) ); ?>" required>
            <button type="submit">Save Preferences</button>
        </form>
        <?php

        if ( $this->is_form_submitted() ) {
            $this->save_user_preferences();
        }
    }

    private function is_form_submitted() {
        return (
            $_SERVER['REQUEST_METHOD'] === 'POST' &&
            isset( $_POST['user_preferences'] ) &&
            isset( $_POST['saucal_fm_nonce'] ) &&
            wp_verify_nonce( $_POST['saucal_fm_nonce'], 'saucal_fm_save_preferences' )
        );
    }

    private function save_user_preferences() {
        if ( isset( $_POST['user_preferences'] ) && wp_verify_nonce( $_POST['saucal_fm_nonce'], 'saucal_fm_save_preferences' ) ) {
            $user_id = get_current_user_id();
            $preferences = sanitize_text_field( $_POST['user_preferences'] );
            update_user_meta( $user_id, 'saucal_fm_user_preferences', explode(',', $preferences) );
        }
    }
}

new Saucal_Fabio_Mezzomo_User_Settings();
