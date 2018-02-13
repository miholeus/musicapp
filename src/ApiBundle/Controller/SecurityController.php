<?php

namespace ApiBundle\Controller;

use ApiBundle\Service\Exception\AuthenticateException;
use FOS\RestBundle\Controller\Annotations\RequestParam;
use FOS\RestBundle\Request\ParamFetcher;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Component\HttpFoundation\Request;

class SecurityController extends RestController
{
    /**
     * ### Minimal Response (e.g. anonymous) ###
     *
     *     {
     *       "data": {
     *         "token": <token>
     *       }
     *     }
     *
     * ### Failed Response ###
     *
     *     {
     *       "success": false
     *       "exception": {
     *         "code": <code>,
     *         "message": <message>
     *       }
     *     }
     *
     *
     * @ApiDoc(
     *  section="Authentication",
     *  resource=true,
     *  description="Authenticate user",
     *  statusCodes={
     *         200="Success auth",
     *         401="Invalid credentials",
     *         403="Forbidden",
     *         404="User not found",
     *         400="Bad request"
     *     },
     *  responseMap={
     *         401={
     *           "class"="ApiBundle\Service\Exception\AuthenticateException",
     *           "parsers"={"Nelmio\ApiDocBundle\Parser\JmsMetadataParser"}
     *         }
     *     },
     *  headers={
     *      {
     *          "name"="X-AUTHORIZE-KEY",
     *          "description"="access key header",
     *          "required"=true
     *      }
     *    }
     * )
     *
     *
     * @RequestParam(name="login", description="Login")
     * @RequestParam(name="password", description="Password")
     *
     * @param ParamFetcher $paramFetcher
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \CoreBundle\Service\Token\ClientException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function postLoginAction(ParamFetcher $paramFetcher)
    {
        $service = $this->get('api.auth_service');
        $keyProvider = $this->get('api.key_provider');

        $login = $paramFetcher->get('login');
        $password = $paramFetcher->get('password');

        $user = $service->authenticate($login, $password);
        $this->get('user.service')->updateLastLoginTime($user);
        $token = $keyProvider->generateToken($user);

        $data = [
            'token' => $token,
        ];

        $view = $this->view($data);

        return $this->handleView($view);
    }

    /**
     * @ApiDoc(
     *  section="Authentication",
     *  resource=true,
     *  description="Logout user",
     *  statusCodes={
     *         201="Success",
     *         403="Forbidden",
     *         400="Bad request"
     *     },
     *  responseMap={
     *         401={
     *           "class"="ApiBundle\Service\Exception\AuthenticateException",
     *           "parsers"={"Nelmio\ApiDocBundle\Parser\JmsMetadataParser"}
     *         }
     *     },
     *  headers={
     *      {
     *          "name"="X-AUTHORIZE-TOKEN",
     *          "description"="access token header",
     *          "required"=true
     *      }
     *    }
     * )
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \CoreBundle\Service\Token\ClientException
     */
    public function postLogoutAction(Request $request)
    {
        $keyProvider = $this->get('api.key_provider');

        $keyProvider->deleteUserToken($request->headers->get('X-AUTHORIZE-TOKEN'));

        $view = $this->view(null, 204);
        return $this->handleView($view);
    }
}
