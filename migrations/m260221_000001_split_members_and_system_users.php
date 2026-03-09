<?php

use yii\base\Security;
use yii\db\Migration;

class m260221_000001_split_members_and_system_users extends Migration
{
    public function safeUp()
    {
        $this->renameTable('{{%users}}', '{{%members}}');

        $this->createTable('{{%users}}', [
            'id' => $this->primaryKey(),
            'username' => $this->string()->notNull()->unique(),
            'email' => $this->string()->notNull()->unique(),
            'password_hash' => $this->string()->notNull(),
            'auth_key' => $this->string(64)->notNull(),
            'role' => $this->string(50)->notNull()->defaultValue('clerk'),
            'status' => $this->smallInteger()->notNull()->defaultValue(1),
            'created_at' => $this->dateTime()->notNull(),
            'updated_at' => $this->dateTime()->notNull(),
        ]);

        $security = new Security();
        $now = date('Y-m-d H:i:s');
        $this->insert('{{%users}}', [
            'username' => 'admin',
            'email' => 'admin@church.local',
            'password_hash' => $security->generatePasswordHash('ChangeMe123!'),
            'auth_key' => $security->generateRandomString(32),
            'role' => 'admin',
            'status' => 1,
            'created_at' => $now,
            'updated_at' => $now,
        ]);
        $adminId = (int) $this->db->getLastInsertID();

        // Members are no longer login identities.
        $this->alterColumn('{{%members}}', 'password', $this->string(255)->null());
        $this->update('{{%members}}', ['password' => null]);

        // Existing created_by values currently reference members. Drop those constraints
        // before repointing the values to the new system users table.
        $this->dropForeignKey('{{%fk-messages-created_by}}', '{{%messages}}');
        $this->dropForeignKey('{{%fk-contributions-created_by}}', '{{%contributions}}');

        // Normalize created_by values to the system admin.
        $this->update('{{%messages}}', ['created_by' => $adminId]);
        $this->update('{{%contributions}}', ['created_by' => $adminId], ['not', ['created_by' => null]]);
        $this->update('{{%members}}', ['created_by' => null]);

        // Rewire foreign keys to the right table after split.
        $this->dropForeignKey('{{%fk-user-created_by}}', '{{%members}}');
        $this->addForeignKey(
            '{{%fk-members-created_by-users}}',
            '{{%members}}',
            'created_by',
            '{{%users}}',
            'id',
            'SET NULL',
            'CASCADE'
        );

        $this->dropForeignKey('{{%fk-dependants-user_id}}', '{{%dependants}}');
        $this->addForeignKey(
            '{{%fk-dependants-user_id}}',
            '{{%dependants}}',
            'user_id',
            '{{%members}}',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->dropForeignKey('{{%fk-contributions-user_id}}', '{{%contributions}}');
        $this->addForeignKey(
            '{{%fk-contributions-user_id}}',
            '{{%contributions}}',
            'user_id',
            '{{%members}}',
            'id',
            'SET NULL',
            'CASCADE'
        );

        $this->addForeignKey(
            '{{%fk-contributions-created_by}}',
            '{{%contributions}}',
            'created_by',
            '{{%users}}',
            'id',
            'SET NULL',
            'CASCADE'
        );

        $this->addForeignKey(
            '{{%fk-messages-created_by}}',
            '{{%messages}}',
            'created_by',
            '{{%users}}',
            'id',
            'RESTRICT',
            'CASCADE'
        );
    }

    public function safeDown()
    {
        $this->dropForeignKey('{{%fk-messages-created_by}}', '{{%messages}}');
        $this->addForeignKey(
            '{{%fk-messages-created_by}}',
            '{{%messages}}',
            'created_by',
            '{{%members}}',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->dropForeignKey('{{%fk-contributions-created_by}}', '{{%contributions}}');
        $this->addForeignKey(
            '{{%fk-contributions-created_by}}',
            '{{%contributions}}',
            'created_by',
            '{{%members}}',
            'id',
            'SET NULL',
            'CASCADE'
        );

        $this->dropForeignKey('{{%fk-contributions-user_id}}', '{{%contributions}}');
        $this->addForeignKey(
            '{{%fk-contributions-user_id}}',
            '{{%contributions}}',
            'user_id',
            '{{%members}}',
            'id',
            'SET NULL',
            'CASCADE'
        );

        $this->dropForeignKey('{{%fk-dependants-user_id}}', '{{%dependants}}');
        $this->addForeignKey(
            '{{%fk-dependants-user_id}}',
            '{{%dependants}}',
            'user_id',
            '{{%members}}',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->dropForeignKey('{{%fk-members-created_by-users}}', '{{%members}}');
        $this->addForeignKey(
            '{{%fk-user-created_by}}',
            '{{%members}}',
            'created_by',
            '{{%members}}',
            'id',
            'SET NULL',
            'CASCADE'
        );

        $this->dropTable('{{%users}}');
        $this->renameTable('{{%members}}', '{{%users}}');
    }
}
