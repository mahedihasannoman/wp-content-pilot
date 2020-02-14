<?php
defined( 'ABSPATH' ) || exit();
global $post;

echo WPCP_HTML::text_input( array(
	'label'   => __( 'Limit Title', 'wp-content-pilot' ),
	'type'    => 'number',
	'name'    => '_title_limit',
	'tooltip' => 'Input the number of words to limit the title. Default full title.',
) );

echo WPCP_HTML::text_input( array(
	'label'   => __( 'Limit Content', 'wp-content-pilot' ),
	'type'    => 'number',
	'name'    => '_content_limit',
	'tooltip' => 'Input the number of words to limit content. Default full content.',
) );

echo WPCP_HTML::text_input( array(
	'label'         => __( 'Excerpt Length', 'wp-content-pilot' ),
	'type'          => 'number',
	'name'          => '_excerpt_length',
	'default'       => '55',
	'wrapper_class' => 'pro',
	'attrs'         => array(
		'disabled' => 'disabled',
	)
) );

echo WPCP_HTML::select_input( array(
	'label'         => __( 'Translate To', 'wp-content-pilot' ),
	'name'          => '_translate_to',
	'options'       => array(
		''      => __( 'No Translation', 'wp-content-pilot' ),
		'af'    => __('Afrikaans', 'wp-content-pilot'),
		'sq'    => __('Albanian', 'wp-content-pilot'),
		'am'    => __('Amharic', 'wp-content-pilot'),
		'ar'    => __('Arabic', 'wp-content-pilot'),
		'hy'    => __('Armenian', 'wp-content-pilot'),
		'az'    => __('Azerbaijani', 'wp-content-pilot'),
		'bn'    => __('Bangla', 'wp-content-pilot'),
		'eu'    => __('Basque', 'wp-content-pilot'),
		'be'    => __('Belarusian', 'wp-content-pilot'),
		'bs'    => __('Bosnian', 'wp-content-pilot'),
		'bg'    => __('Bulgarian', 'wp-content-pilot'),
		'my'    => __('Burmese', 'wp-content-pilot'),
		'ca'    => __('Catalan', 'wp-content-pilot'),
		'ceb'   => __('Cebuano', 'wp-content-pilot'),
		'zh-CN' => __('Chinese (Simplified)', 'wp-content-pilot'),
		'zh-TW' => __('Chinese (Traditional)', 'wp-content-pilot'),
		'co'    => __('Corsican', 'wp-content-pilot'),
		'hr'    => __('Croatian', 'wp-content-pilot'),
		'cs'    => __('Czech', 'wp-content-pilot'),
		'da'    => __('Danish', 'wp-content-pilot'),
		'nl'    => __('Dutch', 'wp-content-pilot'),
		'en'    => __('English', 'wp-content-pilot'),
		'eo'    => __('Esperanto', 'wp-content-pilot'),
		'et'    => __('Estonian', 'wp-content-pilot'),
		'tl'    => __('Filipino', 'wp-content-pilot'),
		'fi'    => __('Finnish', 'wp-content-pilot'),
		'fr'    => __('French', 'wp-content-pilot'),
		'gl'    => __('Galician', 'wp-content-pilot'),
		'ka'    => __('Georgian', 'wp-content-pilot'),
		'de'    => __('German', 'wp-content-pilot'),
		'el'    => __('Greek', 'wp-content-pilot'),
		'gu'    => __('Gujarati', 'wp-content-pilot'),
		'ht'    => __('Haitian Creole', 'wp-content-pilot'),
		'ha'    => __('Hausa', 'wp-content-pilot'),
		'haw'   =>__('Hawaiian', 'wp-content-pilot'),
		'iw'    => __('Hebrew', 'wp-content-pilot'),
		'hi'    => __('Hindi', 'wp-content-pilot'),
		'hmn'   => __('Hmong', 'wp-content-pilot'),
		'hu'    => __('Hungarian', 'wp-content-pilot'),
		'is'    => __('Icelandic', 'wp-content-pilot'),
		'ig'    => __('Igbo', 'wp-content-pilot'),
		'id'    => __('Indonesian', 'wp-content-pilot'),
		'ga'    => __('Irish', 'wp-content-pilot'),
		'it'    => __('Italian', 'wp-content-pilot'),
		'ja'    => __('Japanese', 'wp-content-pilot'),
		'jv'    => __('Javanese', 'wp-content-pilot'),
		'kn'    => __('Kannada', 'wp-content-pilot'),
		'kk'    => __('Kazakh', 'wp-content-pilot'),
		'km'    => __('Khmer', 'wp-content-pilot'),
		'ko'    => __('Korean', 'wp-content-pilot'),
		'ku'    => __('Kurdish', 'wp-content-pilot'),
		'ky'    => __('Kyrgyz', 'wp-content-pilot'),
		'lo'    => __('Lao', 'wp-content-pilot'),
		'la'    => __('Latin', 'wp-content-pilot'),
		'lv'    => __('Latvian', 'wp-content-pilot'),
		'lt'    => __('Lithuanian', 'wp-content-pilot'),
		'lb'    => __('Luxembourgish', 'wp-content-pilot'),
		'mk'    => __('Macedonian', 'wp-content-pilot'),
		'mg'    => __('Malagasy', 'wp-content-pilot'),
		'ms'    => __('Malay', 'wp-content-pilot'),
		'ml'    => __('Malayalam', 'wp-content-pilot'),
		'mt'    => __('Maltese', 'wp-content-pilot'),
		'mi'    => __('Maori', 'wp-content-pilot'),
		'mr'    => __('Marathi', 'wp-content-pilot'),
		'mn'    => __('Mongolian', 'wp-content-pilot'),
		'ne'    => __('Nepali', 'wp-content-pilot'),
		'no'    => __('Norwegian', 'wp-content-pilot'),
		'ny'    => __('Nyanja', 'wp-content-pilot'),
		'ps'    => __('Pashto', 'wp-content-pilot'),
		'fa'    => __('Persian', 'wp-content-pilot'),
		'pl'    => __('Polish', 'wp-content-pilot'),
		'pt'    => __('Portuguese', 'wp-content-pilot'),
		'pa'    => __('Punjabi', 'wp-content-pilot'),
		'ro'    => __('Romanian', 'wp-content-pilot'),
		'ru'    => __('Russian', 'wp-content-pilot'),
		'sm'    => __('Samoan', 'wp-content-pilot'),
		'gd'    => __('Scottish Gaelic', 'wp-content-pilot'),
		'sr'    => __('Serbian', 'wp-content-pilot'),
		'sn'    => __('Shona', 'wp-content-pilot'),
		'sd'    => __('Sindhi', 'wp-content-pilot'),
		'si'    => __('Sinhala', 'wp-content-pilot'),
		'sk'    => __('Slovak', 'wp-content-pilot'),
		'sl'    => __('Slovenian', 'wp-content-pilot'),
		'so'    => __('Somali', 'wp-content-pilot'),
		'st'    => __('Southern Sotho', 'wp-content-pilot'),
		'es'    => __('Spanish', 'wp-content-pilot'),
		'su'    => __('Sundanese', 'wp-content-pilot'),
		'sw'    => __('Swahili', 'wp-content-pilot'),
		'sv'    => __('Swedish', 'wp-content-pilot'),
		'tg'    => __('Tajik', 'wp-content-pilot'),
		'ta'    => __('Tamil', 'wp-content-pilot'),
		'te'    => __('Telugu', 'wp-content-pilot'),
		'th'    => __('Thai', 'wp-content-pilot'),
		'tr'    => __('Turkish', 'wp-content-pilot'),
		'uk'    => __('Ukrainian', 'wp-content-pilot'),
		'ur'    => __('Urdu', 'wp-content-pilot'),
		'uz'    => __('Uzbek', 'wp-content-pilot'),
		'vi'    => __('Vietnamese', 'wp-content-pilot'),
		'cy'    => __('Welsh', 'wp-content-pilot'),
		'fy'    => __('Western Frisian', 'wp-content-pilot'),
		'xh'    => __('Xhosa', 'wp-content-pilot'),
		'yi'    => __('Yiddish', 'wp-content-pilot'),
		'yo'    => __('Yoruba', 'wp-content-pilot'),
		'zu'    => __('Zulu', 'wp-content-pilot'),
	),
	'tooltip'       => __( 'Select a language to translate.', 'wp-content-pilot' ),
	'wrapper_class' => 'pro',
	'attrs'         => array(
		'disabled' => 'disabled',
	)
) );


