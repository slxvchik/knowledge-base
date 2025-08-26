<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%deal}}`.
 */
class m250826_081720_create_deal_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('deals', [
            'id' => $this->primaryKey(),
            'name' => $this->string(100)->notNull(),
            'sum' => $this->integer(),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('deals');
    }
}
