<?php

namespace app\components;

use Yii;

class RoleAccess
{
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
}
