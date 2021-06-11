<?php
namespace App\Validate;

interface IValidator
{
    public function activateField(string $field, $value);
    public function validate():array;
    public function isValidate():bool;
    public static function getPatterns():array;
    public function reset();
}