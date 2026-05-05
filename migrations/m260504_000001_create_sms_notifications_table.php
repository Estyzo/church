<?php

use yii\db\Migration;

class m260504_000001_create_sms_notifications_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%sms_notifications}}', [
            'id' => $this->primaryKey(),
            'member_id' => $this->integer()->null(),
            'phone' => $this->string(32)->notNull(),
            'message' => $this->text()->notNull(),
            'status' => $this->string(20)->notNull()->defaultValue('pending'),
            'attempts' => $this->integer()->notNull()->defaultValue(0),
            'last_error' => $this->text()->null(),
            'provider_response' => $this->text()->null(),
            'sent_at' => $this->dateTime()->null(),
            'created_at' => $this->dateTime()->notNull(),
            'updated_at' => $this->dateTime()->notNull(),
        ]);

        $this->createIndex('{{%idx-sms_notifications-member_id}}', '{{%sms_notifications}}', 'member_id');
        $this->createIndex('{{%idx-sms_notifications-status-created_at}}', '{{%sms_notifications}}', ['status', 'created_at']);

        $this->addForeignKey(
            '{{%fk-sms_notifications-member_id}}',
            '{{%sms_notifications}}',
            'member_id',
            '{{%members}}',
            'id',
            'SET NULL',
            'CASCADE'
        );
    }

    public function safeDown()
    {
        $this->dropForeignKey('{{%fk-sms_notifications-member_id}}', '{{%sms_notifications}}');
        $this->dropIndex('{{%idx-sms_notifications-status-created_at}}', '{{%sms_notifications}}');
        $this->dropIndex('{{%idx-sms_notifications-member_id}}', '{{%sms_notifications}}');
        $this->dropTable('{{%sms_notifications}}');
    }
}
