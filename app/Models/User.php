<?php

namespace App\Models;

use Carbon\Carbon;
use App\Models\Server;
use Weblebby\GameConnect\Minecraft\Color;

use Illuminate\Support\HtmlString;
use Illuminate\Notifications\Notifiable;
use App\Notifications\ResetPasswordNotification;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name',
        'biography',
        'location',
        'birthday',
        'money',
        'social_facebook',
        'social_youtube',
        'social_steam',
        'email',
        'password',
        'username',
        'ip',
        'lastlogin',
        'x',
        'y',
        'z',
        'world',
        'isAdmin',
        'isLogged'
    ];

    protected $hidden = [
        'password',
        'remember_token'
    ];

    protected $casts = [
        'isLogged' => 'boolean',
        'isAdmin' => 'boolean',
    ];

    protected $dates = ['date'];

    public function scopeOnline($query)
    {
        if ( settings('lebby.bungeecord') === false ) {
            return $query->where('isLogged', true);
        }

        return $query->whereHas('statistics', function ($q) {
            $q->where('is_online', true)->has('server')->has('user');
        });
    }

    public function comments()
    {
        return $this->hasMany('App\Models\Comment');
    }

    public function punishments()
    {
        return $this->hasMany('App\Models\Punishment', 'name', 'username');
    }

    public function punishment_history()
    {
        return $this->hasMany('App\Models\PunishmentHistory', 'name', 'username');
    }

    public function blog_posts()
    {
        return $this->hasMany('App\Models\Post');
    }

    public function supports()
    {
        return $this->hasMany('App\Models\Support');
    }

    public function support_messages()
    {
        return $this->hasMany('App\Models\SupportMessage');
    }

    public function payment_payloads()
    {
        return $this->hasMany('App\Models\PaymentPayload');
    }

    public function sales()
    {
        return $this->hasMany('App\Models\Sale');
    }

    public function forum_threads()
    {
        return $this->hasMany('App\Models\ForumThread');
    }

    public function thread_posts()
    {
        return $this->hasMany('App\Models\ThreadPost');
    }

    public function statistic()
    {
        return $this->statistics()->where('is_online', true)
            ->has('server')->has('user')->first();
    }

    public function statistics()
    {
        return $this->hasMany('App\Models\PlayerStatistic', 'username', 'username');
    }

    public function sale()
    {
        return $this->belongsTo('App\Models\Sale', 'vip');
    }

    public function is_online()
    {
        if ( settings('lebby.bungeecord') === false ) {
            return $this->isLogged;
        }

        return $this->statistic() !== null;
    }

    public function server()
    {
        if ( settings('lebby.bungeecord') === false ) {
            return Server::first();
        }

        $statistic = $this->statistic();

        return $statistic !== null ? $statistic->server : null;
    }

    public function avatar($size = 25)
    {
        return "https://minotar.net/helm/{$this->username}/{$size}";
    }

    public function body($size = 100)
    {
        return "https://minotar.net/armor/body/{$this->username}/{$size}.png";
    }

    public function cover()
    {
        return _asset('img/cover/cover-profile.jpg');
    }

    public function nameOrUsername()
    {
        return $this->name ?: $this->username;
    }

    public function prefixAndName()
    {
        $name = strip_tags($this->nameOrUsername());

        if ( $this->sale === null || $this->sale->ended_at < Carbon::now() ) {
            return $name;
        }

        if ( $this->sale->product === null ) {
            return $name;
        }

        $prefix = Color::html(strip_tags($this->sale->product->prefix));

        return "{$prefix} {$name}";
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }
}
