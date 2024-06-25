<?php

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Exception\UnexpectedValueException;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use App\Entity\User;

class BlackListValidationValidator extends ConstraintValidator
{
    private $httpClient;

    public function __construct(HttpClientInterface $httpClient)
    {
        $this->httpClient = $httpClient;
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

        $response = $this->httpClient->request('POST', 'http://44.210.144.170/check-blacklist/', [
            'json' => $data,
        ]);


        if ($response->getStatusCode() !== 201) {
            $this->context->buildViolation($constraint->message)
                ->addViolation();
            return;
        }

        $responseData = $response->toArray(false);
        
        if ($responseData['is_in_blacklist']) {
            $this->context->buildViolation($constraint->message)
                ->addViolation();
        }
    }
}