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
 * Storage
 */
Route::name('storage')->get('/storage/{path}', 'StorageController@get')->where('path', '(.*)');

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
	Route::name('products')->get('/products', 'ProfileController@getProducts');

	Route::name('settings')->get('/settings', 'ProfileController@getSettings');

	Route::name('settings.general')->middleware('auth')
		->post('/settings/general', 'ProfileController@postSettingsGeneral');

	Route::name('settings.social')->middleware('auth')
		->post('/settings/social', 'ProfileController@postSettingsSocial');

	Route::name('settings.password')->middleware('auth')
		->post('/settings/password', 'ProfileController@postSettingsPassword');

});

/**
 * Market
 */
Route::group(['prefix' => 'market', 'as' => 'market.'], function () {

	Route::name('index')->get('/', 'MarketController@index');
	Route::name('list')->post('/list', 'MarketController@postList');

	Route::name('buy')->post('/buy/{id}/{server}', 'MarketController@postBuy');
	Route::name('detail')->post('/detail/{id}/{server}', 'MarketController@postDetail');

});

/**
 * Blog
 */
Route::group(['prefix' => 'blog', 'as' => 'blog.'], function () {

	Route::name('list')->get('/list/{category?}', 'BlogController@getList');
	Route::name('detail')->get('/{slug}', 'BlogController@getDetail');

	Route::name('comment')->middleware('auth')
		->post('/{id}/comment', 'BlogController@postComment');

});

/**
 * Comment
 */
Route::group(['prefix' => 'comment', 'as' => 'comment.'], function () {

	Route::name('delete')->delete('/{id}', 'CommentController@deleteComment');

});

/**
 * Forum
 */
Route::group(['prefix' => 'forum', 'as' => 'forum.'], function () {

	Route::name('index')->get('/', 'ForumController@index');

	Route::name('add')->middleware('auth')
		->get('/{forum}/add', 'ForumController@getAdd');

	Route::name('reply')->middleware('auth')
		->post('/{forum}/{thread}/reply', 'ForumController@postReply');

	Route::middleware('auth')->post('/{forum}/add', 'ForumController@postAdd');
	
	Route::name('threads')->get('/{forum}', 'ForumController@getThreads');
	Route::name('thread')->get('/{forum}/{thread}', 'ForumController@getThread');

});

/**
 * Support
 */
Route::group([
	'prefix' => 'support',
	'as' => 'support.',
	'middleware' => 'auth'
], function () {

	Route::name('add')->get('/add', 'SupportController@getAdd');
	Route::post('/add', 'SupportController@postAdd');

	Route::name('view')->get('/{id}/view', 'SupportController@getView');
	Route::name('reply')->post('/{id}/reply', 'SupportController@postReply');

	Route::name('list')->get('/list', 'SupportController@getList');
	Route::name('close')->post('/{id}/close', 'SupportController@postClose');

});

/**
 * Payment
 */
Route::group([
	'prefix' => 'payment',
	'as' => 'payment.',
], function () {

	Route::name('method')->get('/{method}', 'PaymentController@getMethod')->middleware('auth');
	Route::name('post')->post('/{method}/post', 'PaymentController@postMethod')->middleware('auth');
	Route::name('listener')->post('/{method}/listener', 'PaymentController@postListener');

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
	Route::name('dashboard')->get('/', 'DashboardController@getDashboard');

	/**
	 * Users
	 */
	Route::group(['prefix' => 'user', 'as' => 'user.'], function () {

		Route::name('list')->get('/list/{filter?}', 'UserController@getList');

		Route::name('detail')->get('/{username}/detail', 'UserController@getDetail');
		Route::name('action')->post('/{username}/action', 'UserController@postAction');

		Route::name('update')->get('/{username}/update', 'UserController@getUpdate');
		Route::post('/{username}/update', 'UserController@postUpdate');

	});

	/**
	 * Blog
	 */
	Route::group(['prefix' => 'blog', 'as' => 'blog.'], function () {

		Route::name('add')->get('/add', 'BlogController@getAdd');
		Route::post('/add', 'BlogController@postAdd');

		Route::name('list')->get('/list', 'BlogController@getList');
		Route::name('update')->get('/update', 'BlogController@getUpdate');

		Route::name('delete')->delete('/{id}', 'BlogController@deleteBlog');

	});

	/**
	 * Forum
	 */
	Route::group(['prefix' => 'forum', 'as' => 'forum.'], function () {

		Route::name('add')->get('/add', 'ForumController@getAdd');
		Route::post('/add', 'ForumController@postAdd');

		Route::name('update')->get('/update', 'ForumController@getUpdate');

		Route::name('list')->get('/list', 'ForumController@getList');
		Route::name('delete')->delete('/{id}', 'ForumController@deleteForum');

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

		Route::name('add')->get('/add', 'ServerController@getCreate');
		Route::post('/add', 'ServerController@postCreate');

		Route::name('list')->get('/list', 'ServerController@getList');
		Route::name('delete')->delete('/{id}', 'ServerController@deleteServer');
		
		Route::name('detail')->get('/{slug}/detail', 'ServerController@getDetail');

		Route::name('console')->post('/console', 'ServerController@postConsole');
		Route::name('console.log')->post('/{id}/console', 'ServerController@postReadConsoleLog');

	});

	/**
	 * Product
	 */
	Route::group(['prefix' => 'product', 'as' => 'product.'], function () {

		Route::name('add')->get('/add', 'ProductController@getCreate');
		Route::post('/add', 'ProductController@postCreate');

		Route::name('list')->get('/list', 'ProductController@getList');
		Route::name('set')->post('/{id}/{active}', 'ProductController@postSet');

		Route::name('detail')->get('/{id}/detail', 'ProductController@getDetail');
		Route::name('color')->post('/color', 'ProductController@postColor');

	});

	/**
	 * Support
	 */
	Route::group(['prefix' => 'support', 'as' => 'support.'], function () {

		Route::name('list')->get('/list', 'SupportController@getList');
		Route::name('list.archive')->get('/list/archive', 'SupportController@listArchive');

		Route::name('reply')->get('/{id}/reply', 'SupportController@getReply');
		Route::post('/{id}/reply', 'SupportController@postReply');

	});

	/**
	 * Support
	 */
	Route::group(['prefix' => 'support', 'as' => 'support.'], function () {

		Route::name('list')->get('/list', 'SupportController@getList');
		Route::name('list.archive')->get('/list/archive', 'SupportController@listArchive');

		Route::name('reply')->get('/{id}/reply', 'SupportController@getReply');
		Route::post('/{id}/reply', 'SupportController@postReply');

	});

	/**
	 * Coupon
	 */
	Route::group(['prefix' => 'coupon', 'as' => 'coupon.'], function () {

		Route::name('list')->get('/list', 'CouponController@getList');
		Route::name('detail')->get('/{id}/detail', 'CouponController@getDetail');

		Route::name('delete')->delete('/{id}', 'CouponController@deleteCoupon');

		Route::name('add')->get('/add', 'CouponController@getAdd');
		Route::post('/add', 'CouponController@postAdd');

	});

	/**
	 * Punishment
	 */
	Route::group(['prefix' => 'punishment', 'as' => 'punishment.'], function () {

		Route::name('list')->get('/list', 'PunishmentController@getList');
		Route::name('detail')->get('/{id}/detail', 'PunishmentController@getDetail');
		
		Route::name('delete')->delete('/{id}', 'PunishmentController@deletePunishment');

	});

	/**
	 * Settings
	 */
	Route::group(['prefix' => 'settings', 'as' => 'settings.'], function () {

		Route::name('general')->get('/general', 'SettingsController@getGeneral');
		Route::post('/general', 'SettingsController@postGeneral');

		Route::name('payment')->get('/payment/{method?}', 'SettingsController@getPayment');
		Route::post('/payment/{method}', 'SettingsController@postPayment');

		Route::name('social')->get('/social', 'SettingsController@getSocial');
		Route::post('/social', 'SettingsController@postSocial');

		Route::name('mail')->get('/mail', 'SettingsController@getMail');
		Route::post('/mail', 'SettingsController@postMail');

		Route::name('other')->get('/other', 'SettingsController@getOther');
		Route::post('/other', 'SettingsController@postOther');

		Route::name('recaptcha')->get('/recaptcha', 'SettingsController@getRecaptcha');
		Route::post('/recaptcha', 'SettingsController@postRecaptcha');

	});

});