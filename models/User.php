<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "users".
 *
 * @property int $id
 * @property string $first_name
 * @property string|null $middle_name
 * @property string $last_name
 * @property string|null $designation
 * @property string|null $denomination
 * @property string|null $dob
 * @property string|null $dob_region
 * @property string|null $dob_district
 * @property int|null $is_baptized
 * @property string|null $marital_status
 * @property int|null $confirmation
 * @property string|null $marriage_type
 * @property string|null $spouse_name
 * @property int|null $is_join_table
 * @property string|null $street_join
 * @property string|null $church_elder
 * @property string|null $occupation
 * @property string|null $occupation_place
 * @property string|null $designation_designation
 * @property string|null $phone
 * @property string|null $email
 * @property string|null $next_of_kin_phone
 * @property string|null $home_congregation
 * @property int $center_id
 * @property string $password
 * @property string|null $authKey
 * @property string|null $password_reset_token
 * @property string|null $user_image
 * @property int|null $status
 * @property string|null $updated_at
 * @property string|null $created_at
 * @property int|null $created_by
 *
 * @property Center $center
 * @property Contribution[] $contributions
 * @property User $createdBy
 * @property Region $dobRegion
 * @property District $dobDistrict
 * @property Dependant[] $dependants
 * @property User[] $users
 */
class User extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{
    public $old_password;
    public $new_password;
    public $repeat_password;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'members';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['middle_name', 'designation', 'denomination', 'gender', 'dob', 'dob_region', 'dob_district', 'marital_status', 'marriage_type', 'spouse_name', 'street_join', 'church_elder', 'occupation', 'occupation_place', 'designation_designation', 'phone', 'email', 'next_of_kin_phone', 'home_congregation', 'authKey', 'password_reset_token', 'user_image', 'updated_at', 'created_at', 'created_by'], 'default', 'value' => null],
            [['is_join_table'], 'default', 'value' => 0],
            [['status'], 'default', 'value' => 1],
            [['first_name', 'last_name', 'center_id'], 'required'],
            [['dob', 'updated_at', 'created_at'], 'safe'],
            [['is_baptized', 'confirmation', 'is_join_table', 'center_id', 'status', 'created_by'], 'integer'],
            [['first_name', 'middle_name', 'last_name', 'designation', 'denomination', 'dob_region', 'dob_district', 'marital_status', 'marriage_type', 'spouse_name', 'street_join', 'church_elder', 'occupation', 'occupation_place', 'designation_designation', 'phone', 'email', 'next_of_kin_phone', 'home_congregation', 'password', 'authKey', 'password_reset_token', 'user_image'], 'string', 'max' => 255],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => SystemUser::class, 'targetAttribute' => ['created_by' => 'id']],
            [['center_id'], 'exist', 'skipOnError' => true, 'targetClass' => Center::class, 'targetAttribute' => ['center_id' => 'id']],
            [['dob_district'], 'exist', 'skipOnError' => true, 'targetClass' => District::class, 'targetAttribute' => ['dob_district' => 'id']],
            [['dob_region'], 'exist', 'skipOnError' => true, 'targetClass' => Region::class, 'targetAttribute' => ['dob_region' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'first_name' => 'Jina la Kwanza',
            'middle_name' => 'Jina la  Kati',
            'last_name' => 'Jina la Mwisho',
            'gender' => 'Jinsia',
            'designation' => 'Bahasha',
            'denomination' => 'Dhehebu Lako',
            'dob' => 'Tarehe ya Kuzaliwa',
            'dob_region' => 'Mkoa Uliozaliwa',
            'dob_district' => 'Wilaya Uliozaliwa',
            'is_baptized' => 'Umebatizwa',
            'marital_status' => 'Hali ya Ndoa',
            'confirmation' => 'Amepata Kipaimara',
            'marriage_type' => 'Aina ya Ndoa',
            'spouse_name' => 'Jina la Mke/Mme',
            'is_join_table' => 'Unashiriki Jumuiya?',
            'street_join' => 'Mtaa wa Jumuiya',
            'church_elder' => 'Mzee wa Kanisa',
            'occupation' => 'Kazi ya Msharika',
            'occupation_place' => 'Sehemu ya Kazi',
            'designation_designation' => 'Bahasha',
            'phone' => 'Namba ya Simu',
            'email' => 'Barua Pepe',
            'next_of_kin_phone' => 'Mtu wa Karibu',
            'home_congregation' => 'Usharika wa Nyumbani',
            'center_id' => 'Sharika',
            'password' => 'Nenosiri',
            'authKey' => 'Ufunguo wa Utambulisho',
            'password_reset_token' => 'Tokeni ya Kuweka Upya Nenosiri',
            'user_image' => 'Picha ya Msharika',
            'status' => 'Hali ya Usajili',
            'updated_at' => 'Muda wa Kubadili taarifa za usajili',
            'created_at' => 'Muda wa Kusajili',
            'created_by' => 'Aliyesajili',
        ];
    }

    public static function genderOptions(): array
    {
        return [
            'Me' => 'Mwanaume',
            'Ke' => 'Mwanamke',
        ];
    }

    public static function genderLabel(?string $value): string
    {
        $labels = self::genderOptions() + [
            'Male' => 'Mwanaume',
            'Female' => 'Mwanamke',
        ];

        return $labels[$value] ?? (($value !== null && $value !== '') ? $value : '-');
    }

    public static function maritalStatusOptions(): array
    {
        return [
            'Single' => 'Hajaoa/Hajaolewa',
            'Married' => 'Ameoa/Ameolewa',
            'Divorced' => 'Ameachika',
            'Widowed' => 'Mjane',
        ];
    }

    public static function maritalStatusLabel(?string $value): string
    {
        return self::maritalStatusOptions()[$value] ?? (($value !== null && $value !== '') ? $value : '-');
    }

    public static function marriageTypeOptions(): array
    {
        return [
            'Mke Moja' => 'Mke Mmoja',
            'Wake Wengi' => 'Wake Wengi',
        ];
    }

    public static function marriageTypeLabel(?string $value): string
    {
        return self::marriageTypeOptions()[$value] ?? (($value !== null && $value !== '') ? $value : '-');
    }

    public static function yesNoOptions(): array
    {
        return [
            1 => 'Ndiyo',
            0 => 'Hapana',
        ];
    }

    public static function yesNoLabel($value): string
    {
        if ($value === null || $value === '') {
            return '-';
        }

        return (int) $value === 1 ? 'Ndiyo' : 'Hapana';
    }

    public static function memberStatusOptions(): array
    {
        return [
            1 => 'Hai',
            2 => 'Si Hai',
            3 => 'Amehama',
            4 => 'Amefariki',
        ];
    }

    public static function memberStatusLabel(?int $status): string
    {
        return self::memberStatusOptions()[$status] ?? '-';
    }

    /**
     * Gets query for [[Center]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCenter()
    {
        return $this->hasOne(Center::class, ['id' => 'center_id']);
    }

    /**
     * Gets query for [[Contributions]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getContributions()
    {
        return $this->hasMany(Contribution::class, ['user_id' => 'id']);
    }

    /**
     * Gets query for [[CreatedBy]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy()
    {
        return $this->hasOne(SystemUser::class, ['id' => 'created_by']);
    }

    /**
     * Gets query for [[Dependants]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDependant()
    {
        return $this->hasMany(Dependant::class, ['user_id' => 'id']);
    }



    /**
     * Gets query for [[Region]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDobRegion()
    {
        return $this->hasOne(Region::class, ['id' => 'dob_region']);
    }


    /**
     * Gets query for [[District]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDobDistrict()
    {
        return $this->hasOne(District::class, ['id' => 'dob_district']);
    }


    /**
     * Gets query for [[Users]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedMembers()
    {
        return $this->hasMany(User::class, ['created_by' => 'id']);
    }

    public static function findIdentity($id)
    {
        $user = self::find()
            ->where([
                "id" => $id
            ])
            ->one();
        // if (!count($user)) {
        //     return null;
        // }
        if ($user == null) {
            return null;
        }
        return new static($user);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $userType = null)
    {

        $user = self::find()
            ->where(["accessToken" => $token])
            ->one();
        // if (!count($user)) {
        //     return null;
        // }
        if ($user == null) {
            return null;
        }
        return new static($user);
    }
    //matching the old password with your existing password.
    public function findPasswords($attribute, $params)
    {
        $this->addError($attribute, 'Mabadiliko ya nenosiri yanasimamiwa kupitia watumiaji wa mfumo.');
    }

    /**
     * Finds user by email
     *
     * @param  string      $email
     * @return static|null
     */
  public static function findByUsername($email)
{
    return self::find()
        ->where(["email" => $email])
        ->one();
}

    public function getUsername()
    {
        return \Yii::$app->user->identity->email;
    }

    public function getFname()
    {
        return \Yii::$app->user->identity->fname;
    }
    public static function findByUser($email)
    {
        $user = self::find()
            ->where([
                "email" => $email
            ])
            ->one();
        if (!count($user)) {
            return null;
        }
        return $user;
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->authKey;
    }

    public function generateAuthKey()
    {
        $this->authKey = Yii::$app->security->generateRandomString();
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->authKey === $authKey;
    }

    /**
     * Validates password
     *
     * @param  string  $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return false;
    }

    // In your model (e.g., Post.php)
public function getFormattedDate()
{
    return Yii::$app->formatter->asDate($this->created_at, 'php:d-m-Y');
}

}
