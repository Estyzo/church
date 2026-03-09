<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "contributions".
 *
 * @property int $id
 * @property int $user_id
 * @property int $created_by
 * @property int $contribution_type_id
 * @property float $amount
 * @property string $date_of_payment
 * @property string $payment_mode
 * @property string|null $reference_no
 * @property string|null $payment_desc
 * @property string|null $channel_name
 *
 * @property ContributionsType $contributionsType
 * @property User $user
 * @property SystemUser $createdBy
 */
class Contribution extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'contributions';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['reference_no', 'payment_desc', 'channel_name'], 'default', 'value' => null],
            [['user_id', 'contribution_type_id', 'amount', 'date_of_payment', 'payment_mode'], 'required'],
            [['user_id', 'created_by', 'contribution_type_id'], 'integer'],
            [['amount'], 'number'],
            [['date_of_payment'], 'safe'],
            [['payment_desc'], 'string'],
            [['payment_mode', 'reference_no', 'channel_name'], 'string', 'max' => 255],
            [['contribution_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => ContributionsType::class, 'targetAttribute' => ['contribution_type_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => SystemUser::class, 'targetAttribute' => ['created_by' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Michango',
            'user_id' => 'Jina la Msharika',
            'contribution_type_id' => 'Aina ya Mchango',
            'amount' => 'Kiasi',
            'date_of_payment' => 'Siku aliyolipia',
            'payment_mode' => 'Aina ya Ulipaji',
            'reference_no' => 'Kumbu Namba',
            'payment_desc' => 'Maelezo ya Malipo',
            'channel_name' => 'Jina la Aina ya Ulipaji',
        ];
    }

    /**
     * Gets query for [[ContributionType]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getContributionsType()
    {
        return $this->hasOne(ContributionsType::class, ['id' => 'contribution_type_id']);
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

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy()
    {
        return $this->hasOne(SystemUser::class, ['id' => 'created_by']);
    }
}
