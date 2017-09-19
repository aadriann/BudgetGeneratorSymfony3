<?php
/**
 * Created by PhpStorm.
 * User: Adrián
 * Date: 17/09/2017
 * Time: 18:08
 */

namespace AppBundle\Services;


interface ValidatorInterface
{
    public function validateMandatoryFields($param);
    public function processException($errorMsg, $errorType, $httpCode);
}