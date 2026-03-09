<?php

namespace app\models;

use yii\base\Model;

class ResetPasswordForm extends Model
{
    public $new_password;
    public $confirm_password;

    public function rules()
    {
        return [
            [['new_password', 'confirm_password'], 'required'],
            [['new_password', 'confirm_password'], 'string', 'min' => 8],
            ['confirm_password', 'compare', 'compareAttribute' => 'new_password'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'new_password' => 'New Password',
            'confirm_password' => 'Confirm Password',
        ];
    }

    public function apply(SystemUser $user): bool
    {
        if (!$this->validate()) {
            return false;
        }

        $user->password = (string)$this->new_password;
        return $user->save();
    }
}
