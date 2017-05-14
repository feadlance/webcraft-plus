<?php

Route::get('/', function () {
	return redirect()->route('admin.installation');
});

Route::name('admin.installation')->get('/installation', 'Admin\InstallController@install');
Route::post('/installation', 'Admin\InstallController@postInstall');

Route::name('admin.continue')->post('/continue', 'Admin\InstallController@continue');