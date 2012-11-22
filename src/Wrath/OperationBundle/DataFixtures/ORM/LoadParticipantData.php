<?php

namespace Wrath\OperationBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Wrath\OperationBundle\Entity\Participant;

class LoadParticipantData extends AbstractFixture implements OrderedFixtureInterface {
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager) {
        $participantUserOne = new Participant();
        $participantUserOne->setUser($this->getReference('user-normal'));
        $participantUserOne->setOperation($this->getReference('operation-normal'));
        $participantUserOne->setShipClass('Normal One Class');
        $participantUserOne->setShipWeight(1.3);

        $participantUserOne->setStartAt($participantUserOne->getJoinAt());
        
        $leave_at = new \DateTime('now');
        $leave_at->add(new \DateInterval('PT10M'));
        $participantUserOne->setLeaveAt($leave_at);
        $participantUserOne->calculateWeights();
        
        $participantUserTwo = new Participant();
        $participantUserTwo->setUser($this->getReference('user-admin'));
        $participantUserTwo->setOperation($this->getReference('operation-normal'));
        $participantUserTwo->setShipClass('Normal One Class');
        $participantUserTwo->setShipWeight(1.1);

        $participantUserTwo->setStartAt($participantUserTwo->getJoinAt());
        
        $leave_at = new \DateTime('now');
        $leave_at->add(new \DateInterval('PT5M'));
        $participantUserTwo->setLeaveAt($leave_at);
        $participantUserTwo->calculateWeights();
        
        $manager->persist($participantUserOne);
        $manager->persist($participantUserTwo);
        $manager->flush();
        
        $operation = $this->getReference('operation-normal');
        $operation->setTotalTimeWeightedClass();
        $manager->persist($operation);
        $manager->flush();
    }
    
    /**
     * {@inheritDoc}
     */
    public function getOrder() {
        return 11;
    }
}