<?php

namespace App\Extensions\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Notification;

/**
 * @property string $role
 */
trait AuthenticatableRoles
{
    public static function notifyAll($notification): void
    {
        Notification::send(self::all(), $notification);
    }

    public static function pushNotifyAll($notification): void
    {
        \Notification::send(self::query()->whereNotNull('device_id')->get(), $notification);
    }

    public static function notifyByQuery($notification, Builder $builder): void
    {
        \Notification::send($builder->get(), $notification);
    }

    /**
     * Add Authenticatable filter during Eloquent Boot Up.
     */
    protected static function bootAuthenticatableRoles(): void
    {
        static::addGlobalScope(__CLASS__, function ($builder) {
            return $builder->role(static::$role, 'web');
        });
    }
}
