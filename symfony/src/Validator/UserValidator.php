<?php
namespace App\Validator;

namespace App\Validator;

use App\DTO\UserDTO;
use App\Repository\UserRepository;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\ConstraintViolationList;

class UserValidator
{
    private $validator;
    private $userRepository;

    public function __construct(ValidatorInterface $validator, UserRepository $userRepository)
    {
        $this->validator = $validator;
        $this->userRepository = $userRepository;
    }

    public function validate(UserDTO $userDTO): ConstraintViolationListInterface
    {
        $errors = $this->validator->validate($userDTO);

        if ($this->userRepository->findOneBy(['email' => $userDTO->getEmail()])) {
            $violation = new ConstraintViolation(
                'This email is already in use.', // Message
                null,                           // Message template
                [],                             // Message parameters
                $userDTO,                       // Root
                'email',                        // Property path
                $userDTO->getEmail()            // Invalid value
            );

            if ($errors instanceof ConstraintViolationList) {
                $errors->add($violation);
            } else {
                $errors = new ConstraintViolationList([$violation]);
            }
        }

        return $errors;
    }
}