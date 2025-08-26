<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%contact_deal}}`.
 */
class m250826_081905_create_contact_deal_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('contact_deal', [
            'id' => $this->primaryKey(),
            'contact_id' => $this->integer()->notNull(),
            'deal_id' => $this->integer()->notNull(),
        ]);

        $this->addForeignKey(
            'fk-contact_deal_contact_id',
            'contact_deal',
            'contact_id',
            'contacts',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-contact_deal_deal_id',
            'contact_deal',
            'deal_id',
            'deals',
            'id',
            'CASCADE'
        );

        $this->createIndex('idx-contact_deal-contact_id', 'contact_deal', 'contact_id');
        $this->createIndex('idx-contact_deal-deal_id', 'contact_deal', 'deal_id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('contact_deal');
    }
}
