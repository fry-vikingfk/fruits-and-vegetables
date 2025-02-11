<?php

namespace App\Traits;

trait RequestValidatorTrait
{
    public function validate(object $object): ?array
    {
        $errorMessages = [];
        $errors = $this->validator->validate($object);

        if (count($errors) > 0) {
            foreach ($errors as $error) {
                $errorMessages[] = $error->getPropertyPath() . ': ' . $error->getMessage();
            }
            
            return $errorMessages;
        }
        
        return null;
    }
}
