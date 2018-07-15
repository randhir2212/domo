<?php

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

class FemalesTable extends Table {

    public function initialize(array $config) {
        parent::initialize($config);

        $this->table('females');
        $this->displayField('name');
        $this->primaryKey('id');
        $this->addBehavior('Timestamp');
		$this->belongsTo('Types', [
            'foreignKey' => 'type_id',
            'joinType' => 'INNER'
        ]);
    }

    public function validationDefault(Validator $validator) {
        $validator
                ->integer('id')
                ->allowEmpty('id', 'create');

        return $validator;
    }




}
