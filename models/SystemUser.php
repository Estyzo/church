<?php

namespace app\models;

use yii\base\Exception;
use Yii;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

class SystemUser extends ActiveRecord implements IdentityInterface
{
    public $password;

    public static function tableName()
    {
        return 'users';
    }

    public function rules()
    {
        return [
            [['username', 'email', 'role', 'center_id'], 'required'],
            [['password'], 'required', 'on' => 'create'],
            [['password'], 'string', 'min' => 8],
            [['status', 'center_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['username', 'email', 'password_hash', 'auth_key', 'role', 'password'], 'string', 'max' => 255],
            [['role'], 'in', 'range' => array_keys(self::roleOptions())],
            [['username'], 'unique'],
            [['email'], 'unique'],
            [['center_id'], 'exist', 'skipOnError' => true, 'targetClass' => Center::class, 'targetAttribute' => ['center_id' => 'id']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'username' => 'Jina la Mtumiaji',
            'email' => 'Barua Pepe',
            'password' => 'Nenosiri',
            'role' => 'Wajibu',
            'center_id' => 'Sharika',
            'status' => 'Hali',
            'created_at' => 'Tarehe ya Kuundwa',
            'updated_at' => 'Tarehe ya Kubadilishwa',
        ];
    }

    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => 1]);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        return null;
    }

    public static function findByUsername($username)
    {
        return static::find()
            ->where(['username' => $username])
            ->orWhere(['email' => $username])
            ->andWhere(['status' => 1])
            ->one();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getAuthKey()
    {
        return $this->auth_key;
    }

    public function validateAuthKey($authKey)
    {
        return $this->auth_key === $authKey;
    }

    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    public static function roleOptions(): array
    {
        return [
            'admin' => 'Msimamizi',
            'clerk' => 'Karani',
            'viewer' => 'Mtazamaji',
        ];
    }

    public static function statusOptions(): array
    {
        return [
            1 => 'Amilifu',
            0 => 'Si Amilifu',
        ];
    }

    public static function roleLabel(?string $role): string
    {
        return self::roleOptions()[$role] ?? (($role !== null && $role !== '') ? $role : '-');
    }

    public static function statusLabel(?int $status): string
    {
        return self::statusOptions()[$status] ?? '-';
    }

    public function getCenter()
    {
        return $this->hasOne(Center::class, ['id' => 'center_id']);
    }

    public function beforeSave($insert)
    {
        if (!parent::beforeSave($insert)) {
            return false;
        }

        $now = date('Y-m-d H:i:s');
        if ($insert && $this->hasAttribute('created_at') && empty($this->created_at)) {
            $this->created_at = $now;
        }
        if ($this->hasAttribute('updated_at')) {
            $this->updated_at = $now;
        }

        if (!empty($this->password)) {
            $this->password_hash = Yii::$app->security->generatePasswordHash($this->password);
        }

        if (empty($this->auth_key)) {
            try {
                $this->auth_key = Yii::$app->security->generateRandomString(32);
            } catch (Exception $e) {
                $this->auth_key = bin2hex(random_bytes(16));
            }
        }

        if ($this->status === null) {
            $this->status = 1;
        }

        return true;
    }
}
