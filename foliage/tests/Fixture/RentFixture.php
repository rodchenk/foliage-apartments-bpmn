<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * RentFixture
 *
 */
class RentFixture extends TestFixture
{

    /**
     * Table name
     *
     * @var string
     */
    public $table = 'rent';

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'RentID' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'UserID' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'ApartmentID' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'DateFrom' => ['type' => 'date', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'DateTo' => ['type' => 'date', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        '_indexes' => [
            'UserID' => ['type' => 'index', 'columns' => ['UserID'], 'length' => []],
            'ApartmentID' => ['type' => 'index', 'columns' => ['ApartmentID'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['RentID'], 'length' => []],
            'rent_ibfk_1' => ['type' => 'foreign', 'columns' => ['UserID'], 'references' => ['users', 'UserID'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
            'rent_ibfk_2' => ['type' => 'foreign', 'columns' => ['ApartmentID'], 'references' => ['apartments', 'ApartmentID'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
        ],
        '_options' => [
            'engine' => 'InnoDB',
            'collation' => 'latin1_swedish_ci'
        ],
    ];
    // @codingStandardsIgnoreEnd

    /**
     * Init method
     *
     * @return void
     */
    public function init()
    {
        $this->records = [
            [
                'RentID' => 1,
                'UserID' => 1,
                'ApartmentID' => 1,
                'DateFrom' => '2019-01-16',
                'DateTo' => '2019-01-16'
            ],
        ];
        parent::init();
    }
}
