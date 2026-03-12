<?php

namespace app\models;

use Yii;
use yii\base\Model;

class ChangePasswordForm extends Model
{
    public $current_password;
    public $new_password;
    public $confirm_password;

    private ?SystemUser $_user = null;

    public function rules()
    {
        return [
            [['current_password', 'new_password', 'confirm_password'], 'required'],
            [['new_password', 'confirm_password'], 'string', 'min' => 8],
            ['confirm_password', 'compare', 'compareAttribute' => 'new_password', 'message' => 'Uthibitisho wa nenosiri haulingani.'],
            ['current_password', 'validateCurrentPassword'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'current_password' => 'Nenosiri la Sasa',
            'new_password' => 'Nenosiri Jipya',
            'confirm_password' => 'Thibitisha Nenosiri',
        ];
    }

    public function validateCurrentPassword($attribute): void
    {
        if ($this->hasErrors()) {
            return;
        }

        $user = $this->getUser();
        if (!$user || !$user->validatePassword((string)$this->current_password)) {
            $this->addError($attribute, 'Nenosiri la sasa si sahihi.');
        }
    }

    public function change(): bool
    {
        if (!$this->validate()) {
            return false;
        }

        $user = $this->getUser();
        if ($user === null) {
            return false;
        }

        $user->password = (string)$this->new_password;
        return $user->save();
    }

    private function getUser(): ?SystemUser
    {
        if ($this->_user === null) {
            $identity = Yii::$app->user->identity;
            $this->_user = $identity instanceof SystemUser ? $identity : null;
        }

        return $this->_user;
    }
}
