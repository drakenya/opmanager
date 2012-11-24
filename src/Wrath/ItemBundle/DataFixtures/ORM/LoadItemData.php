<?php

namespace Wrath\ItemBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Wrath\ItemBundle\Entity\Item;

class LoadItemData extends AbstractFixture implements OrderedFixtureInterface {
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager) {
        for($i = 0; $i <= 10; $i++) {
            $item = new Item();
            $item->setName("Item: $i");
            $item->setPrice($i * 20 / 10);
            
            $manager->persist($item);
        }
        $manager->flush();
    }
    
    /**
     * {@inheritDoc}
     */
    public function getOrder() {
        return 20;
    }
}