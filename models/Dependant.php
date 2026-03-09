<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "dependants".
 *
 * @property int $id
 * @property string $first_name
 * @property string|null $middle_name
 * @property string $last_name
 * @property string $dob
 * @property int $user_id
 * @property string $dependant_type
 * @property int|null $is_budtized
 * @property string|null $occupation
 *
 * @property User $user
 */
class Dependant extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'dependants';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['middle_name', 'occupation'], 'default', 'value' => null],
            [['dependant_type'], 'default', 'value' => 'CHILD'],
            [['is_budtized'], 'default', 'value' => 0],
            [['first_name', 'last_name', 'dob', 'user_id'], 'required'],
            [['dob'], 'safe'],
            [['user_id', 'is_budtized'], 'integer'],
            [['first_name', 'middle_name', 'last_name', 'dependant_type', 'occupation'], 'string', 'max' => 255],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Mtoto',
            'first_name' => 'Jina la Kwanza',
            'middle_name' => 'Jina la Kati',
            'last_name' => 'Jina la Mwisho',
            'dob' => 'Tarehe ya Kuzaliwa',
            'user_id' => 'Jina la Msharika',
            'dependant_type' => 'Mtoto',
            'is_budtized' => 'Amebatizwa?',
            'occupation' => 'Kazi Anayofanya',
        ];
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

}
