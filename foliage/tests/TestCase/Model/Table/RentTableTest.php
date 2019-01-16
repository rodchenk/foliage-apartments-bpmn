<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\RentTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\RentTable Test Case
 */
class RentTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\RentTable
     */
    public $Rent;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.Rent'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Rent') ? [] : ['className' => RentTable::class];
        $this->Rent = TableRegistry::getTableLocator()->get('Rent', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Rent);

        parent::tearDown();
    }

    /**
     * Test initialize method
     *
     * @return void
     */
    public function testInitialize()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
