<?php

class Saucal_Fabio_Mezzomo_User_Settings {

    public function display_settings_form() {
        $userID = get_current_user_id();

        if ( $this->is_form_submitted() ) {
            $apiHandler = new Saucal_Fabio_Mezzomo_API_Handler();
            if ( $apiHandler->save_user_preferences() ) {
                echo '<div class="saucal-fm-notice success">' . __('Preferences saved successfully!', 'saucal-fabio-mezzomo') . '</div>';
            } else {
                echo '<div class="saucal-fm-notice error">' . __('Error saving preferences.', 'saucal-fabio-mezzomo') . '</div>';
            }
        }

        $preferences = get_user_meta( $userID, 'saucal_fm_user_preferences', true ) ?: [];
        ?>

        <form method="post" action="" class="saucal-fm-form">
            <?php wp_nonce_field( 'saucal_fm_user_preferences', 'saucal_fm_nonce' ); ?>
            <div id="preferences-container">
                <label for="user_preferences">
                    <?php echo __('Enter Your Preferences:', 'saucal-fabio-mezzomo'); ?>
                </label>

                <div class="preference-field"></div>   
                <script>
                    document.addEventListener('DOMContentLoaded', () => {
                        PreferenceManager = new PreferenceManager();
                        PreferenceManager.initPreferences(<?php
                            if ( isset( $preferences ) ) {
                                echo json_encode( $preferences );
                            }
                        ?>);
                    });
                </script>                 
            </div>
            <button type="button" id="add-preference">Add Preference</button>
            <button type="submit"><?php echo __('Save Preferences', 'saucal-fabio-mezzomo'); ?></button>
        </form>


        <?php
    }

    private function is_form_submitted() {
        return (
            $_SERVER[ 'REQUEST_METHOD' ] === 'POST' &&
            isset( $_POST[ 'saucal_fm_nonce' ] ) &&
            wp_verify_nonce( $_POST[ 'saucal_fm_nonce' ], 'saucal_fm_user_preferences' )
        );
    }
}

new Saucal_Fabio_Mezzomo_User_Settings();

?>