<?php
/**
 * This file is part of ApiBundle\Service package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ApiBundle\Service;

use CoreBundle\Entity\Instrument;
use CoreBundle\Repository\InstrumentRepository;

class GenreService
{
    /**
     * @var InstrumentRepository
     */
    private $repository;

    public function __construct(InstrumentRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Fetches all genres
     *
     * @return Instrument[]
     */
    public function getGenres()
    {
        return $this->getRepository()->findAll();
    }
    /**
     * @return InstrumentRepository
     */
    public function getRepository(): InstrumentRepository
    {
        return $this->repository;
    }
}