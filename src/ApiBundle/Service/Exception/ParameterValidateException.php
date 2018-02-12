<?php
/**
 * This file is part of ApiBundle\Service\Exception package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ApiBundle\Service\Exception;

use Symfony\Component\HttpKernel\Exception\HttpException;

/**
 * Errors while form validation parameters
 */
class ParameterValidateException extends HttpException
{

    public function __construct($entityName, $parameterName, $message)
    {
        $errors[$entityName]['errors']=null;
        $errors[$entityName]['children'][$parameterName]['errors'][] = $message;
        $errors[$entityName]['children'][$parameterName]['children'][] = null;
        parent::__construct(400, 'Validation Failed', null, $errors, 400);
    }
}
