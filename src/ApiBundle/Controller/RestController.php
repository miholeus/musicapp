<?php

namespace ApiBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Request\ParamFetcher;
use Symfony\Component\Form\FormInterface;
use ApiBundle\Service\Exception\ParameterValidateException;
use ApiBundle\Service\Transformer\ScopeManager;
use ApiBundle\Service\Transformer\TransformerAbstract;

class RestController extends FOSRestController
{

    /**
     * Array normalizer
     *
     * @return \FOS\RestBundle\Normalizer\CamelKeysNormalizer
     */
    protected function getArrayNormalizer()
    {
        return $this->get('fos_rest.normalizer.camel_keys');
    }

    /**
     * Get manager for handling transformations
     *
     * @param TransformerAbstract $transformer
     * @param array $includes
     * @return ScopeManager
     */
    protected function getManager(TransformerAbstract $transformer, $includes = [])
    {
        $manager = $this->get('api.data.transformer.manager');

        $manager = $manager->getManager();
        if ($includes) {
            $manager->parseIncludes($includes);
        } else if ($transformer->getAvailableIncludes()) {
            $manager->parseIncludes($transformer->getAvailableIncludes());
        }
        return $manager;
    }

    /**
     * Apply transformation to resource
     *
     * @param $item
     * @param TransformerAbstract $transformer
     * @param array $includes
     * @return array
     */
    protected function getResourceItem($item, TransformerAbstract $transformer, $includes = [])
    {
        $resource = new \League\Fractal\Resource\Item($item, $transformer);
        $manager = $this->getManager($transformer, $includes);
        $data = $manager->createData($resource)->toArray();
        return $data;
    }

    /**
     * Apply transformation to collection
     *
     * @param $collection
     * @param TransformerAbstract $transformer
     * @param array $includes
     * @return array
     */
    protected function getResourceCollection($collection, TransformerAbstract $transformer, $includes = [])
    {
        $resource = new \League\Fractal\Resource\Collection($collection, $transformer);
        $manager = $this->getManager($transformer, $includes);

        $data = $manager->createData($resource)->toArray();
        return $data;
    }

    /**
     * Process and submit form
     *
     * @param Request $request
     * @param FormInterface $form
     * @param bool $normalize if set to true then normalized will be used for keys
     */
    protected function processForm(Request $request, FormInterface $form, $normalize = true)
    {
        $normalizer = $this->getArrayNormalizer();
        if ($request->getMethod() == 'GET') {// GET
            $content = $request->query->all();
        } else {// POST, PUT, PATCH
            $content = $request->request->all();
        }
        $data = [];
        foreach ($content as $parameterKey => $parameterValue) {
            if ($normalize) {
                $normalizedArrayKeys = $normalizer->normalize([$parameterKey => 0]);
                $dataKey = current(array_keys($normalizedArrayKeys));
            } else {
                $dataKey = $parameterKey;
            }
            $data[$dataKey] = $request->get($parameterKey);
        }
        $clearMissing = $request->getMethod() != 'PATCH';
        $form->submit($data, $clearMissing);
    }

    /**
     * Returns form exception
     *
     * @param FormInterface $formInterface
     * @return \ApiBundle\Service\Exception\FormValidateException
     */
    protected function createFormValidationException(FormInterface $formInterface)
    {
        return new \ApiBundle\Service\Exception\FormValidateException($formInterface);
    }

    /**
     * Add new error to form element
     *
     * @param FormInterface $formInterface
     * @param $element
     * @param $message
     */
    protected function addFormError(FormInterface $formInterface, $element, $message)
    {
        $formInterface->get($element)->addError(new FormError($message));
    }

    /**
     * Get all params
     *
     * @param ParamFetcher $paramFetcher
     * @param string $entityName
     *
     * @return array
     */
    protected function getParams(ParamFetcher $paramFetcher, $entityName)
    {
        $resultArray = [];
        foreach ($paramFetcher->getParams() as $key => $value) {
            $resultArray[$key] = $this->getParam($paramFetcher, $key, $entityName);
        }
        return $resultArray;
    }

    /**
     * Validate fields
     *
     * @param ParamFetcher $paramFetcher
     * @param string $paramName
     * @param string $entityName
     *
     * @return string
     *
     * @throws ParameterValidateException
     */
    protected function getParam(ParamFetcher $paramFetcher, $paramName, $entityName)
    {
        $allSettings = $paramFetcher->getParams();
        $paramSettings = $allSettings[$paramName];
        $parameter = $paramFetcher->get($paramName, false);

        $message = [];
        if (!is_array($parameter)) {
            if ($paramSettings->allowBlank) {
                if (mb_strlen($parameter, "utf-8") !== 0) {
                    if ($paramSettings->requirements) {
                        $message = $this->checkParam($parameter, $paramSettings->requirements);
                    }
                }
            } else {
                if ($paramSettings->requirements) {
                    $message = $this->checkParam($parameter, $paramSettings->requirements);
                } else {
                    if (mb_strlen($parameter, "utf-8") === 0) {
                        $message = "This value should not be blank.";
                    }
                }
            }
        } else {
            if ($paramSettings->allowBlank) {
                foreach ($parameter as $param) {
                    if (mb_strlen($param, "utf-8") !== 0) {
                        if ($paramSettings->requirements) {
                            $result = $this->checkParam($param, $paramSettings->requirements);
                            if ($result) {
                                $message[] = $result;
                            }
                        }
                    }
                }
            } else {
                if (empty($parameter)) {
                    $message[] = "This value should not be blank.";
                } else {
                    if ($paramSettings->requirements) {
                        foreach ($parameter as $param) {
                            $result = $this->checkParam($param, $paramSettings->requirements);
                            if ($result) {
                                $message[] = $result;
                            }
                        }
                    }
                }
            }
        }
        if (!empty($message)) {
            if (is_array($message)) {
                $message = implode(', ', $message);
            }
            throw new ParameterValidateException($entityName, $paramName, $message);
        }
        return $parameter;
    }

    /**
     * Check params by mask
     *
     * @param string $parameterValue
     * @param string $pattern
     *
     * @return string
     */
    private function checkParam($parameterValue, $pattern)
    {
        $message = null;
        if (!preg_match('/' . $pattern . '$/', $parameterValue)) {
            $message = "Query parameter value \u0027{$parameterValue}\u0027, does not match requirements \u0027{$pattern}\u0027";
        }
        return $message;
    }

    /**
     * Get form errors
     *
     * @param FormInterface $form
     * @return array
     */
    protected function getErrorsFromForm(FormInterface $form)
    {
        $errors = [];
        foreach ($form->getErrors() as $error) {
            $errors[] = $error->getMessage();
        }
        foreach ($form->all() as $childForm) {
            if ($childForm instanceof FormInterface) {
                if ($childErrors = $this->getErrorsFromForm($childForm)) {
                    $errors[$childForm->getName()] = $childErrors;
                }
            }
        }
        return $errors;
    }

    /**
     * Creates a view.
     *
     * Convenience method to allow for a fluent interface.
     *
     * @param mixed $data
     * @param int   $statusCode
     * @param array $headers
     *
     * @return View
     */
    protected function view($data = null, $statusCode = 200, array $headers = [])
    {
        return View::create($data, $statusCode, $headers);
    }
}
