<?php

namespace Wrath\UserBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Wrath\UserBundle\Entity\User;
use Wrath\AccountingBundle\Entity\Transaction;

class LoadUserData extends AbstractFixture implements OrderedFixtureInterface {
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager) {
        $userAdmin = new User();
        $userAdmin->setUsername('admin');
        $userAdmin->setEmail('krolla+admin@gmail.com');
        $userAdmin->setEnabled(true);
        $userAdmin->setExpired(false);
        $userAdmin->setPlainPassword('admin');
        
        $userAdminPrimaryAccount = $userAdmin->getPrimaryAccount();
        $transaction = new Transaction();
        $transaction->setAmount(1000);
        $transaction->setDescription('Initial testing');
        $userAdminPrimaryAccount->addTransaction($transaction);
        
        $userNormal = new User();
        $userNormal->setUsername('normal');
        $userNormal->setEmail('krolla+normal@gmail.com');
        $userNormal->setEnabled(true);
        $userNormal->setExpired(false);
        $userNormal->setPlainPassword('normal');
        
        $manager->persist($userAdmin);
        $manager->persist($userNormal);
        $manager->flush();
        
        $this->addReference('user-admin', $userAdmin);
        $this->addReference('user-normal', $userNormal);
    }
    
    /**
     * {@inheritDoc}
     */
    public function getOrder() {
        return 1;
    }
}