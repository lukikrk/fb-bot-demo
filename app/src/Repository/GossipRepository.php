<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Gossip;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Gossip[] findAll()
 */
class GossipRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Gossip::class);
    }
}
