<?php

namespace App\Repository;

use App\Entity\Annonce;
use App\Model\SearchData;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;

/**
 * @extends ServiceEntityRepository<Annonce>
 *
 * @method Annonce|null find($id, $lockMode = null, $lockVersion = null)
 * @method Annonce|null findOneBy(array $criteria, array $orderBy = null)
 * @method Annonce[]    findAll()
 * @method Annonce[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AnnonceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Annonce::class);
    }

    public function save(Annonce $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Annonce $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @return Annonce[] Returns an array of Annonce objects
     */
    public function search(Request $request, int $limit = 10): array
    {
        $queryBuilder = $this->createQueryBuilder('h')
            ->orderBy('h.dateAnnonce', 'ASC')
            ->setMaxResults($limit)
        ;

        if ($airport = $request->query->get('airport')) {
            $queryBuilder
                ->andWhere('h.airportDepartAller = :airportDepartAller')
                ->setParameter('airportDepartAller', $airport)
            ;
        }

        return $queryBuilder->getQuery()->getResult();
    }

}
