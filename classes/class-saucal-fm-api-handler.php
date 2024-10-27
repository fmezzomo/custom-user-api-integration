<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Saucal_Fabio_Mezzomo_API_Handler {

    private $api_url;

    public function __construct() {
        $this->api_url = 'https://httpbin.org/post';
    }

    public function fetch_elements( $elements ) {
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

        $body = wp_remote_retrieve_body( $response );
        $result = json_decode( $body, true );

        return $result;
    }
}

$saucal_fabio_mezzomo_api_handler = new Saucal_Fabio_Mezzomo_API_Handler();