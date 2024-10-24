<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Evita acesso direto
}

// Função para exibir os dados do usuário no WooCommerce My Account
function saucal_fabio_mezzomo_display_user_data() {
    echo '<h3>' . __( 'Custom Data', 'saucal-fabio-mezzomo' ) . '</h3>';
}