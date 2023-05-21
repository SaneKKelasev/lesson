<?php

namespace App\Repository;

use App\Entity\Article;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Article>
 *
 * @method Article|null find($id, $lockMode = null, $lockVersion = null)
 * @method Article|null findOneBy(array $criteria, array $orderBy = null)
 * @method Article[]    findAll()
 * @method Article[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArticleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Article::class);
    }

    public function save(Article $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Article $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @return Article[] Returns an array of Article objects
     */
    public function findByPublishBySort(): array
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.publishedAt is not null')
            ->orderBy('a.publishedAt', 'DESC')
            ->leftJoin('a.tags', 't')
            ->addSelect('t')
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * @param int $productId
     * @return Article|null
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function findOneByIdJoinedToComment(int $productId): ?Article
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT a, c
            FROM App\Entity\Article a
            INNER JOIN a.comments c
            WHERE a.id = :id'
        )->setParameter('id', $productId);

        return $query->getOneOrNullResult();
    }

    public function findAllWithSearchQuery(?string $search)
    {
        $qb = $this->createQueryBuilder('a');

        if ($search) {
            $qb
                ->andWhere('a.title LIKE :search OR a.description LIKE :search OR u.firstName LIKE :search')
                ->setParameter('search', "%$search%");
        }

        return $qb
            ->innerJoin('a.author', 'u')
            ->addSelect('u')
            ->orderBy('a.createdAt', 'DESC');
    }

    public function findAllPublishedLastWeek()
    {
        return $this
            ->createQueryBuilder('a')
            ->andWhere('a.publishedAt IS NOT NULL')
            ->orderBy('a.publishedAt', 'DESC')
            ->andWhere('a.publishedAt >= :week_ago')
            ->setParameter('week_ago', new \DateTime('-7 week'))
            ->getQuery()
            ->getResult()
        ;
    }
}
