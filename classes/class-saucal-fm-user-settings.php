<?php

class Saucal_Fabio_Mezzomo_User_Settings {

    public function display_settings_form() {
        $user_id = get_current_user_id();

        $preferences = get_user_meta($user_id, 'saucal_fm_user_preferences', true) ?: [];
        ?>

        <form method="post" action="">
            <?php wp_nonce_field('saucal_fm_user_preferences', 'saucal_fm_nonce'); ?>
            <div id="preferences-container">
                <label for="user_preferences">
                    <?php echo __('Enter Your Preferences:', 'saucal-fabio-mezzomo'); ?>
                </label>
                <?php if (!empty($preferences)): ?>
                    <?php foreach ($preferences as $index => $preference): ?>
                        <div class="preference-field">
                            <input type="text" name="user_preferences[]" value="<?php echo esc_attr($preference); ?>" required>
                            <button type="button" class="remove-preference">Remove</button>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="preference-field">
                        <input type="text" name="user_preferences[]" required>
                        <button type="button" class="remove-preference">Remove</button>
                    </div>
                <?php endif; ?>
            </div>
            <button type="button" id="add-preference">Add Preference</button>
            <button type="submit"><?php echo __('Save Preferences', 'saucal-fabio-mezzomo'); ?></button>
        </form>


        <?php

        if ($this->is_form_submitted()) {
            $this->save_user_preferences();
        }
    }

    private function is_form_submitted() {
        return (
            $_SERVER['REQUEST_METHOD'] === 'POST' &&
            isset($_POST['user_preferences']) &&
            isset($_POST['saucal_fm_nonce']) &&
            wp_verify_nonce($_POST['saucal_fm_nonce'], 'saucal_fm_user_preferences')
        );
    }

    private function save_user_preferences() {
        if ( isset( $_POST['user_preferences'] ) ) {
            $userID = get_current_user_id();

            $preferences = array_filter($_POST['user_preferences'], function($preference) {
                return preg_match('/^[a-zA-Z0-9]+$/', $preference);
            });

            update_user_meta($userID, 'saucal_fm_user_preferences', $preferences);
        }
    }
}

new Saucal_Fabio_Mezzomo_User_Settings();
