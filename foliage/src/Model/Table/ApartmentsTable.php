<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Apartments Model
 *
 * @method \App\Model\Entity\Apartment get($primaryKey, $options = [])
 * @method \App\Model\Entity\Apartment newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Apartment[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Apartment|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Apartment|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Apartment patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Apartment[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Apartment findOrCreate($search, callable $callback = null, $options = [])
 */
class ApartmentsTable extends Table
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

        $this->setTable('apartments');
        $this->setDisplayField('ApartmentID');
        $this->setPrimaryKey('ApartmentID');

        $this->belongsTo('Users', [
                'className' => 'Users'
            ])
            ->setForeignKey('UserID')
            ->setProperty('User');
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
            ->integer('ApartmentID')
            ->allowEmptyString('ApartmentID', 'create');

        $validator
            ->integer('UserID')
            ->requirePresence('UserID', 'create')
            ->allowEmptyString('UserID', false);

        $validator
            ->scalar('Location')
            ->maxLength('Location', 96)
            ->requirePresence('Location', 'create')
            ->allowEmptyString('Location', false);

        $validator
            ->numeric('Price')
            ->requirePresence('Price', 'create')
            ->allowEmptyString('Price', false);

        $validator
            ->scalar('image')
            ->maxLength('image', 96)
            ->requirePresence('image', 'create')
            ->allowEmptyFile('image', false);

        $validator
            ->scalar('Topic')
            ->maxLength('Topic', 128)
            ->requirePresence('Topic', 'create')
            ->allowEmptyString('Topic', false);

        return $validator;
    }
}
