<?php

namespace Oosaulenko\MediaBundle\Repository;

use App\Entity\LoolyMedia\Media;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

class MediaRepository extends ServiceEntityRepository implements MediaRepositoryInterface
{
    public function __construct(
        ManagerRegistry $registry,
        protected EntityManagerInterface $em
    )
    {
        parent::__construct($registry, Media::class);
    }

    public function add(Media $entity, bool $flush = false): void
    {
        $this->em->persist($entity);

        if ($flush) $this->save();
    }

    public function update(Media $entity, bool $flush = false): void
    {
        if ($entity->getId() === null) {
            $this->add($entity, $flush);
        } else {
            if($flush) $this->save();
        }
    }

    public function remove(Media $entity, bool $flush = false): void
    {
        $this->em->remove($entity);

        if ($flush) $this->save();
    }

    public function save(): void
    {
        $this->em->flush();
    }

    public function list(int $limit, int $offset = 0): ?array
    {
        return $this->createQueryBuilder('m')
            ->setMaxResults($limit)
            ->setFirstResult($offset)
            ->orderBy('m.id', 'DESC')
            ->getQuery()
            ->getResult();
    }

    public function countList(): int
    {
        return $this->createQueryBuilder('m')
            ->select('COUNT(m.id)')
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function findOneById(int $id): ?Media
    {
        return self::findOneBy(['id' => $id]);
    }
}