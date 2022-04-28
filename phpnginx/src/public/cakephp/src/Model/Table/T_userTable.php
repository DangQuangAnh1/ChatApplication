<?php
// in src/Model/Table/ArticlesTable.php
namespace App\Model\Table;

use Cake\ORM\Table;
// the Text class
use Cake\Utility\Text;
// the EventInterface class
use Cake\Event\EventInterface;
// the Validator class
use Cake\Validation\Validator;
class T_userTable extends Table
{
    public function initialize(array $config): void
    {
        $this->addBehavior('Timestamp');
    }
    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->notEmptyString('email')
            ->minLength('email', 1)
            ->maxLength('email', 255)

            ->notEmptyString('password')
            ->minLength('password', 1)
            ->maxLength('password', 255)

            ->notEmptyString('name')
            ->minLength('name', 1)
            ->maxLength('name', 255);

        return $validator;
    }
}
