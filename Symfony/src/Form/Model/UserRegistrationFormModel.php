<?php

namespace App\Form\Model;

use App\Validator\UniqueUser;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class UserRegistrationFormModel
{
    #[NotBlank]
    #[Email]
    #[UniqueUser]
    public $email;

    #[NotBlank(message: 'Пароль не указан')]
    #[Length(min: 6, minMessage: 'Пароль должен быть более 6 символов')]
    public $plainPassword;

    #[IsTrue(message: 'Вы должны согласиться с условиями')]
    public $agreeTerms;
}