<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class EloquentEventServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        /**
         * Observe the Tag
         */
        \App\Models\Tag::observe(\App\Observers\TagObserver::class);

        /**
         * Observe the Post
         */
        \App\Models\Post::observe(\App\Observers\PostObserver::class);

        /**
         * Observe the User
         */
        \App\Models\User::observe(\App\Observers\UserObserver::class);

        /**
         * Observe the Forum
         */
        \App\Models\Forum::observe(\App\Observers\ForumObserver::class);

        /**
         * Observe the SupportMessage
         */
        \App\Models\SupportMessage::observe(\App\Observers\SupportMessageObserver::class);

        /**
         * Observe the ForumThread
         */
        \App\Models\ForumThread::observe(\App\Observers\ForumThreadObserver::class);

        /**
         * Observe the ThreadPost
         */
        \App\Models\ThreadPost::observe(\App\Observers\ThreadPostObserver::class);

        /**
         * Observe the Server
         */
        \App\Models\Server::observe(\App\Observers\ServerObserver::class);
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
