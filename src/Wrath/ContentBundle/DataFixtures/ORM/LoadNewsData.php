<?php

namespace Wrath\ContentBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Wrath\ContentBundle\Entity\News;

class LoadNewsData extends AbstractFixture implements OrderedFixtureInterface {
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i < 25; $i++)
        {
            $news = new News();
            $news->setTitle('The first news post!: ' . $i);
            $news->setContent('This is a super dooper story. Fo sho. ' . $i);
            $news->setUser($this->getReference('user-admin'));

            $manager->persist($news);
            $manager->flush();
        }
    }
    
    /**
     * {@inheritDoc}
     */
    public function getOrder() {
        return 50;
    }
}