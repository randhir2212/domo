<?php

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

class TypesTable extends Table {

    public function initialize(array $config) {
        parent::initialize($config);

        $this->table('types');
        $this->displayField('name');
        $this->primaryKey('id');
        $this->addBehavior('Timestamp');
		$this->hasMany('Females', [
        ]);
		$this->hasMany('Males', [
        ]);


    }

    public function validationDefault(Validator $validator) {
        $validator
                ->integer('id')
                ->allowEmpty('id', 'create');

        return $validator;
    }




}
