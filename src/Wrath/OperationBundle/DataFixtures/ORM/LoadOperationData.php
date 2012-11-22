<?php

namespace Wrath\OperationBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Wrath\OperationBundle\Entity\Operation;

class LoadOperationData extends AbstractFixture implements OrderedFixtureInterface {
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager) {
        $operationAdmin = new Operation();
        $operationAdmin->setCreator($this->getReference('user-admin'));
        $operationAdmin->setName('Admin Operation');
        $operationAdmin->setTotalValue(1000);
        
        $operationNormalUser = new Operation();
        $operationNormalUser->setCreator($this->getReference('user-normal'));
        $operationNormalUser->setName('Normal User Operation');
        $operationNormalUser->setTotalValue(5000000);
        
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