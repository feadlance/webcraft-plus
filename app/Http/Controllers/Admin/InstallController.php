<?php

namespace App\Http\Controllers\Admin;

use PDO;
use Auth;
use Artisan;
use Exception;
use Validator;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Auth\RegisterController;

class InstallController extends Controller
{
	public function install()
	{
		$step = 1;

		if ( check_db_connection() === true ) {
			$step = 2;
		}

		return view('admin.install', compact(
			'step'
		));
	}

	public function postInstall(Request $request)
	{
		$validator = Validator::make($request->all(), [
			'name' => 'required|max:100',
			'url' => 'required|url|max:100',
			'encryption' => 'required|in:sha256,md5,bcrypt',
			'host' => 'required|max:100',
			'port' => 'required|numeric|max:65535',
			'database' => 'required|max:100',
			'username' => 'required|max:100',
			'password' => 'max:100'
		])->setAttributeNames([
			'name' => __('Site Adı'),
			'url' => __('Site Linki'),
			'encryption' => __('Şifreleme Methodu'),
			'host' => __('DB Host'),
			'port' => __('DB Port'),
			'database' => __('Veritabanı'),
			'username' => __('DB Kullanıcı Adı'),
			'password' => __('DB Şifre')
		])->validate();

		$database = check_db_connection([
			'host' => $request->input('host'),
			'port' => $request->input('port'),
			'database' => $request->input('database'),
			'username' => $request->input('username'),
			'password' => $request->input('password')
		]);

		if ( $database === false ) {
			return redirect()->route('admin.installation')
				->withInput()->with('flash.error', __('Veritabanı bağlantısını yapamadık, bilgilerin doğru olduğundan emin olun.'));
		}

		_setenv([
			[['APP_NAME', 'app.name'], $request->input('name')],
			[['APP_URL', 'app.url'], $request->input('url')],
			[['LEBBY_ENCRYPTION', 'lebby.password_encryption'], $request->input('encryption')],
			[['DB_HOST', 'database.connections.mysql.host'], $request->input('host')],
			[['DB_PORT', 'database.connections.mysql.port'], $request->input('port')],
			[['DB_DATABASE', 'database.connections.mysql.database'], $request->input('database')],
			[['DB_USERNAME', 'database.connections.mysql.username'], $request->input('username')],
			[['DB_PASSWORD', 'database.connections.mysql.password'], $request->input('password')]
		]);

		if ( check_db_connection('tables') ) {
			return redirect()->to('/');
		}

        return redirect()->route('admin.installation');
	}

	public function continue(Request $request)
	{
		if ( check_db_connection() === false ) {
			return redirect()->back();
		}

		$validator = Validator::make($request->all(), [
			'admin_username' => 'required|max:191',
			'admin_email' => 'required|email|max:191',
			'admin_password' => 'required|min:6'
		])->setAttributeNames([
			'admin_username' => __('Admin Kullanıcı Adı'),
			'admin_email' => __('Admin E-Posta'),
			'admin_password' => __('Admin Şifre'),
		])->validate();

		Artisan::call('migrate', ['--force' => true]);
		_setenv(['APP_ENV', 'app.env'], 'production');

        $user = (new RegisterController)->create([
            'username' => $request->input('admin_username'),
            'email' => $request->input('admin_email'),
            'password' => $request->input('admin_password'),
            'isAdmin' => true
        ]);

        Auth::login($user);

        return redirect()->to('/admin');
	}
}