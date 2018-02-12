<?php
/**
 * This file is part of ApiBundle\Service\Exception package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ApiBundle\Service\Exception;

use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpKernel\Exception\HttpException;
use ApiBundle\Service\Normalizer\UnderscoreNormalizer;
use Symfony\Component\Form\FormError;

/**
 * Validation form error
 */
class FormValidateException extends HttpException
{

    public function __construct(FormInterface $form)
    {
        $errors = $this->getErrors($form);
        parent::__construct(400, 'Validation Failed', null, $errors, 400);
    }

    /**
     * Get errors
     *
     * @param FormInterface $form
     * @return array
     */
    private function getErrors(FormInterface $form)
    {
        $errors = $this->processErrors($form);
        $normalizer = $this->getArrayNormalizer();
        $errors = $normalizer->normalize($errors);
        return $errors;
    }

    /**
     * Process form submission
     *
     * @param FormInterface $form
     * @return mixed
     */
    private function processErrors(FormInterface $form)
    {
        $errors = [];
        $this->processErrorsRecursive($form, $errors);
        $resultArray[$form->getName()] = $errors;
        return $resultArray;
    }

    /**
     * Recursive form processing
     *
     * @param FormInterface $form
     * @param $errors
     * @return void
     */
    private function processErrorsRecursive(FormInterface $form, &$errors)
    {
        $formErrorIterator = $form->getErrors(true, false);
        foreach ($formErrorIterator as $errorInstance) {
            if ($errorInstance instanceof FormError) {
                $errors['errors'][] = $errorInstance->getMessage();
            } else {
                $childForm = $errorInstance->getForm();
                $this->processErrorsRecursive($childForm, $errors['children'][$childForm->getName()]);
            }
        }
    }

    /**
     * UnderscoreNormalizer
     * @return UnderscoreNormalizer
     */
    protected function getArrayNormalizer()
    {
        return new UnderscoreNormalizer();
    }
}
