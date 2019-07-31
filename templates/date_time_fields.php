<?php
datepicker_js();

function datepicker_js(){
	// подключаем все необходимые скрипты: jQuery, jquery-ui, datepicker
//	wp_enqueue_script('jquery-ui-datepicker');
	// wp_enqueue_script('jquery-ui-datetimepicker-js', get_stylesheet_directory_uri() . '/js/jquery.datetimepicker.full.min.js' );
	wp_enqueue_script('jquery-ui-datetimepicker-js', get_stylesheet_directory_uri() . '/js/jquery-ui-timepicker-addon.js' );
	wp_enqueue_script('jquery-ui-timepicker-addon-i18n', get_stylesheet_directory_uri() . '/js/i18n/jquery-ui-timepicker-addon-i18n.min.js' );
	wp_enqueue_script('jquery-ui-sliderAccess-js', get_stylesheet_directory_uri() . '/js/jquery-ui-sliderAccess.js' );
	// подключаем нужные css стили
	wp_enqueue_style('jquery-ui', 'https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css', false, null );
	// wp_enqueue_style('jquery-ui-datetimepicker-css', get_stylesheet_directory_uri() . '/css/jquery.datetimepicker.css' );
	wp_enqueue_style('jquery-ui-datetimepicker-css', get_stylesheet_directory_uri() . '/css/jquery-ui-timepicker-addon.css' );

	// инициализируем datepicker
	if( is_admin() )
		add_action('admin_footer', 'init_datepicker', 99 ); // для админки
	else
		add_action('wp_footer', 'init_datepicker', 99 ); // для админки

	function init_datepicker(){ ?>

		<script type="text/javascript">
			jQuery(document).ready(function($){
				'use strict';
			// настройки по умолчанию. Их можно добавить в имеющийся js файл, 
			// если datepicker будет использоваться повсеместно на проекте и предполагается запускать его с разными настройками
			$.datepicker.setDefaults({
				closeText: 'Закрыть',
				prevText: '<Пред',
				nextText: 'След>',
				currentText: 'Сегодня',
				monthNames: ['Январь','Февраль','Март','Апрель','Май','Июнь','Июль','Август','Сентябрь','Октябрь','Ноябрь','Декабрь'],
				monthNamesShort: ['Янв','Фев','Мар','Апр','Май','Июн','Июл','Авг','Сен','Окт','Ноя','Дек'],
				dayNames: ['воскресенье','понедельник','вторник','среда','четверг','пятница','суббота'],
				dayNamesShort: ['вск','пнд','втр','срд','чтв','птн','сбт'],
				dayNamesMin: ['Вс','Пн','Вт','Ср','Чт','Пт','Сб'],
				weekHeader: 'Нед',
				dateFormat: 'dd-mm-yy',
				firstDay: 1,
				showAnim: 'slideDown',
				isRTL: false,
				showMonthAfterYear: false,
				yearSuffix: ''
			} );


			// $.timepicker.setDefaults({
			// 	timeOnlyTitle: 'Выберите время',
			// 	timeText: 'Время',
			// 	hourText: 'Часы',
			// 	minuteText: 'Минуты',
			// 	secondText: 'Секунды',
			// 	millisecText: 'Миллисекунды',
			// 	timezoneText: 'Часовой пояс',
			// 	currentText: 'Сейчас',
			// 	closeText: 'Закрыть',
			// 	timeFormat: 'HH:mm',
			// 	amNames: ['AM', 'A'],
			// 	pmNames: ['PM', 'P'],
			// 	isRTL: false
			// } );

			// Инициализация
			$('#datepicker').datetimepicker();
			// $( "#datepicker" ).datepicker(); 
			// $( "#timepicker" ).timepicker(); 
			// $('input[name*="date"], .datepicker').datepicker({ dateFormat: 'dd/mm/yy' });
			// можно подключить datepicker с доп. настройками так:
			/*
			$('input[name*="date"]').datepicker({ 
				dateFormat : 'yy-mm-dd',
				onSelect : function( dateText, inst ){
		// функцию для поля где указываются еще и секунды: 000-00-00 00:00:00 - оставляет секунды
		var secs = inst.lastVal.match(/^.*?\s([0-9]{2}:[0-9]{2}:[0-9]{2})$/);
		secs = secs ? secs[1] : '00:00:00'; // только чч:мм:сс, оставим часы минуты и секунды как есть, если нет то будет 00:00:00
		$(this).val( dateText +' '+ secs );
				}
			});
			*/          
		});
	</script>
	<?php
}
}