<?php

use yii\db\Migration;
use yii\db\mysql\Schema;

class m250317_113847_newLocationsTable extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m250317_113847_newLocationsTable cannot be reverted.\n";

        return false;
    }


    // Use up()/down() to run migration code without a transaction.
    public function up()
    {
        $this->createTable('locations', [
            'id' => $this->string()->notNull()->unique(),
            'default_terminal_id' => $this->string()->notNull(),
            'name' => $this->string(),
            'country' => $this->string(),
            'coordinates' => $this->string(),
            'type' => $this->string(),
        ]);
    }

    public function down()
    {
        $this->dropTable('locations');
    }

}
