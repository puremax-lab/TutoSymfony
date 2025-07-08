<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

// final class InappropriateWordsValidator extends ConstraintValidator
// {
//     public function validate(mixed $value, Constraint $constraint): void
//     {
//         /* @var InappropriateWords $constraint */

//         if (null === $value || '' === $value) {
//             return;
//         }

//         // TODO: implement the validation here
//         $this->context->buildViolation($constraint->message)
//             ->setParameter('{{ value }}', $value)
//             ->addViolation()
//         ;
//     }
// }

class InappropriateWordsValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint)
    {
        /* @var InappropriateWords $constraint */

        if (null === $value || '' === $value) {
            return;
        }

        // on met d'abord le mot introduit dans le formulaire en minuscule
        // on fait ensuite une boucle pour vérifier que le mot interdit n'est pas dans notre liste
        // si c'est le cas on ajoute une violation
        $value = strtolower($value);
        foreach ($constraint->listWords as $inappropriateWord) {
            if (str_contains($value, $inappropriateWord)) {
                $this->context->buildViolation($constraint->message)
                    ->setParameter('{{ inapropriateWords }}', $inappropriateWord)
                    ->addViolation();
            }
        }
