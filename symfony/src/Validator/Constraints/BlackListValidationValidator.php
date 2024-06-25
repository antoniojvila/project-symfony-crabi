<?php

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Exception\UnexpectedValueException;
use App\Entity\User;
use App\Service\BlackListService;

class BlackListValidationValidator extends ConstraintValidator
{
    private $blackListService;

    public function __construct(BlackListService $blackListService)
    {
        $this->blackListService = $blackListService;
    }

    public function validate($value, Constraint $constraint)
    {
        if (!$constraint instanceof BlackListValidation) {
            throw new UnexpectedTypeException($constraint, BlackListValidation::class);
        }

        $user = $this->context->getObject();
        if (!$user instanceof User) {
            throw new UnexpectedValueException($user, User::class);
        }

        $data = [
            'first_name' => $user->getFirstName(),
            'last_name' => $user->getLastName(),
            'email' => $user->getEmail(),
        ];

        try {
            $isInBlackList = $this->blackListService->checkBlackList($data);

            if ($isInBlackList) {
                $this->context->buildViolation($constraint->message)
                    ->addViolation();
            }
        } catch (\Exception $e) {
            $this->context->buildViolation('There was an error validating the blacklist.')
                ->addViolation();
        }
    }
}