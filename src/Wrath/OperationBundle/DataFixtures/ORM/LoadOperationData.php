<?php

namespace Wrath\OperationBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Wrath\OperationBundle\Entity\Operation;
use Wrath\ItemBundle\Entity\Manifest;
use Wrath\ItemBundle\Entity\LineItem;
use Wrath\ItemBundle\Entity\Item;

class LoadOperationData extends AbstractFixture implements OrderedFixtureInterface {
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager) {
        $operationAdmin = new Operation();
        $operationAdmin->setCreator($this->getReference('user-admin'));
        $operationAdmin->setName('Admin Operation');
        
        $manifest_1 = new Manifest();
        $manifest_1->setUser($this->getReference('user-admin'));
        $item_1 = new Item();
        $item_1->setName("Operation Item 1");
        $item_1->setPrice(30);
        $line_item_1 = new LineItem();
        $line_item_1->setQuantity(5);
        $line_item_1->setItem($item_1);
        $line_item_1->setCurrentValue($line_item_1->getItem()->getPrice());
        
        $item_2 = new Item();
        $item_2->setName("Operation Item 2");
        $item_2->setPrice(25.7);
        $line_item_2 = new LineItem();
        $line_item_2->setQuantity(10);
        $line_item_2->setItem($item_2);
        $line_item_2->setCurrentValue($line_item_2->getItem()->getPrice());
        
        $manifest_1->addLineItem($line_item_1);
        $manifest_1->addLineItem($line_item_2);
        $operationAdmin->addManifest($manifest_1);
        
        $operationNormalUser = new Operation();
        $operationNormalUser->setCreator($this->getReference('user-normal'));
        $operationNormalUser->setName('Normal User Operation');
        
        $manifest_2 = new Manifest();
        $manifest_2->setUser($this->getReference('user-admin'));
        $item_3 = new Item();
        $item_3->setName("Operation Item 3");
        $item_3->setPrice(30);
        $line_item_3 = new LineItem();
        $line_item_3->setQuantity(5);
        $line_item_3->setItem($item_3);
        $line_item_3->setCurrentValue($line_item_3->getItem()->getPrice());
        
        $item_4 = new Item();
        $item_4->setName("Operation Item 4");
        $item_4->setPrice(25.7);
        $line_item_4 = new LineItem();
        $line_item_4->setQuantity(10);
        $line_item_4->setItem($item_4);
        $line_item_4->setCurrentValue($line_item_4->getItem()->getPrice());
        
        $manifest_2->addLineItem($line_item_3);
        $manifest_2->addLineItem($line_item_4);
        $operationNormalUser->addManifest($manifest_2);
        
        $manager->persist($operationAdmin);
        $manager->persist($operationNormalUser);
        $manager->flush();
        
        $this->addReference('operation-admin', $operationAdmin);
        $this->addReference('operation-normal', $operationNormalUser);
    }
    
    /**
     * {@inheritDoc}
     */
    public function getOrder() {
        return 10;
    }
}