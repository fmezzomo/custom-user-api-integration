<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Saucal_Fabio_Mezzomo_API_Handler {

    private $api_url;
    private $cacheTime = HOUR_IN_SECONDS;  // Cache for 1 hour

    public function __construct() {
        $this->api_url = 'https://httpbin.org/post';
    }

    public function fetch_elements() {

        $userID   = get_current_user_id();
        $elements = $this->fetch_user_preferences( $userID );

        if ( ! $elements ) {
            $elements = get_user_meta( $userID, 'saucal_fm_user_preferences', true );
        }

        $data = array(
            'elements' => $elements,
            'user_id'  => get_current_user_id(),
        );

        $response = wp_remote_post( $this->api_url, array(
            'body' => json_encode( $data ),
            'headers' => array(
                'Content-Type' => 'application/json',
            ),
        ));

        if ( is_wp_error( $response ) ) {
            error_log( 'Erro na requisição da API: ' . $response->get_error_message() );
            return null;
        }

        $body   = wp_remote_retrieve_body( $response );
        $result = json_decode( $body, true );

        return $result;
    }

    function fetch_user_preferences( $userID ) {
        $transientKey = 'user_preferences_' . $userID;
        $preferences  = get_transient( $transientKey );

        if ( false === $preferences ) {
            // Data not cached, fetch it from user meta
            $preferences = get_user_meta( $userID, 'saucal_fm_user_preferences', true );
            set_transient( $transientKey, $preferences, $this->cacheTime );
        }
    
        return $preferences;
    }

    public function save_user_preferences() {
        $userID  = get_current_user_id();
        $updated = false;

        if ( isset( $_POST[ 'user_preferences' ] ) ) {
            $preferences = array_filter( $_POST[ 'user_preferences' ], function( $preference ) {
                $preference = sanitize_text_field( $preference );
                return preg_match( '/^[a-zA-Z0-9]+$/', $preference );
            });

            $updated = update_user_meta( $userID, 'saucal_fm_user_preferences', $preferences );
        } else {
            $updated = delete_user_meta( $userID, 'saucal_fm_user_preferences' );
        }

        if ( $updated ) {
            $transientKey = 'user_preferences_' . $userID;
            set_transient( $transientKey, isset( $preferences ) ? $preferences : [], $this->cacheTime );
        }

        return $updated;
    }
}

$saucal_fabio_mezzomo_api_handler = new Saucal_Fabio_Mezzomo_API_Handler();