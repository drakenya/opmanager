<?php

namespace Wrath\ContentBundle\Entity;

use Doctrine\ORM\EntityRepository;

class NewsRepository extends EntityRepository
{
    public function findLatestOrderedByDateDesc()
    {
        return $this->getEntityManager()
                ->createQuery('SELECT n FROM WrathContentBundle:News n ORDER BY n.id DESC')
                ->setMaxResults(5)
                ->getResult();
    }
}
