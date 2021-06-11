<?php
declare(strict_types=1);

namespace App\Validate;

use App\Validate\AbstractValidator;
use App\Validate\Filters\BuildFilter;
use App\Validate\ManagerValidator;
use App\Validate\Filters\FilterAnd;
use App\Validate\Filters\FilterOr;

class Validator implements IValidator
{
    private ManagerValidator $managerValidator;
    private array $calbacks;
    private array $fields;
    private array $patterns;

    public function __construct()
    {
        $this->managerValidator = new ManagerValidator();
        $this->calbacks = [];
        $this->fields = ['name'=>null,'email'=>null,'device_id'=>null];
        $this->patterns = Validator::getPatterns();
        $this->buildValidation();
    }

    public function __set(string $name, $value)
    {
        if (array_key_exists($name, $this->fields)) {
            $this->fields[$name] = $value;
            $this->managerValidator->add($this->calbacks[$name]);
        } else {
            throw new \RuntimeException("Field not found");
        }
    }

    public function __get(string $name)
    {
        return $this->fields[$name];
    }

    /**
     * TODO After activating the field, _set will work
     */
    public function activateField(string $field, $value)
    {
        if (array_key_exists($field, $this->fields)) {
            $this->$field = $value;
        } else {
            throw new \RuntimeException("Field not found");
        }
    }

    /**
     * TODO This is done because of the stored property context in the callback function
     */
    public function reset(){
      foreach ($this->fields as $field){
          if (array_key_exists($field, $this->fields)) {
              $this->$field=null;
          }
      }
    }

    /**
     * All validation rules.
     */
    public function buildValidation()
    {

        // Name filter
        $buildName = new BuildFilter("name", "Name is not valid");
        $buildName->addWork(function () {
            if (filter_var(
                    $this->name,
                    FILTER_VALIDATE_REGEXP,
                    ["options" => ["regexp" => "/".$this->patterns['name']."/"]]
                ) === false) {
                return false;
            }
            return true;
        });
        $filteName= new FilterAnd();
        $filteName->addFilter($buildName);
        $this->calbacks['name']=$filteName;


        // Email filter
        $buildEmail = new BuildFilter("email", "Email is not valid");
        $buildEmail->addWork(function () {
            if (filter_var($this->email, FILTER_VALIDATE_EMAIL) === false) {
                return false;
            }
            return true;
        });
        $buildEmail->addWork(function () {
            if (filter_var(
                    $this->email,
                    FILTER_VALIDATE_REGEXP,
                    ["options" => ["regexp" => "/".$this->patterns['email']."/"]]
                ) === false) {
                return false;
            }
            return true;
        });

        $filterEmail = new FilterAnd();
        $filterEmail->addFilter($buildEmail);
        $this->calbacks['email']=$filterEmail;


        // Device Id filter
        $buildDeviceId = new BuildFilter("device_id", "Device id is not valid");
        $buildDeviceId->addWork(function () {
            if (filter_var(
                    $this->device_id,
                    FILTER_VALIDATE_REGEXP,
                    ["options" => ["regexp" => "/".$this->patterns['device_id']."/"]]
                ) === false) {
                return false;
            }
            return true;
        });

        $filterLogin = new FilterAnd();
        $filterLogin->addFilter($buildDeviceId);
        $this->calbacks['device_id']=$filterLogin;

    }

    public function validate():array
    {
        return $this->managerValidator->validate();
    }

    public function isValidate():bool
    {
        return $this->managerValidator->isValidate();
    }
    public static function getPatterns():array
    {
        return require FILE_PATTERNS_FIELD;
    }
}