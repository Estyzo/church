<?php

namespace app\components;

use Yii;

class RoleAccess
{
    public const ROLE_ADMIN = 'admin';
    public const ROLE_CLERK = 'clerk';
    public const ROLE_VIEWER = 'viewer';
    public const ROLE_CONTRIBUTION_REGISTRAR = 'contribution_registrar';

    public static function role(): ?string
    {
        $identity = Yii::$app->user->identity;
        if ($identity === null || !isset($identity->role)) {
            return null;
        }

        return (string)$identity->role;
    }

    public static function hasAny(array $roles): bool
    {
        $role = self::role();
        return $role !== null && in_array($role, $roles, true);
    }

    public static function isContributionRegistrar(): bool
    {
        return self::role() === self::ROLE_CONTRIBUTION_REGISTRAR;
    }
}
