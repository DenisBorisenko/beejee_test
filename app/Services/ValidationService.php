<?php

namespace App\Services;

class ValidationService {

    protected $validationMessages = [];

    public function process($rules) {
        foreach ($rules as $key => $rule) {
            if (strpos($rule, "required") !== false) {
                $this->validateRequired($key);
            }
            if (strpos($rule, "email") !== false) {
                $this->validateEmail($key);
            }
        }

        return $this->validationMessages;
    }

    private function validateRequired($key) {
        if (empty($_POST[$key]) || $_POST[$key] === 'null') {
            $this->validationMessages[$key] = 'Проверьте наличие букв в форме';
        }
    }

    private function validateEmail($key) {
        if (!empty($_POST[$key]) && !filter_var($_POST[$key], FILTER_VALIDATE_EMAIL)) {
            $this->validationMessages[$key] = 'Некорректная почта';
        }
    }

}