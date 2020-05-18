<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static CAMPAIGN()
 * @method static static CLEANED()
 * @method static static PROFILE()
 * @method static static SUBSCRIBE()
 * @method static static UNSUBSCRIBE()
 * @method static static UPDATE_MAIL()
 */
class MailChimpWebhookType extends Enum
{
    public const CAMPAIGN = 'campaign';
    public const CLEANED = 'cleaned';
    public const PROFILE = 'profile';
    public const SUBSCRIBE = 'subscribe';
    public const UNSUBSCRIBE = 'unsubscribe';
    public const UPDATE_MAIL = 'upemail';
}
