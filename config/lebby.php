<?php

return [

	/***************
		SİTENİN TÜM BİLGİLERİ BURADAN AYIKLANIR, YANLIŞ YAPTIĞINIZ BİR İŞLEM SİTENİN BOZULMASINA NEDEN OLABİLİR.
		BU NEDENLE AYAR AÇIKLAMASINI OKUMADAN DEĞİŞİKLİK YAPMAYINIZ.
	***************/

	/**
	 * Site teması.
	 *
	 * Temayı buradan değiştirmeyin.
	 * Başka temanız var ise kök dizinde bulunan,
	 * .env dosyasının APP_THEME anahtarından değiştirebilirsiniz.
	 */
	'theme' => env('APP_THEME', 'gameforest'),

	/**
	 * Sunucunuzun açıklaması.
	 *
	 * Bu yazıyı buradan değil,
	 * Yönetim Paneli -> Ayarlar -> Genel Ayarlar'dan değiştirebilirsiniz.
	 */
	'about' => 'Bu açıklama yazısını, Yönetim Paneli > Ayarlar > Genel Ayarlar sayfasından değiştirebilirsiniz.',

	/**
	 * Ödeme yöntemleri.
	 *
	 * Ödeme yöntemlerinin ayarlarını buradan değiştirmeyin,
	 * Yönetim Paneli -> Ayarlar -> Ödeme Ayarları'ndan değiştirebilirsiniz.
	 */
	'payment_methods' => [

		'coupon' => [
			'active' => true,
			'key' => 'coupon',
			'name' => 'Kupon',
			'description' => 'Bir kupon kodunuz mu var? Kodu hemen girin ve karşılığını alın.',
			'config' => [],
			'class' => \App\Helpers\Payments\CouponPayment::class
		],

		'batihost' => [
			'active' => false,
			'key' => 'batihost',
			'name' => 'Batıhost',
			'description' => 'İster kredi kartı, ister mobil ödeme. Kredinizi hemen yükleyebilirsiniz!',
			'config' => [
				'id' => null,
				'secret' => null,
				'api_url' => 'http://batigame.com/vipgateway/viprec.php'
			],
			'class' => \Weblebby\Payments\BatigamePayment::class
		],

		'paywant' => [
			'active' => false,
			'key' => 'paywant',
			'name' => 'Paywant',
			'description' => 'Paywant ile ininal dahil tüm ödeme yöntemleri ile kredinizi hemen yükleyin.',
			'config' => [
				'key' => null,
				'secret' => null,
				'api_url' => 'http://api.paywant.com/gateway.php'
			],
			'class' => \Weblebby\Payments\PaywantPayment::class
		],

	],

	/**
	 * Sosyal Medya sayfaları.
	 *
	 * Buradan bir şey değiştirmeyin,
	 * Yönetim Paneli -> Ayarlar -> Sosyal Medya Ayarları'ndan değiştirebilirsiniz.
	 */
	'social' => [
		'facebook' => ['Facebook', 'facebook', null],
		'twitter' => ['Twitter', 'twitter', null],
		'google-plus' => ['Google+', 'google-plus', null],
		'steam' => ['Steam', 'steam', null]
	],

	/**
	 * Tanıtım videosu.
	 *
	 * Buradan değiştirmeyin,
	 * Yönetim Paneli -> Genel Ayarlar'dan değiştirebilirsiniz.
	 */
	'trailer' => 'xg2vLiqf0Ug',

	/**
	 * Sunucu bilgileri kaç dakikada bir güncellensin?
	 *
	 * Örneğin burası 10 ise, süresi biten ürünler her 10 dakika da bir sorgulanıp,
	 * Gerekli komutlar oyuna gönderilir.
	 *
	 * İstediğiniz süreyi buradan yazıp özelleştirebilirsiniz.
	 */
	'sync_delay' => 10,

	/**
	 * Ziyaretçi ve Üye Anasayfaları.
	 *
	 * Ziyaretçiler ve kayıtlı üyeler için tek anasayfa
	 * olmasını istiyorsanız false yapın.
	 */
	'two_home_page' => env('LEBBY_TWO_HOME_PAGE', true),

	/**
	 * Destek Talebi sayfasında ki problem başlıkları.
	 *
	 * Listeden bir öğe çıkartabilir,
	 * düzenleyebilir ya da yeni bir tane ekleyebilirsiniz.
	 */
	'support_types' => [
		1 => 'Bug',
		2 => 'Küfür/Hakaret',
		3 => 'Ödeme Sorunları',
		4 => 'Diğer'
	],

	/**
	 * Çoklu sunucu ayarları.
	 *
	 * Bu ayarı kesinlikle değiştirmeyin!
	 * Sunucunuz Bungeecord olmasa da böyle kalsın,
	 * eğer değişiklik yaparsanız, sıralama sistemi bozulacaktır ve
	 * çevrimiçi oyuncular düzgün bir şekilde listelenmeyecektir.
	 */
	'bungeecord' => env('LEBBY_BUNGEECORD', true),

	/**
	 * HTTPS Protokolü.
	 *
	 * Eğer bir ssl sertifikanız varsa ya da Cloudflare üzerinden ssl aldıysanız,
	 * Kök dizinde bulunan .env dosyasında ki HTTPS_PROTOCOL anahtarını 'true' yapabilirsiniz.
	 */
	'https_protocol' => env('HTTPS_PROTOCOL', false),

	/**
	 * Kullanıcı şifresini şifreleme yöntemi.
	 *
	 * Seçenekler: BCRYPT, MD5, SHA256
	 *
	 * Bu ayarı buradan değiştirmeyin,
	 * Kök dizinde bulunan .env dosyasındaki LEBBY_ENCRYPTION anahtarından değiştirebilirsiniz.
	 */
	'password_encryption' => env('LEBBY_ENCRYPTION', 'md5')

];