<?php
/**
 * This file is part of ApiBundle\Controller package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace ApiBundle\Controller;

use Nelmio\ApiDocBundle\Annotation\ApiDoc;

class GenreController extends RestController
{
    /**
     *
     * ### Failed Response ###
     *      {
     *          {
     *              "success": false,
     *              "exception": {
     *                  "code": 400,
     *                  "message": "Bad Request"
     *              },
     *              "errors": null
     *      }
     *
     * ### Success Response ###
     *      {
     *          "data":{
     *              "id":<integer>,
     *              "name":<string>,
     *              "photo":<string>
     *          },
     *          "time":<time request>
     *      }
     *
     * @ApiDoc(
     *  section="Genres",
     *  resource=true,
     *  description="List of instruments",
     *  statusCodes={
     *         200="OK",
     *         400="Bad request"
     *     },
     *  headers={
     *      {
     *          "name"="X-AUTHORIZE-TOKEN",
     *          "description"="access key header",
     *          "required"=true
     *      }
     *    },
     *  output="\ApiBundle\Service\Transformer\Genre\InstrumentTransformer"
     * )
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getGenresActions()
    {
        $service = $this->get('api.genre_service');

        $transformer = $this->get('api.data.transformer.instrument_transformer');

        $items = $service->getGenres();

        $data = $this->getResourceCollection($items, $transformer);

        $view = $this->view($data);
        return $this->handleView($view);
    }
}