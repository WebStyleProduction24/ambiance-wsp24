<?php

//Удаляем ненужные нам поля со страницы оформления заказа
add_filter( 'woocommerce_checkout_fields' , 'remove_fields' );

function remove_fields( $fields ) {
  unset($fields['billing']['billing_last_name']);
  unset($fields['billing']['billing_company']); 
  unset($fields['billing']['billing_address_1']);
  unset($fields['billing']['billing_address_2']);
  unset($fields['billing']['billing_postcode']);
  unset($fields['billing']['billing_state']);
  return $fields;
}

// Настраиваем поля оформления заказа
add_filter( 'woocommerce_checkout_fields' , 'address_fields');

function address_fields( $fields ) {
  //Меняем placeholder
  $fields['billing']['billing_first_name']['placeholder'] = 'Ваше имя';
  $fields['billing']['billing_phone']['placeholder'] = 'Ваш номер телефона';
  $fields['billing']['billing_email']['placeholder'] = 'Ваш e-mail';
  // $fields['billing']['billing_city']['value'] = 'Joe';
  $_POST['billing_city'] = 'Воронеж';

  $fields['billing']['billing_city'] = array(
    'label' => 'Город',
    'priority' => 15,
    'required' => true,
    'custom_attributes' => array( 'disabled' => true, ),
  );

  //Добавляем новые поля в раздел Оплата и доставка
  $fields['billing']['billing_street'] = array(
    'label' => 'Улица',
    'placeholder' => 'Название улицы',
    'required' => true,
    'priority' => 20
  );
  $fields['billing']['billing_house'] = array(
    'label' => '№ дома',
    'placeholder' => '№ дома',
    'required' => true,
    'priority' => 30
  );
  $fields['billing']['billing_apartment'] = array(
    'label' => 'Квартира',
    'placeholder' => 'Номер квартиры',
    'required' => true,
    'priority' => 40
  );
  $fields['billing']['billing_entrance'] = array(
    'label' => 'Подъезд',
    'placeholder' => 'Номер подъезда',
    'priority' => 50
  );
  $fields['billing']['billing_floor'] = array(
    'label' => 'Этаж',
    'placeholder' => 'Номер этажа',
    'priority' => 60
  );
  $fields['billing']['on_door_speakerphone'] = array(
    'label' => 'Код домофона',
    'placeholder' => 'Код домофона',
    'priority' => 70
  );

  //Добавляем новые поля в раздел Детали
  $fields['order']['order_payment_method'] = array(
    'type' => 'select', 
    'label' => 'Способ оплаты',
    'required' => true,
    'options'  => array(
      '' => 'Выберите способ оплаты',
      'card' => 'Картой',
      'cash'  => 'Наличными',
    ),
    'priority' => 300
  );
  $fields['order']['order_denomination'] = array(
    'type' => 'select', 
    'label' => 'Для какой купюры должна быть сдача?',
    'required' => false,
    'options'  => array(
      '' => 'Выберите купюру',
      'none' => 'Без сдачи',
      '500' => '500&nbsp;руб',
      '1000'  => '1&nbsp;000&nbsp;руб',
      '2000'  => '2&nbsp;000&nbsp;руб',
      '5000'  => '5&nbsp;000&nbsp;руб',
    ),
    'priority' => 400
  );
  $fields['order']['order_delivery'] = array(
    'type' => 'select', 
    'label' => 'Когда доставить?',
    'options'  => array(
      '' => 'Когда доставить?',
      'quickly' => 'Как можно быстрее',
      'date_and_time'  => 'Выбрать дату и время доставки'
    ),
    'priority' => 450
  );
  $fields['order']['order_delivery_date'] = array(
    'label' => 'Дата доставки',
    'id' => 'datepicker',
    'placeholder' => 'ДД-ММ-ГГГГ',
    'priority' => 475
  );
  $fields['order']['order_delivery_time'] = array(
    'label' => 'Время доставки',
    'id' => 'timepicker',
    'placeholder' => 'ЧЧ-ММ',
    'priority' => 485
  );

  $fields['order']['order_comments']['priority'] = 500; //Устанавливаем поле в конец формы

  return $fields;

}


// Сохраняем метаданные заказа со значением поля
add_action( 'woocommerce_checkout_update_order_meta', 'shipping_apartment_update_order_meta' );

function shipping_apartment_update_order_meta( $order_id ) {
  if ( ! empty( $_POST['billing_street'] ) ) {
    update_post_meta( $order_id, 'billing_street', sanitize_text_field( $_POST['billing_street'] ) );
  }
  if ( ! empty( $_POST['billing_house'] ) ) {
    update_post_meta( $order_id, 'billing_house', sanitize_text_field( $_POST['billing_house'] ) );
  }
  if ( ! empty( $_POST['billing_apartment'] ) ) {
    update_post_meta( $order_id, 'billing_apartment', sanitize_text_field( $_POST['billing_apartment'] ) );
  }
  if ( ! empty( $_POST['billing_entrance'] ) ) {
    update_post_meta( $order_id, 'billing_entrance', sanitize_text_field( $_POST['billing_entrance'] ) );
  }
  if ( ! empty( $_POST['billing_floor'] ) ) {
    update_post_meta( $order_id, 'billing_floor', sanitize_text_field( $_POST['billing_floor'] ) );
  }
  if ( ! empty( $_POST['on_door_speakerphone'] ) ) {
    update_post_meta( $order_id, 'on_door_speakerphone', sanitize_text_field( $_POST['on_door_speakerphone'] ) );
  }
  if ( ! empty( $_POST['order_payment_method'] ) ) {
    if(isset($_POST['order_payment_method'])){
      $method = $_POST['order_payment_method'];
      switch ($method) {
        case 'card':
        $payment_method = 'Картой';
        break;
        case 'cash':
        $payment_method = 'Наличными';
        break;
      }
    }
    update_post_meta( $order_id, 'order_payment_method', sanitize_text_field( $payment_method ) );
  }
  if ( ! empty( $_POST['order_denomination'] ) ) {
    update_post_meta( $order_id, 'order_denomination', sanitize_text_field( $_POST['order_denomination'] ) );
  }
  if ( ! empty( $_POST['order_delivery'] ) ) {
    if(isset($_POST['order_delivery'])){
      $order = $_POST['order_delivery'];
      switch ($order) {
        case 'quickly':
        $order_delivery = 'Как можно быстрее';
        break;
        case 'date_and_time':
        $order_delivery = 'Выбрать дату и время доставки';
        break;
      }
    }
    update_post_meta( $order_id, 'order_delivery', sanitize_text_field( $order_delivery ) );
  }
  if ( ! empty( $_POST['order_delivery_date'] ) ) {
    update_post_meta( $order_id, 'order_delivery_date', sanitize_text_field( $_POST['order_delivery_date'] ) );
  }
  if ( ! empty( $_POST['order_delivery_time'] ) ) {
    update_post_meta( $order_id, 'order_delivery_time', sanitize_text_field( $_POST['order_delivery_time'] ) );
  }
}

//Выводим значения в админке заказа
add_action( 'woocommerce_admin_order_data_after_shipping_address', 'custom_field_display_admin_order_meta', 10, 1 );

function custom_field_display_admin_order_meta($order){
  echo '<p><strong>'.__('Улица').':</strong> ' . get_post_meta( $order->id, 'billing_street', true ) . '</p>';
  echo '<p><strong>'.__('№ дома').':</strong> ' . get_post_meta( $order->id, 'billing_house', true ) . '</p>';
  echo '<p><strong>'.__('№ квартиры').':</strong> ' . get_post_meta( $order->id, 'billing_apartment', true ) . '</p>';
  echo '<p><strong>'.__('№ подъезда').':</strong> ' . get_post_meta( $order->id, 'billing_entrance', true ) . '</p>';
  echo '<p><strong>'.__('Этаж').':</strong> ' . get_post_meta( $order->id, 'billing_floor', true ) . '</p>';
  echo '<p><strong>'.__('Код домофона').':</strong> ' . get_post_meta( $order->id, 'on_door_speakerphone', true ) . '</p>';
  echo '<p><strong>'.__('Способ оплаты').':</strong> ' . get_post_meta( $order->id, 'order_payment_method', true ) . '</p>';
  echo '<p><strong>'.__('Купюра').':</strong> ' . get_post_meta( $order->id, 'order_denomination', true ) . '</p>';
  echo '<p><strong>'.__('Когда доставить?').'</strong> ' . get_post_meta( $order->id, 'order_delivery', true ) . '</p>';
  echo '<p><strong>'.__('Дата доставки').':</strong> ' . get_post_meta( $order->id, 'order_delivery_date', true ) . '</p>';
  echo '<p><strong>'.__('Время доставки').':</strong> ' . get_post_meta( $order->id, 'order_delivery_time', true ) . '</p>';
}

// Выводим значения полей в шаблоне письма с заказом
add_filter('woocommerce_email_order_meta_keys', 'email_checkout_field_order_meta_keys');

function email_checkout_field_order_meta_keys( $keys ) {

  $keys['Улица'] = 'billing_street';
  $keys['№ дома'] = 'billing_house';
  $keys['№ квартиры'] = 'billing_apartment';
  $keys['№ подъезда'] = 'billing_entrance';
  $keys['Этаж'] = 'billing_floor';
  $keys['Код домофона'] = 'on_door_speakerphone';
  $keys['Способ оплаты'] = 'order_payment_method';
  $keys['Купюра'] = 'order_denomination';
  $keys['Когда доставить?'] = 'order_delivery';
  $keys['Дата доставки'] = 'order_delivery_date';
  $keys['Время доставки'] = 'order_delivery_time';

  return $keys;
}

/*
 * Добавляем часть формы к фрагменту
 */
add_filter( 'woocommerce_update_order_review_fragments', 'awoohc_add_update_form_billing', 90 );
function awoohc_add_update_form_billing( $fragments ) {

  $checkout = WC()->checkout();
  ob_start();

  echo '<div class="woocommerce-billing-fields__field-wrapper">';

  $fields = $checkout->get_checkout_fields( 'billing' );
  foreach ( $fields as $key => $field ) {
    if ( isset( $field['country_field'], $fields[ $field['country_field'] ] ) ) {
      $field['country'] = $checkout->get_value( $field['country_field'] );
    }
    woocommerce_form_field( $key, $field, $checkout->get_value( $key ) );
  }

  echo '</div>';

  $art_add_update_form_billing              = ob_get_clean();
  $fragments['.woocommerce-billing-fields'] = $art_add_update_form_billing;

  return $fragments;
}

/*
 * Убираем поля для конкретного способа доставки
 */
add_filter( 'woocommerce_checkout_fields', 'awoohc_override_checkout_fields' );
function awoohc_override_checkout_fields( $fields ) {
   // получаем выбранные метод доставки
 $chosen_methods = WC()->session->get( 'chosen_shipping_methods' );
   // проверяем текущий метод и убираем ненужные поля
 if ( 'local_pickup:2' === $chosen_methods[0] ) {
  unset( $fields['billing']['billing_company'] );
  unset( $fields['billing']['billing_address_1'] );
  unset( $fields['billing']['billing_address_2'] );
  unset( $fields['billing']['billing_city'] );
  unset( $fields['billing']['billing_postcode'] );
  unset( $fields['billing']['billing_country'] );
  unset( $fields['billing']['billing_state'] );
  unset( $fields['billing']['billing_email'] );

  unset( $fields['billing']['billing_street'] );
  unset( $fields['billing']['billing_house'] );
  unset( $fields['billing']['billing_apartment'] );
  unset( $fields['billing']['billing_entrance'] );
  unset( $fields['billing']['billing_floor'] );
  unset( $fields['billing']['on_door_speakerphone'] );

  // unset( $fields['order']['order_payment_method'] );
  // unset( $fields['order']['order_denomination'] );
  // unset( $fields['order']['order_delivery'] );
  // unset( $fields['order']['order_delivery_date'] );
  // unset( $fields['order']['order_delivery_time'] );
}

return $fields;
}


/*
* Обновление формы
*/
add_action( 'wp_footer', 'awoohc_add_script_update_shipping_method' );
function awoohc_add_script_update_shipping_method() {
  if ( is_checkout() ) {
    ?>
    <!--Скроем поле Страна. Если используется поле Страна, то следует убрать скрытие-->
    <style>
      #billing_country_field {
        display: none !important;
      }
    </style>

    <!--Выполняем обновление полей при переключении доставки-->
    <script>
      jQuery(document).ready(function ($) {

        $(document.body).on('updated_checkout updated_shipping_method', function (event, xhr, data) {
          $('input[name^="shipping_method"]').on('change', function () {
            $('.woocommerce-billing-fields__field-wrapperer').block({
              message: null,
              overlayCSS: {
                background: '#fff',
                'z-index': 1000000,
                opacity: 0.3
              }
            });
          });
          var first_name = $('#billing_first_name').val(),
          phone = $('#billing_phone').val();

          $(".woocommerce-billing-fields__field-wrapper").html(xhr.fragments[".woocommerce-billing-fields"]);

          $(".woocommerce-billing-fields__field-wrapper").find('input[name="billing_first_name"]').val(first_name);
          $(".woocommerce-billing-fields__field-wrapper").find('input[name="billing_phone"]').val(phone);

          $('.woocommerce-billing-fields__field-wrapper').unblock();
        });

      });

    </script>
    <?php
  }
}

