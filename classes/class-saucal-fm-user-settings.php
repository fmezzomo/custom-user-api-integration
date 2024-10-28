<?php

class Saucal_Fabio_Mezzomo_User_Settings {

    public function display_settings_form() {
        $user_id = get_current_user_id();

        if ($this->is_form_submitted()) {
            $this->save_user_preferences();
        }

        $preferences = get_user_meta($user_id, 'saucal_fm_user_preferences', true) ?: [];
        ?>

        <form method="post" action="" class="saucal-fm-form">
            <?php wp_nonce_field('saucal_fm_user_preferences', 'saucal_fm_nonce'); ?>
            <div id="preferences-container">
                <label for="user_preferences">
                    <?php echo __('Enter Your Preferences:', 'saucal-fabio-mezzomo'); ?>
                </label>
                <?php if (!empty($preferences)): ?>
                    <?php foreach ($preferences as $index => $preference): ?>
                        <div class="preference-field">
                            <input type="text" name="user_preferences[]" value="<?php echo esc_attr($preference); ?>" required>
                            <button type="button" class="remove-preference">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M3 6H5H21" stroke="#e74c3c" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M8 6V4C8 3.44772 8.44772 3 9 3H15C15.5523 3 16 3.44772 16 4V6M19 6V20C19 20.5523 18.5523 21 18 21H6C5.44772 21 5 20.5523 5 20V6H19Z" stroke="#e74c3c" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </button>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="preference-field">
                        <input type="text" name="user_preferences[]" required>
                        <button type="button" class="remove-preference">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M3 6H5H21" stroke="#e74c3c" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M8 6V4C8 3.44772 8.44772 3 9 3H15C15.5523 3 16 3.44772 16 4V6M19 6V20C19 20.5523 18.5523 21 18 21H6C5.44772 21 5 20.5523 5 20V6H19Z" stroke="#e74c3c" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </button>
                    </div>
                <?php endif; ?>
            </div>
            <button type="button" id="add-preference">Add Preference</button>
            <button type="submit"><?php echo __('Save Preferences', 'saucal-fabio-mezzomo'); ?></button>
        </form>


        <?php
    }

    private function is_form_submitted() {
        return (
            $_SERVER['REQUEST_METHOD'] === 'POST' &&
            isset($_POST['saucal_fm_nonce']) &&
            wp_verify_nonce($_POST['saucal_fm_nonce'], 'saucal_fm_user_preferences')
        );
    }

    private function save_user_preferences() {
        $userID = get_current_user_id();

        if ( isset( $_POST['user_preferences'] ) ) {
            $preferences = array_filter($_POST['user_preferences'], function($preference) {
                $preference = sanitize_text_field($preference);
                return preg_match('/^[a-zA-Z0-9]+$/', $preference);
            });

            update_user_meta($userID, 'saucal_fm_user_preferences', $preferences);
        } else {
            delete_user_meta($userID, 'saucal_fm_user_preferences');
        }
    }
}

new Saucal_Fabio_Mezzomo_User_Settings();
