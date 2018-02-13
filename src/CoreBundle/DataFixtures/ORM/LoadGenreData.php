<?php
/**
 * This file is part of CoreBundle\DataFixtures\ORM package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace CoreBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use CoreBundle\Entity\Instrument;

class LoadGenreData extends AbstractFixture
    implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $data = [
            ['name' => 'Guitar', 'photo' => 'http://www.vintageguitar.com/wp-content/uploads/FENDER_STRAT_01.png'],
            ['name' => 'Electric', 'photo' => 'https://www.fmicassets.com/Damroot/GuitarVertDesktopJpg/10001/0114001708_gtr_frt_001_rr.jpg'],
            ['name' => 'Bass', 'photo' => 'http://chownybass.com/wp-content/uploads/2016/07/2017-CHB2-Purple.png'],
            ['name' => 'Banjo', 'photo' => 'http://www.tanglewoodguitars.co.uk/wp-content/uploads/2015/07/TWB-18-M5-i-1000x1000.jpg']
        ];

        foreach ($data as $item) {
            $model = Instrument::fromArray($item);
            $manager->persist($model);
        }

        $manager->flush();
    }

    public function getOrder()
    {
        return 4;
    }
}