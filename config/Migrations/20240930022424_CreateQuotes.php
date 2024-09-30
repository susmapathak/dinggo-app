<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class CreateQuotes extends AbstractMigration
{
    /**
     * Change Method.
     *
     * More information on this method is available here:
     * https://book.cakephp.org/phinx/0/en/migrations.html#the-change-method
     * @return void
     */
    public function change(): void
    {
        $table = $this->table('quotes');
        $table->addColumn('price', 'string', [
            'default' => null,
            'limit' => 255,
            'null' => false,
        ]);
        $table->addColumn('repairer', 'string', [
            'default' => null,
            'limit' => 255,
            'null' => false,
        ]);
        $table->addColumn('overviewOfWork', 'text', [
            'default' => null,
            'null' => false,
        ]);
        $table->addColumn('car_id', 'integer', [
            'default' => null,
            'limit' => 11,
            'null' => false,
        ]);
         $table->addForeignKey('car_id', 'cars', 'id', [
            'delete' => 'CASCADE',
            'update' => 'NO_ACTION',
        ]);
        $table->create();
    }
}
