<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static SUBSCRIBE()
 * @method static static UNSUBSCRIBE()
 * @method static static PROFILE()
 * @method static static UPDATEEMAIL()
 * @method static static CLEANED()
 * @method static static CAMPAIGN()
 */
final class MailChimpWebhookType extends Enum
{
    public const SUBSCRIBE = 'subscribe';
    public const UNSUBSCRIBE = 'unsubscribe';
    public const PROFILE = 'profile';
    public const UPDATEEMAIL = 'upemail';
    public const CLEANED = 'cleaned';
    public const CAMPAIGN = 'campaign';
}
