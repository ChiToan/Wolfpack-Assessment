<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%wolfPack}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%pack}}`
 * - `{{%wolf}}`
 */
class m200830_150826_create_wolfPack_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%wolfPack}}', [
            'id' => $this->primaryKey(),
            'pack_id' => $this->integer()->notNull(),
            'wolf_id' => $this->integer()->notNull(),
        ]);

        // creates index for column `pack_id`
        $this->createIndex(
            '{{%idx-wolfPack-pack_id}}',
            '{{%wolfPack}}',
            'pack_id'
        );

        // add foreign key for table `{{%pack}}`
        $this->addForeignKey(
            '{{%fk-wolfPack-pack_id}}',
            '{{%wolfPack}}',
            'pack_id',
            '{{%pack}}',
            'id',
            'CASCADE'
        );

        // creates index for column `wolf_id`
        $this->createIndex(
            '{{%idx-wolfPack-wolf_id}}',
            '{{%wolfPack}}',
            'wolf_id'
        );

        // add foreign key for table `{{%wolf}}`
        $this->addForeignKey(
            '{{%fk-wolfPack-wolf_id}}',
            '{{%wolfPack}}',
            'wolf_id',
            '{{%wolf}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%pack}}`
        $this->dropForeignKey(
            '{{%fk-wolfPack-pack_id}}',
            '{{%wolfPack}}'
        );

        // drops index for column `pack_id`
        $this->dropIndex(
            '{{%idx-wolfPack-pack_id}}',
            '{{%wolfPack}}'
        );

        // drops foreign key for table `{{%wolf}}`
        $this->dropForeignKey(
            '{{%fk-wolfPack-wolf_id}}',
            '{{%wolfPack}}'
        );

        // drops index for column `wolf_id`
        $this->dropIndex(
            '{{%idx-wolfPack-wolf_id}}',
            '{{%wolfPack}}'
        );

        $this->dropTable('{{%wolfPack}}');
    }
}
