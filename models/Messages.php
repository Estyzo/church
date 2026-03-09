<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "messages".
 *
 * @property int $id
 * @property string $subject
 * @property string $content
 * @property int $created_by
 * @property string|null $center_at
 *
 * @property SystemUser $createdBy
 */
class Messages extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'messages';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['center_at'], 'default', 'value' => null],
            [['subject', 'content', 'created_by'], 'required'],
            [['content'], 'string'],
            [['created_by'], 'integer'],
            [['center_at'], 'safe'],
            [['subject'], 'string', 'max' => 255],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => SystemUser::class, 'targetAttribute' => ['created_by' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'subject' => 'Kichwa cha Ujumbe',
            'content' => 'Maelezo',
            'created_by' => 'Umetumwa na',
            'center_at' => 'Saa ya Kutuma',
        ];
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

}
