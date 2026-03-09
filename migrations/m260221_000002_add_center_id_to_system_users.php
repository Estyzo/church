<?php

use yii\db\Migration;

class m260221_000002_add_center_id_to_system_users extends Migration
{
    public function safeUp()
    {
        $usersSchema = $this->db->schema->getTableSchema('{{%users}}', true);
        if ($usersSchema === null) {
            throw new RuntimeException('Table {{%users}} not found.');
        }

        if (!isset($usersSchema->columns['center_id'])) {
            $this->addColumn('{{%users}}', 'center_id', $this->integer()->null());
        }

        if ($this->db->schema->getTableSchema('{{%users}}', true)->getColumn('center_id')->allowNull) {
            $defaultCenterId = $this->resolveDefaultCenterId();
            $this->update('{{%users}}', ['center_id' => $defaultCenterId], ['center_id' => null]);
            $this->alterColumn('{{%users}}', 'center_id', $this->integer()->notNull());
        }

        $usersSchema = $this->db->schema->getTableSchema('{{%users}}', true);
        if (!isset($usersSchema->columns['center_id'])) {
            throw new RuntimeException('Column center_id was not created on {{%users}}.');
        }

        if ($this->db->schema->getTableSchema('{{%users}}', true)->getColumn('center_id') !== null) {
            $this->createIndex('{{%idx-users-center_id-system}}', '{{%users}}', 'center_id');
            $this->addForeignKey(
                '{{%fk-users-center_id-system}}',
                '{{%users}}',
                'center_id',
                '{{%centers}}',
                'id',
                'RESTRICT',
                'CASCADE'
            );
        }
    }

    public function safeDown()
    {
        $usersSchema = $this->db->schema->getTableSchema('{{%users}}', true);
        if ($usersSchema === null || !isset($usersSchema->columns['center_id'])) {
            return;
        }

        $this->dropForeignKey('{{%fk-users-center_id-system}}', '{{%users}}');
        $this->dropIndex('{{%idx-users-center_id-system}}', '{{%users}}');
        $this->dropColumn('{{%users}}', 'center_id');
    }

    private function resolveDefaultCenterId(): int
    {
        $centerId = (new \yii\db\Query())->from('{{%centers}}')->select('id')->orderBy(['id' => SORT_ASC])->scalar();
        if ($centerId !== false && $centerId !== null) {
            return (int)$centerId;
        }

        $regionId = (new \yii\db\Query())->from('{{%regions}}')->select('id')->orderBy(['id' => SORT_ASC])->scalar();
        if ($regionId === false || $regionId === null) {
            $this->insert('{{%regions}}', ['name' => 'Default Region']);
            $regionId = (int)$this->db->getLastInsertID();
        } else {
            $regionId = (int)$regionId;
        }

        $districtId = (new \yii\db\Query())
            ->from('{{%districts}}')
            ->select('id')
            ->where(['region_id' => $regionId])
            ->orderBy(['id' => SORT_ASC])
            ->scalar();

        if ($districtId === false || $districtId === null) {
            $this->insert('{{%districts}}', [
                'name' => 'Default District',
                'region_id' => $regionId,
            ]);
            $districtId = (int)$this->db->getLastInsertID();
        } else {
            $districtId = (int)$districtId;
        }

        $this->insert('{{%centers}}', [
            'name' => 'Default Center',
            'address' => 'N/A',
            'district_id' => $districtId,
            'email' => null,
        ]);

        return (int)$this->db->getLastInsertID();
    }
}
