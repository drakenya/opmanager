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
        $news_1 = new News();
        $news_1->setTitle('The first news post!');
        $news_1->setContent('This is a super dooper story. Fo sho.');
        $news_1->setUser($this->getReference('user-admin'));
        
        $news_2 = new News();
        $news_2->setTitle('Actual Content, Perchance?');
        $news_2->setUser($this->getReference('user-admin'));
        $news_2->setContent("= Testing\n* First\n* Second");
        
        $manager->persist($news_1);
        $manager->persist($news_2);
        $manager->flush();
    }
    
    /**
     * {@inheritDoc}
     */
    public function getOrder() {
        return 50;
    }
}