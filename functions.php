<?php 


add_action( 'wp_enqueue_scripts', 'wsp24_enqueue_styles' );

function wsp24_enqueue_styles() {
	wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
	wp_enqueue_style( 'style', get_stylesheet_uri() );
	wp_enqueue_style( 'woo-style', get_stylesheet_directory_uri() . '/css/woocommerce.css' );
}

add_theme_support( 'woocommerce' );

/*Подключение custom перевода для WooCommerce Cart Tab*/
add_action( 'plugins_loaded', function(){
	$mo_file_path = dirname(__FILE__) . '/lang/'. get_locale() . '.mo';
	load_textdomain( 'wsp24-translate', $mo_file_path );
});

wc_get_template('/templates/date_time_fields.php');
wc_get_template('/templates/order_fields.php');

if (!is_admin()) {
        wp_deregister_script('jquery');
        wp_register_script('jquery', ("https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"), false, '1.12.2');
        wp_enqueue_script('jquery');
}

/*Меняем местами блоки на странице формления заказа*/
remove_action( 'woocommerce_checkout_order_review', 'woocommerce_checkout_payment', 20 );
add_action( 'woocommerce_checkout_payment_wsp24', 'woocommerce_checkout_payment', 20 );

add_filter( 'woocommerce_checkout_fields' , 'custom_override_checkout_fields' );
  
function custom_override_checkout_fields( $fields ) {
  unset($fields['billing']['billing_country']);  //удаляем! тут хранится значение страны оплаты
  unset($fields['shipping']['shipping_country']); ////удаляем! тут хранится значение страны доставки
 
  return $fields;
}