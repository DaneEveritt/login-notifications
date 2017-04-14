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

namespace DaneEveritt\LoginNotifications\Notifications;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class SuccessfulLoginNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * The request IP address.
     *
     * @var string
     */
    public $ip;

    /**
     * The request IP address.
     *
     * @var Carbon\Carbon
     */
    public $time;

    /**
     * Create a new notification instance.
     *
     * @param  string  $ip
     * @return void
     */
    public function __construct($ip)
    {
        $this->ip = $ip;
        $this->time = Carbon::now();
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    /**
     * Get the database representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toArray($notifiable)
    {
        return [
            'ip' => $this->ip,
            'time' => $this->time,
        ];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                ->subject('Successful Login Notification')
                ->greeting('Successful Account Login')
                ->line('A successful login was detected for your account.')
                ->line('This request originated from ' . $this->ip . ' (' . gethostbyaddr($this->ip) . ') at ' . $this->time);
    }

}
