<?php
/**
 * Laravel Login Notifications
 * Copyright (c) 2017 Dane Everitt <dane@daneeveritt.com>.
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
 */

namespace DaneEveritt\LoginNotifications;

use Illuminate\Foundation\Application;
use Illuminate\Support\ServiceProvider;
use Illuminate\Auth\EloquentUserProvider;
use DaneEveritt\LoginNotifications\Notifications\FailedLoginNotification;
use DaneEveritt\LoginNotifications\Notifications\SuccessfulLoginNotification;

class NotificationServiceProvider extends ServiceProvider
{
    /**
     * The FQCN of the failed login event.
     *
     * @var string
     */
    protected $failedEvent = 'Illuminate\Auth\Events\Failed';

    /**
     * The FQCN of the successful login event.
     *
     * @var string
     */
    protected $successEvent = 'Illuminate\Auth\Events\Login';

    /**
     * Boot the notification provider.
     *
     * @return void
     */
    public function boot()
    {
        $this->app['events']->listen($this->failedEvent, function ($event) {
            if (isset($event->user) && is_a($event->user, 'Illuminate\Database\Eloquent\Model')) {
                $event->user->notify(new FailedLoginNotification(
                    $this->app['request']->ip()
                ));
            }
        });

        $this->app['events']->listen($this->successEvent, function ($event) {
            if (isset($event->user) && is_a($event->user, 'Illuminate\Database\Eloquent\Model')) {
                $event->user->notify(new SuccessfulLoginNotification(
                    $this->app['request']->ip()
                ));
            }
        });
    }

    /**
     * Register for the notification provider.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
