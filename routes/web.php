<?php

/**
 * Authentication
 */
Route::auth();

Route::post('/login', 'Auth\LoginController@customLogin');

Route::name('auth.login.email')->get('/login/email', 'Auth\LoginController@setEmail')
	->middleware('auth');
Route::post('/login/email', 'Auth\LoginController@postSetEmail')
	->middleware('auth');

/**
 * Home
 */
Route::name('home')->get('/', 'HomeController@home');

/**
 * Check Ban
 */
Route::name('check_ban')->middleware('auth')
	->post('/check-ban', 'HomeController@checkBan');

/**
 * Hit
 */
Route::group(['prefix' => '/hit', 'as' => 'hit.'], function () {

	Route::name('top100')->get('/top-100', 'HitController@top100');
	Route::post('/top-100', 'HitController@postTop100');

});

/**
 * Profile
 */
Route::group(['prefix' => '/profile/{username}', 'as' => 'profile.'], function () {

	Route::name('index')->get('/', 'ProfileController@index');
	Route::name('products')->get('/products', 'ProfileController@products');

	Route::name('settings')->get('/settings', 'ProfileController@settings');

	Route::name('settings.general')->middleware('auth')
		->post('/settings/general', 'ProfileController@settingsGeneral');

	Route::name('settings.social')->middleware('auth')
		->post('/settings/social', 'ProfileController@settingsSocial');

	Route::name('settings.password')->middleware('auth')
		->post('/settings/password', 'ProfileController@settingsPassword');

});

/**
 * Market
 */
Route::group(['prefix' => 'market', 'as' => 'market.'], function () {

	Route::name('index')->get('/', 'MarketController@index');
	Route::name('list')->post('/list', 'MarketController@list');

	Route::name('buy')->post('/buy/{id}/{server}', 'MarketController@postBuy');
	Route::name('detail')->post('/detail/{id}/{server}', 'MarketController@postDetail');

});

/**
 * Blog
 */
Route::group(['prefix' => 'blog', 'as' => 'blog.'], function () {

	Route::name('list')->get('/list/{category?}', 'BlogController@list');
	Route::name('detail')->get('/{slug}', 'BlogController@detail');

	Route::name('comment')->middleware('auth')
		->post('/{id}/comment', 'BlogController@postComment');

});

/**
 * Comment
 */
Route::group(['prefix' => 'comment', 'as' => 'comment.'], function () {

	Route::name('delete')->delete('/{id}', 'CommentController@delete');

});

/**
 * Forum
 */
Route::group(['prefix' => 'forum', 'as' => 'forum.'], function () {

	Route::name('index')->get('/', 'ForumController@index');

	Route::name('add')->middleware('auth')
		->get('/{forum}/add', 'ForumController@add');

	Route::name('reply')->middleware('auth')
		->post('/{forum}/{thread}/reply', 'ForumController@reply');

	Route::middleware('auth')->post('/{forum}/add', 'ForumController@postAdd');
	
	Route::name('threads')->get('/{forum}', 'ForumController@threads');
	Route::name('thread')->get('/{forum}/{thread}', 'ForumController@thread');

});

/**
 * Support
 */
Route::group([
	'prefix' => 'support',
	'as' => 'support.',
	'middleware' => 'auth'
], function () {

	Route::name('add')->get('/add', 'SupportController@add');
	Route::post('/add', 'SupportController@postAdd');

	Route::name('view')->get('/{id}/view', 'SupportController@view');
	Route::name('reply')->post('/{id}/reply', 'SupportController@reply');

	Route::name('list')->get('/list', 'SupportController@list');
	Route::name('close')->post('/{id}/close', 'SupportController@close');

});

/**
 * Payment
 */
Route::group([
	'prefix' => 'payment',
	'as' => 'payment.',
], function () {

	Route::name('method')->get('/{method}', 'PaymentController@method')->middleware('auth');
	Route::name('post')->post('/{method}/post', 'PaymentController@post')->middleware('auth');
	Route::name('listener')->post('/{method}/listener', 'PaymentController@listener');

});

/**
 * Admin
 */
Route::group([
	'prefix' => 'admin',
	'as' => 'admin.',
	'middleware' => 'admin',
	'namespace' => 'Admin'
], function () {

	/**
	 * Dashboard
	 */
	Route::name('dashboard')->get('/', 'DashboardController@dashboard');

	/**
	 * Users
	 */
	Route::group(['prefix' => 'user', 'as' => 'user.'], function () {

		Route::name('list')->get('/list/{filter?}', 'UserController@list');

		Route::name('detail')->get('/{username}/detail', 'UserController@detail');
		Route::name('action')->post('/{username}/action', 'UserController@action');

		Route::name('update')->get('/{username}/update', 'UserController@update');
		Route::post('/{username}/update', 'UserController@postUpdate');

	});

	/**
	 * Blog
	 */
	Route::group(['prefix' => 'blog', 'as' => 'blog.'], function () {

		Route::name('add')->get('/add', 'BlogController@add');
		Route::post('/add', 'BlogController@postAdd');

		Route::name('list')->get('/list', 'BlogController@list');
		Route::name('update')->get('/update', 'BlogController@update');

		Route::name('delete')->delete('/{id}', 'BlogController@delete');

	});

	/**
	 * Forum
	 */
	Route::group(['prefix' => 'forum', 'as' => 'forum.'], function () {

		Route::name('add')->get('/add', 'ForumController@add');
		Route::post('/add', 'ForumController@postAdd');

		Route::name('update')->get('/update', 'ForumController@update');

		Route::name('list')->get('/list', 'ForumController@list');
		Route::name('delete')->delete('/{id}', 'ForumController@delete');

		Route::group(['prefix' => 'category', 'as' => 'category.'], function () {

			Route::name('index')->get('/', 'ForumController@categoryIndex');
			
			Route::name('add')->post('/add', 'ForumController@postAddCategory');
			Route::name('delete')->delete('/{id}', 'ForumController@deleteCategory');

			Route::name('update')->get('/update', 'ForumController@updateCategory');

		});

	});

	/**
	 * Server
	 */
	Route::group(['prefix' => 'server', 'as' => 'server.'], function () {

		Route::name('add')->get('/add', 'ServerController@create');
		Route::post('/add', 'ServerController@postCreate');

		Route::name('list')->get('/list', 'ServerController@list');
		Route::name('delete')->delete('/{id}', 'ServerController@delete');
		
		Route::name('detail')->get('/{slug}/detail', 'ServerController@detail');

		Route::name('console')->post('/console', 'ServerController@postConsole');
		Route::name('console.log')->post('/{id}/console', 'ServerController@postReadConsoleLog');

	});

	/**
	 * Product
	 */
	Route::group(['prefix' => 'product', 'as' => 'product.'], function () {

		Route::name('add')->get('/add', 'ProductController@create');
		Route::post('/add', 'ProductController@postCreate');

		Route::name('list')->get('/list', 'ProductController@list');
		Route::name('set')->post('/{id}/{active}', 'ProductController@set');

		Route::name('detail')->get('/{id}/detail', 'ProductController@detail');
		Route::name('color')->post('/color', 'ProductController@color');

	});

	/**
	 * Support
	 */
	Route::group(['prefix' => 'support', 'as' => 'support.'], function () {

		Route::name('list')->get('/list', 'SupportController@list');
		Route::name('list.archive')->get('/list/archive', 'SupportController@listArchive');

		Route::name('reply')->get('/{id}/reply', 'SupportController@reply');
		Route::post('/{id}/reply', 'SupportController@postReply');

	});

	/**
	 * Support
	 */
	Route::group(['prefix' => 'support', 'as' => 'support.'], function () {

		Route::name('list')->get('/list', 'SupportController@list');
		Route::name('list.archive')->get('/list/archive', 'SupportController@listArchive');

		Route::name('reply')->get('/{id}/reply', 'SupportController@reply');
		Route::post('/{id}/reply', 'SupportController@postReply');

	});

	/**
	 * Coupon
	 */
	Route::group(['prefix' => 'coupon', 'as' => 'coupon.'], function () {

		Route::name('list')->get('/list', 'CouponController@list');
		Route::name('detail')->get('/{id}/detail', 'CouponController@detail');

		Route::name('delete')->delete('/{id}', 'CouponController@delete');

		Route::name('add')->get('/add', 'CouponController@add');
		Route::post('/add', 'CouponController@postAdd');

	});

	/**
	 * Punishment
	 */
	Route::group(['prefix' => 'punishment', 'as' => 'punishment.'], function () {

		Route::name('list')->get('/list', 'PunishmentController@list');
		Route::name('detail')->get('/{id}/detail', 'PunishmentController@detail');
		
		Route::name('delete')->delete('/{id}', 'PunishmentController@delete');

	});

	/**
	 * Settings
	 */
	Route::group(['prefix' => 'settings', 'as' => 'settings.'], function () {

		Route::name('general')->get('/general', 'SettingsController@general');
		Route::post('/general', 'SettingsController@postGeneral');

		Route::name('payment')->get('/payment/{method?}', 'SettingsController@payment');
		Route::post('/payment/{method}', 'SettingsController@postPayment');

		Route::name('social')->get('/social', 'SettingsController@social');
		Route::post('/social', 'SettingsController@postSocial');

		Route::name('mail')->get('/mail', 'SettingsController@mail');
		Route::post('/mail', 'SettingsController@postMail');

		Route::name('other')->get('/other', 'SettingsController@other');
		Route::post('/other', 'SettingsController@postOther');

		Route::name('recaptcha')->get('/recaptcha', 'SettingsController@recaptcha');
		Route::post('/recaptcha', 'SettingsController@postRecaptcha');

	});

});