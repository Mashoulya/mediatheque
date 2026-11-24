<?php

namespace App\Repository;

use App\Entity\Emprunt;
use App\Entity\Oeuvre;
use App\Entity\Utilisateur;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Emprunt>
 */
class EmpruntRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Emprunt::class);
    }

    public function rechercheParUtilisateurEtOeuvre(Utilisateur $utilisateur, Oeuvre $oeuvre): ?Emprunt
    {
        return $this->createQueryBuilder('e')
            ->join('e.exemplaire', 'ex')
            ->andWhere('e.utilisateur = :utilisateur')
            ->andWhere('ex.oeuvre = :oeuvre')
            ->setParameter('utilisateur', $utilisateur)
            ->setParameter('oeuvre', $oeuvre)  
            ->getQuery()
            ->getOneOrNullResult();
    }
//    /**
//     * @return Emprunt[] Returns an array of Emprunt objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('e.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Emprunt
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
