<?php

namespace App\Model\Entity;

use Cake\ORM\Entity;

class T_user extends Entity
{
    protected $_accessible = [
        '*' => true,
        'user_id' => false
    ];
}