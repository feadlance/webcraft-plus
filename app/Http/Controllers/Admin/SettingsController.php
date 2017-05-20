<?php

namespace App\Http\Controllers\Admin;

use Artisan;
use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Helpers\PaymentSettings\PaymentSettingsParent as PaymentSettings;

class SettingsController extends Controller
{
	public function general()
	{
		$input = (object) [
			'name' => old('name') ?: settings('app.name'),
			'server_ip' => old('server_ip') ?: settings('lebby.server.ip'),
			'server_versions' => old('server_versions') ?: settings('lebby.server.versions'),
			'teamspeak_ip' => old('teamspeak_ip') ?: settings('lebby.server.teamspeak'),
			'meta_description' => old('meta.description') ?: settings('lebby.meta.description'),
			'meta_tags' => old('meta.tags') ?: settings('lebby.meta.tags'),
			'minecraftsunucular' => old('minecraftsunucular') ?: settings('lebby.minecraftsunucular'),
			'ads_field' => old('ads_field') ?: settings('lebby.ads_field'),
			'footer_links' => old('footer_links') ?: settings('lebby.footer_links'),
			'trailer' => old('trailer') ?: settings('lebby.trailer'),
			'about' => old('about') ?: settings('lebby.about'),
			'encryption' => old('encryption') ?: settings('lebby.password_encryption'),
		];

		return view('admin.settings.general', compact(
			'input'
		));
	}

	public function postGeneral(Request $request)
	{
		Validator::make($request->all(), [
			'name' => 'required|max:100',
			'server_ip' => 'max:100',
			'server_versions' => 'max:50',
			'teamspeak_ip' => 'max:100',
			'meta.description' => 'max:500',
			'meta.tags' => 'max:500',
			'minecraftsunucular' => 'max:50',
			'ads_field' => 'max:2000',
			'footer_links' => 'max:2000',
			'trailer' => 'min:11|max:11|nullable',
			'about' => 'max:500',
			'encryption' => 'in:md5,bcrypt,sha256'
		])->setAttributeNames([
			'name' => __('Site Adı'),
			'server_ip' => __('Sunucu IP/Host'),
			'server_versions' => __('Sunucu Versiyonları'),
			'teamspeak_ip' => __('Teamspeak IP/Host'),
			'meta.description' => __('Site Hakkında'),
			'meta.tags' => __('Etiketler'),
			'minecraftsunucular' => __('Sayfa'),
			'ads_field' => __('Reklam Kodu'),
			'footer_links' => __('Footer Linkleri'),
			'trailer' => __('Anasayfa Tanıtım Videosu'),
			'about' => __('Footer Yazısı'),
			'encryption' => __('Şifreleme Yöntemi')
		])->validate();

		_setenv([
			[['APP_NAME', 'app.name'], $request->input('name')],
			[['LEBBY_ENCRYPTION', 'lebby.password_encryption'], $request->encryption]
		]);

		$settings = [
			'lebby.server' => [
				'ip' => $request->server_ip,
				'versions' => $request->server_versions,
				'teamspeak' => $request->teamspeak_ip
			],
			'lebby.meta' => [
				'description' => $request->input('meta.description'),
				'tags' => $request->input('meta.tags')
			],
			'lebby.minecraftsunucular' => $request->minecraftsunucular,
			'lebby.trailer' => $request->trailer,
			'lebby.about' => $request->about,
			'lebby.footer_links' => $request->footer_links
		];

		if ( config('lebby.ads') !== null ) {
			$settings['lebby.ads_field'] = $request->ads_field;
		}

		settings($settings);

		return redirect()->route('admin.settings.general')
			->with('flash.success', __('Genel ayarlar başarıyla kaydedildi.'));
	}

	public function payment($key = null)
	{
		if ( is_null($key) === true ) {
			return view('admin.settings.payment', ['methods' => payment_methods('config')]);
		}

		$method = settings("lebby.payment_methods.{$key}");

		if ( $method === null || count($method['config']) <= 0 ) {
			return abort(404);
		}

		$input = (new PaymentSettings)->config($key, old());

		return view("admin.settings.payment.{$key}", compact(
			'input',
			'method'
		));
	}

	public function postPayment(Request $request, $key)
	{
		$scp = new PaymentSettings;

		$method = settings("lebby.payment_methods.{$key}");

		if ( $method === null || count($method['config']) <= 0 ) {
			return abort(404);
		}

		Validator::make($request->all(), $scp->rules($key))
			->setAttributeNames($scp->names($key))->validate();

		settings($scp->settings($request, $key));

		return redirect()->route('admin.settings.payment', $key)
			->with('flash.success', __(':name ödeme ayarları başarıyla kaydedildi.', ['name' => $method['name']]));
	}

	public function social()
	{
		return view('admin.settings.social', [
			'socials' => settings('lebby.social')
		]);
	}

	public function postSocial(Request $request)
	{
		$socials = config('lebby.social');
		$inputSocials = $request->input('social', []);
		$data = [];

		foreach ($inputSocials as $key => $social) {
			$attributeNames['social.' . $key] = $socials[$key][0];
			$data[$key] = [$socials[$key][0], $key, $social];
		}

		Validator::make($request->all(), [
			'social.*' => 'nullable|url|max:100'
		])->setAttributeNames($attributeNames)->validate();

		settings(['lebby.social' => $data]);

		return redirect()->route('admin.settings.social')
			->with('flash.success', __('Sosyal medya ayarları başarıyla kaydedildi.'));
	}

	public function mail()
	{
		$input = (object) [
			'on_register' => (boolean) old('on_register') ?: (boolean) settings('lebby.mail.on_register'),
			'host' => old('host') ?: settings('mail.host'),
			'port' => old('port') ?: settings('mail.port'),
			'username' => old('username') ?: settings('mail.username'),
			'password' => old('password') ?: settings('mail.password'),
			'encryption' => old('encryption') ?: settings('mail.encryption'),
			'email' => old('email') ?: settings('mail.from.address'),
		];

		return view('admin.settings.mail', [
			'input' => $input
		]);
	}

	public function postMail(Request $request)
	{
		Validator::make($request->all(), [
			'email' => 'nullable|email',
			'host' => 'max:100',
			'port' => 'nullable|numeric|max:65535',
			'username' => 'max:50',
			'password' => 'max:70',
			'encryption' => 'required|in:ssl,tls'
		])->setAttributeNames([
			'email' => __('E-Mail Adresiniz'),
			'host' => __('SMTP Host'),
			'port' => __('SMTP Port'),
			'username' => __('SMTP Kullanıcı Adı'),
			'password' => __('SMTP Şifresi'),
			'encryption' => __('SMTP Güvenliği')
		])->validate();

		_setenv([
			[['MAIL_FROM_ADDRESS', 'mail.from.address'], strip_tags($request->input('email'))],
			[['MAIL_HOST', 'mail.host'], strip_tags($request->input('host'))],
			[['MAIL_PORT', 'mail.port'], strip_tags($request->input('port'))],
			[['MAIL_USERNAME', 'mail.username'], strip_tags($request->input('username'))],
			[['MAIL_PASSWORD', 'mail.password'], strip_tags($request->input('password'))],
			[['MAIL_ENCRYPTION', 'mail.encryption'], strip_tags($request->input('encryption'))]
		]);

		return redirect()->route('admin.settings.mail')
			->with('flash.success', __('Mail ayarları başarıyla kaydedildi.'));
	}

	public function recaptcha()
	{
		$input = (object) [
			'public_key' => old('public_key') ?: settings('recaptcha.public_key'),
			'private_key' => old('private_key') ?: settings('recaptcha.private_key'),
		];

		return view('admin.settings.recaptcha', [
			'input' => $input
		]);
	}

	public function postRecaptcha(Request $request)
	{
		Validator::make($request->all(), [
			'public_key' => 'nullable|string|max:191',
			'private_key' => 'nullable|string|max:191'
		])->setAttributeNames([
			'public_key' => __('Public Key'),
			'private_key' => __('Private Key')
		])->validate();

		settings([
			'recaptcha.public_key' => strip_tags($request->input('public_key')),
			'recaptcha.private_key' => strip_tags($request->input('private_key'))
		]);

		return redirect()->route('admin.settings.recaptcha')
			->with('flash.success', __('ReCaptcha ayarları başarıyla kaydedildi.'));
	}

	public function other()
	{
		$input = (object) [
			'analytics' => old('analytics') ?: settings('lebby.google.analytics'),
			'search_console' => old('search_console') ?: settings('lebby.google.search_console')
		];

		return view('admin.settings.other', [
			'input' => $input
		]);
	}

	public function postOther(Request $request)
	{
		Validator::make($request->all(), [
			'analytics' => 'nullable|max:500',
			'search_console' => 'nullable|max:500'
		])->setAttributeNames([
			'analytics' => 'Google Analytics Kodu',
			'search_console' => 'Google Search Konsol Kodu'
		])->validate();

		settings(['lebby.google' => [
			'analytics' => request('analytics'),
			'search_console' => request('search_console'),
		]]);

		return redirect()->route('admin.settings.other')
			->with('flash.success', __('Diğer ayarlar başarıyla kaydedildi.'));
	}
}