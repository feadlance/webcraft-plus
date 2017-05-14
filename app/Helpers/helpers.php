<?php

use Carbon\Carbon;
use App\Helpers\SettingsHelper;
use Illuminate\Support\HtmlString;

function menu($route, $strstr = true, $classes = null, $active_class = 'active')
{
	$active = request()->route()->getName() === $route;
	
	if ( $strstr === true ) {
		$active = starts_with(request()->route()->getName(), $route);
	}

	$active = $active ? $active_class : null;

	if ( $classes ) {
		return new HtmlString(' class="' . $classes . ($active ? ' ' . $active : null) . '"');
	}

	if ( $active ) {
		return new HtmlString(' class="' . $active . ($classes ? ' ' . $classes : null) . '"');
	}
}

function settings($key = null)
{
	if ( $key === null ) {
		return SettingsHelper::all();
	}

	if ( is_array($key) ) {
		return SettingsHelper::set($key);
	}

	return SettingsHelper::get($key);
}

function _run($callback, $minutes = 30, $key)
{
	if ( cache()->has($key) !== true ) {
		$callback();

        cache()->put($key, true, Carbon::now()->addMinutes($minutes));
    }
}

function check_db_connection($type = null, $data = null) {
	if ( is_array($type) ) {
		$data = $type;
		$type = null;
	}

	if ( $data === null ) {
		$host = config('database.connections.mysql.host');
		$port = config('database.connections.mysql.port');
		$database = config('database.connections.mysql.database');
		$username = config('database.connections.mysql.username');
		$password = config('database.connections.mysql.password');
	}

	if ( is_array($data) ) {
		$host = $data['host'];
		$port = $data['port'];
		$database = $data['database'];
		$username = $data['username'];
		$password = $data['password'];
	}

	try {
		$pdo = new PDO("mysql:host={$host};port={$port};dbname={$database}", $username, $password, [
			PDO::ATTR_TIMEOUT => 3,
			PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
		]);

		$tables = $pdo->query('show tables');
		$tables = $tables->fetchAll(PDO::FETCH_COLUMN);

	    if ( $tables === false ) {
	    	return false;
	    }

		if ( $type === 'tables' ) {
	    	if ( count($tables) >= 23 ) {
	    		return true;
	    	}

	    	return false;
		}
		
		return true;
	} catch (PDOException $e) {
		return false;
	}
}

function _setenv($data, $value = null) {
	if ( isset($data[0][0]) !== true || is_array($data[0][0]) !== true ) {
		$data = [[$data, $value]];
	}

	$original = [];
	$new = [];

	foreach ($data as $key => $value) {
		$original[] = "{$value[0][0]}=" . Config::get($value[0][1]);
		
		if ( strpos($value[1], ' ') !== false ) {
			$new[] = "{$value[0][0]}=\"{$value[1]}\"";
		} else {
			$new[] = "{$value[0][0]}={$value[1]}";
		}

		Config::set($value[0][1], $value[1]);
	}

    file_put_contents(App::environmentFilePath(), str_replace(
        $original, $new,
        file_get_contents(App::environmentFilePath())
    ));
    
    Artisan::call('config:clear');
}

function payment_methods($filter = 'active')
{
	return array_filter(settings('lebby.payment_methods'), function ($value) use ($filter) {
		switch ($filter) {
			case 'config': return count($value['config']) > 0; break;
			default: return $value['active'] === true; break;
		}
	});
}

function minecraft_icon($icon)
{
	$icon = explode('-', $icon);

	if ( isset($icon[1]) && $icon[1] === '0' ) {
		return $icon[0];
	}

	return implode(':', $icon);
}

function allow_html_tags($val)
{
	return strip_tags($val, '<ol><ul><li><sub><span><b><p><i><u><strike><sup><br><img><iframe>');
}

function slider_image()
{
	$sliders = range(1, 6);
	$rand = rand(0, 5);

	return asset("images/sliders/0{$sliders[$rand]}.jpg");
}

function _asset($asset)
{
	return asset('theme/' . settings('lebby.theme') . '/' . $asset);
}

function _nf($num, $zero = 2)
{
	return number_format($num, $zero, ',', '.');
}

function nf_to_system($num)
{
	return str_replace(['.', ','], [null, '.'], $num);
}

function price_with_symbol($price, $real_money = true)
{
	return ($real_money ? '₺' : '') . _nf($price) . (!$real_money ? ' Oyun Parası' : '');
}

function curlPost($url, $fields = [])
{
	$curl = curl_init();

	curl_setopt_array($curl, [
	  CURLOPT_URL => $url,
	  CURLOPT_RETURNTRANSFER => true,
	  CURLOPT_ENCODING => '',
	  CURLOPT_MAXREDIRS => 10,
	  CURLOPT_TIMEOUT => 6,
	  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	  CURLOPT_SSL_VERIFYPEER => false,
	  CURLOPT_CUSTOMREQUEST => 'POST',
	  CURLOPT_POSTFIELDS =>  http_build_query($fields),
	]);

	if ( curl_error($curl) ) {
		return false;
	}

	$response = curl_exec($curl);

	curl_close($curl);

	return $response; 
}

function response_json($msg, $status = false, $data = null)
{
	return response()->json([
 		'status' => $status,
 		'status_message' => $msg,
 		'data' => $data
 	]);
}

function with_zero($number)
{
	if ( in_array($number, range(1, 9)) ) {
		return 0 . $number;
	}

	return $number;
}

function _date($date = null)
{
	switch ($date) {
		case 'this month':
			$date = date('Y-m');
			break;
		case 'last month':
			$date = Carbon::now()->subMonthNoOverflow()->format('Y-m');
			break;
		case 'all':
			return null;
			break;
	}

	$date = explode('-', $date ?: date('Y-m-d'));

	$array['y'] = $date[0];

	if ( isset($date[1]) === true ) {
		$array['m'] = $date[1];
		$array['ym'] = "{$array['y']}-{$array['m']}";
	}

	if ( isset($date[2]) === true ) {
		$array['d'] = with_zero($date[2]);
		$array['ymd'] = implode('-', $date);
	}

	$array['raw'] = implode('-', $date);

	return $array;
}

function date_query($date, $table = null, $operator = '=', $key = 'created_at')
{
	$query = [];
	$operators = ['>', '>=', '<', '<='];

	$date = _date($date);

	if ( $date === null ) {
		return null;
	}

	$table = $table ? "`{$table}`." : '';

	if ( $operator === '=' ) {
		if ( isset($date['y']) ) {
			$query[] = "'{$date['y']}' = YEAR({$table}`{$key}`)";
		}
		
		if ( isset($date['m']) ) {
			$query[] = "'{$date['m']}' = MONTH({$table}`{$key}`)";
		}

		if ( isset($date['d']) ) {
			$query[] = "'{$date['d']}' = DAY({$table}`{$key}`)";
		}

		return app('db')->raw(implode(' and ', $query));
	}

	if ( in_array($operator, $operators) ) {
		$format = [];

		if ( isset($date['y']) ) {
			$format[] = '%Y';

			if ( isset($date['m']) ) {
				$format[] = '%m';

				if ( isset($date['d']) ) {
					$format[] = '%d';
				}
			}
		}

		return app('db')->raw("'{$date['raw']}' {$operator} date_format({$table}`{$key}`, '" . implode('-', $format) . "')");
	}
}

function vipUnique($val)
{
	return base64_decode($val);
}