<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Rent Model
 *
 * @method \App\Model\Entity\Rent get($primaryKey, $options = [])
 * @method \App\Model\Entity\Rent newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Rent[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Rent|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Rent|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Rent patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Rent[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Rent findOrCreate($search, callable $callback = null, $options = [])
 */
class RentTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('rent');
        $this->setDisplayField('RentID');
        $this->setPrimaryKey('RentID');
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->integer('RentID')
            ->allowEmptyString('RentID', 'create');

        $validator
            ->integer('UserID')
            ->requirePresence('UserID', 'create')
            ->allowEmptyString('UserID', false);

        $validator
            ->integer('ApartmentID')
            ->requirePresence('ApartmentID', 'create')
            ->allowEmptyString('ApartmentID', false);

        $validator
            ->date('DateFrom')
            ->requirePresence('DateFrom', 'create')
            ->allowEmptyDate('DateFrom', false);

        $validator
            ->date('DateTo')
            ->requirePresence('DateTo', 'create')
            ->allowEmptyDate('DateTo', false);

        return $validator;
    }
}
