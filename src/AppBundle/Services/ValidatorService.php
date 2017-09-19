<?php
/**
 * Created by PhpStorm.
 * User: Adrián
 * Date: 15/09/2017
 * Time: 20:57
 */

namespace AppBundle\Services;

use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\JsonResponse;

class ValidatorService implements ValidatorInterface
{
    private $validationError = 1;
    private $httpCode = JsonResponse::HTTP_INTERNAL_SERVER_ERROR;
    private $errorMessage;
    private $errorType;
    private $errorDescription;

    public function validateMandatoryFields($param){
        if(empty($param) || is_null($param)){
            $this->setErrorMessage("The value can't be null");
            $this->processException($this->errorMessage, $this->validationError, null);
        }
        else if (is_array($param) || is_object($param)){
            $this->setErrorMessage("Invalid field");
            $this->processException($this->errorMessage, $this->validationError, null);
        }
        return $param;
    }


    //TODO: Pasar y comprobar errores
    public function processException($errorMsg, $errorType, $httpCode) {
        $this->setHttpCode(!is_null($httpCode) ? $httpCode : $this->httpCode);
        $this->setErrorDescription($errorMsg);
        $this->setErrorType(!is_null($errorType) ? $errorType : $this->validationError);
        throw new Exception($errorMsg);
    }

    /**
     * @return int
     */
    public function getValidationError()
    {
        return $this->validationError;
    }

    /**
     * @param int $validationError
     */
    public function setValidationError($validationError)
    {
        $this->validationError = $validationError;
    }

    /**
     * @return int
     */
    public function getHttpCode()
    {
        return $this->httpCode;
    }

    /**
     * @param int $httpCode
     */
    public function setHttpCode($httpCode)
    {
        $this->httpCode = $httpCode;
    }

    /**
     * @return mixed
     */
    public function getErrorMessage()
    {
        return $this->errorMessage;
    }

    /**
     * @param mixed $errorMessage
     */
    public function setErrorMessage($errorMessage)
    {
        $this->errorMessage = $errorMessage;
    }

    /**
     * @return mixed
     */
    public function getErrorType()
    {
        return $this->errorType;
    }

    /**
     * @param mixed $errorType
     */
    public function setErrorType($errorType)
    {
        $this->errorType = $errorType;
    }

    /**
     * @return mixed
     */
    public function getErrorDescription()
    {
        return $this->errorDescription;
    }

    /**
     * @param mixed $errorDescription
     */
    public function setErrorDescription($errorDescription)
    {
        $this->errorDescription = $errorDescription;
    }

}