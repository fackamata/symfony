<?php

namespace App\Repository;

use App\Entity\Film;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Film|null find($id, $lockMode = null, $lockVersion = null)
 * @method Film|null findOneBy(array $criteria, array $orderBy = null)
 * @method Film[]    findAll()
 * @method Film[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FilmRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Film::class);
    }

    public function search(array $params)
    {
        $qB = $this->createQueryBuilder('f'); /* correspond a select * from film par defaut sinon ->select */

        if (!empty($params['strSearch'])){
            $qB->andwhere('f.titre LIKE :strSearch OR  f.synopsis LIKE :strSearch') /* :strSearch = stringEscape pour éviter les injections sql au lieu de %search% */
                ->setParameter('strSearch', '%'.$params['strSearch'].'%');
        }

        if (!empty($params['acteur'])){
            $qB->join('f.acteurs', 'a') //'f.acteur', alias: 'a'
                ->andwhere('a.id = :acteurId') // acteurId = c'est nous qui le nommons
                ->setParameter('acteurId', $params['acteur']);
        }
        if (!empty($params['dateDebut'])){
            $qB->andwhere('f.year >= :dateDebut') 
                ->setParameter('dateDebut', $params['dateDebut']);
        }
        if (!empty($params['dateFin'])){
            $qB->andwhere('f.year <= :dateFin') 
                ->setParameter('dateFin', $params['dateFin']);
        }

        // dd($qB->getQuery()->getResult());
        return $qB->getQuery()->getResult();
        /* pour créer ses propre requete, un constructeur de requete*/
        // return $this->createQueryBuilder('f') /* correspond a select * from film par defaut sinon ->select */
        //     ->where('f.titre LIKE :strSearch OR  f.synopsis LIKE :strSearch') /* :strSearch = stringEscape pour éviter les injections sql au lieu de %search% */
        //     ->setParameters([
        //             'strSearch' => '%'.$params['strSearch'].'%',
        //     ])
        //     ->getQuery() /* génères la requete sql */
        //     ->getResult() ; /* renvoie le résultat */
    }

    // /**
    //  * @return Film[] Returns an array of Film objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('f.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Film
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
