<?php
declare(strict_types=1);

namespace App\Validate\Filters;

use \ErrorException;
use App\AbstractValidator;
use App\ReturnValue;
use App\IBuildFilter;

class FilterNot extends AbstractValidator
{
    private array $filters = [];
    private bool $isValid = false;
    private ReturnValue $resturnValue;

    public function __construct()
    {
        $this->isValid = false;
        $this->filters = [];
    }

    public function addFilter(IBuildFilter $buildFilter)
    {
        foreach ($buildFilter->getCallback() as $f) {
            array_push($this->filters, [$buildFilter->getName()=>$f]);
        }
    }

    public function validate():array
    {
        try {
            $this->isValid = true;
            if (empty($this->filters)) {
                return [];
            }
            $resultErrors = [];
            $resultSuccess = [];
            foreach ($this->filters as $data) {
                $key = array_key_first($data);
                $this->resturnValue = $data[$key]($this);

                if ($this->resturnValue->isValidate()==false) {
                    array_push($resultErrors, [$key=>$this->resturnValue->getMessage()]);
                    $this->invalidate();
                    $this->isValid = false;
                } else {
                    array_push($resultSuccess, [$key=>$this->resturnValue->getMessage()]);
                }
            }

            return $this->isValid==true?$resultSuccess:$resultErrors;
        } catch (Throwable $e) {
            $this->invalidate();
            $this->isValid = false;
            return [];
        }
    }

    public function isValidate():bool
    {
        return $this->isValid;
    }
}