<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class CreateCars extends AbstractMigration
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
        $table = $this->table('cars');
        $table->addColumn('license_plate', 'string', [
                'limit' => 15,
                'null' => false,
                'default' => null,
            ])
            ->addColumn('license_state', 'string', [
                'null' => false,
                'default' => null,
            ])
            ->addColumn('vin', 'string', [
                'limit' => 30,
                'null' => false,
                'default' => null,
            ])
            ->addColumn('year', 'integer', [
                'null' => false,
                'default' => null,
            ])
            ->addColumn('colour', 'string', [
                'limit' => 20,
                'null' => false,
                'default' => null,
            ])
            ->addColumn('make', 'string', [
                'limit' => 100,
                'null' => false,
                'default' => null,
            ])
            ->addColumn('model', 'string', [
                'limit' => 150,
                'null' => false,
                'default' => null,
            ])
        ->create();
    }
}
