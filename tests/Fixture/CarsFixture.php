<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * CarsFixture
 */
class CarsFixture extends TestFixture
{
    /**
     * Init method
     *
     * @return void
     */
    public function init(): void
    {
        $this->records = [
            [
                'id' => 1,
                'license_plate' => 'Lorem ipsum d',
                'license_state' => 'Lorem ipsum dolor sit amet',
                'vin' => 'Lorem ipsum dolor sit amet',
                'year' => 1,
                'colour' => 'Lorem ipsum dolor ',
                'make' => 'Lorem ipsum dolor sit amet',
                'model' => 'Lorem ipsum dolor sit amet',
            ],
        ];
        parent::init();
    }
}
