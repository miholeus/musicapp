<?php
/**
 * This file is part of ApiBundle\Controller package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ApiBundle\Controller;

use ApiBundle\Form\VoteType;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Component\HttpFoundation\Request;

class VoteController extends RestController
{
    /**
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
     * ### Success Response ###
     *      {
     *      }
     *
     * @ApiDoc(
     *  section="Votes",
     *  resource=true,
     *  description="Vote for selected genre",
     *  statusCodes={
     *         201="Vote created",
     *         400="Bad request"
     *     },
     *  headers={
     *      {
     *          "name"="X-AUTHORIZE-TOKEN",
     *          "description"="access key header",
     *          "required"=true
     *      }
     *    },
     *  input={
     *     "class"="\ApiBundle\Form\VoteType",
     *     "name"=""
     *     }
     * )
     *
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function postVotesAction(Request $request)
    {
        $form = $this->createForm(VoteType::class);
        $this->processForm($request, $form);

        if (!$form->isValid()) {
            throw $this->createFormValidationException($form);
        }

        $service = $this->get('api.vote_service');
        $service->addVote($form->getData());

        $view = $this->view(null, 201);
        return $this->handleView($view);
    }

    /**
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
     * ### Success Response ###
     *      {
     *      }
     *
     * @ApiDoc(
     *  section="Votes",
     *  resource=true,
     *  description="Revoke vote for selected genre",
     *  statusCodes={
     *         200="Vote revoked",
     *         400="Bad request"
     *     },
     *  headers={
     *      {
     *          "name"="X-AUTHORIZE-TOKEN",
     *          "description"="access key header",
     *          "required"=true
     *      }
     *    },
     *  input={
     *     "class"="\ApiBundle\Form\VoteType",
     *     "name"=""
     *     }
     * )
     *
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function deleteVotesAction(Request $request)
    {
        $form = $this->createForm(VoteType::class);
        $this->processForm($request, $form);

        if (!$form->isValid()) {
            throw $this->createFormValidationException($form);
        }

        $service = $this->get('api.vote_service');
        $service->revokeVote($form->getData());

        $view = $this->view(null);
        return $this->handleView($view);
    }
}