<?php

namespace AppBundle\Repository;


use Doctrine\ORM\EntityRepository;

class ItemRepository extends EntityRepository
{
    public function getItemsByName(string $name)
    {
        $qb = $this->createQueryBuilder('i');
        $a = $qb->select('i')
            ->where('i.name LIKE :name')
            ->setParameter('name', substr($name,0, 1) . '%')
            ->setMaxResults(1)
            ->getQuery();

        return $a->gettSQL();
    }
}