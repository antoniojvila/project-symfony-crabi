<?php

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

#[\Attribute]
class BlackListValidation extends Constraint
{
    public $message = 'This user is blacklisted.';
}