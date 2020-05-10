<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Contact extends Model
{
    use Notifiable;

    public const MAX_MESSAGE_LENGTH = 2000;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'message',
    ];

    public function routeNotificationForSlack(): string
    {
        return 'https://hooks.slack.com/services/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';
    }
}
