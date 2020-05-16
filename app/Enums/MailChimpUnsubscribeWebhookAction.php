<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static DELETE()
 * @method static static UNSUBSCRIBE()
 */
final class MailChimpUnsubscribeWebhookAction extends Enum
{
    public const DELETE = 'delete';
    public const UNSUBSCRIBE = 'unsub';
}
