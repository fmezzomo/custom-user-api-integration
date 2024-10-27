<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

function fetch_elements_from_api( $elements ) {
    // Example API URL, adjust as needed
    $api_url = 'https://httpbin.org/post';
    
    // Prepare the data for the API request
    $data = array(
        'elements' => $elements,
        'user_id'  => get_current_user_id(),
    );
    
    // Make the API request using wp_remote_post or wp_remote_get
    $response = wp_remote_post( $api_url, array(
        'body' => json_encode($data),
        'headers' => array(
            'Content-Type' => 'application/json',
        ),
    ));

    if ( is_wp_error( $response ) ) {
        echo 'Error with the API request: ' . $response->get_error_message();
        return;
    }

    $body = wp_remote_retrieve_body( $response );
    $result = json_decode( $body, true );

    return $result;
}
