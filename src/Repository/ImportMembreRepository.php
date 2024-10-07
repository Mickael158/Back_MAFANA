<?php

namespace App\Repository;

use App\Entity\ImportMembre;
use DateTime;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Exception;
use League\Csv\Reader;

/**
 * @extends ServiceEntityRepository<ImportMembre>
 */
class ImportMembreRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ImportMembre::class);
    }
    public function getDonnee(string $file): ?array
    {
        try {
            $csv = Reader::createFromPath($file, 'r');
            $csv->setHeaderOffset(0); 

            $records = $csv->getRecords();

            $valiny = [];
            foreach ($records as $record) {
                $valiny[] = $record; 
            }

            return $valiny;
        } catch (Exception $e) {
            echo $e->getMessage();
            return null;
        }
    }
    public function findAllFromFile(string $file): array
    {
        $resultatImports = [];

        try {
            $csv = Reader::createFromPath($file, 'r');
            $csv->setHeaderOffset(0); 

            $records = $csv->getRecords();

            foreach ($records as $record) {
                $resultatImport = new ImportMembre();
                
                $resultatImport->setAnarana( $record['Anarana']);
                $resultatImport->setFanampiny($record['Fanampiny']);
                // Conversion de la date
                $dtn = DateTime::createFromFormat('d/m/Y', $record['Datenahaterahana']);
                $formattedDate = $dtn->format('Y-m-d');
                $resultatImport->setDatyNaterahana($formattedDate);
                $resultatImport->setLahyNaVavy($record['LahynaVavy']);
                $resultatImport->setAdiresyEtoAntananarivo($record['AdresyetoAntananarivo']);
                $resultatImport->setTrangobe($record['Tragnobe']);
                $resultatImport->setFiavianaAntanana($record['Fiavianaantanana']);
                $resultatImport->setLaharanaFinday($record['Laharanafinday']);
                $resultatImport->setMailaka($record['mailaka']);

                $resultatImports[] = $resultatImport;
            }
        } catch (Exception $e) {
            echo $e->getMessage();
        }

        return $resultatImports;
    }

    public function getImportDistinctTrangobe()
    {
        $sql = 'SELECT DISTINCT ON (trangobe) * FROM import_membre';

        $conn = $this->getEntityManager()->getConnection();
        
        $stmt = $conn->prepare($sql);
        $resultSet = $stmt->executeQuery();
        
        return $resultSet->fetchAllAssociative();
    }
    public function getImportDistinctfiaviana_antanana()
    {
        $sql = 'SELECT DISTINCT ON (fiaviana_antanana) * FROM import_membre';

        $conn = $this->getEntityManager()->getConnection();
        
        $stmt = $conn->prepare($sql);
        $resultSet = $stmt->executeQuery();
        
        return $resultSet->fetchAllAssociative();
    }
    public function getImportDistinctPeronne()
    {
        $sql = 'select DISTINCT ON (anarana , fanampiny , daty_naterahana , lahy_na_vavy , adiresy_eto_antananarivo , trangobe , fiaviana_antanana , laharana_finday , mailaka) * from import_membre;';

        $conn = $this->getEntityManager()->getConnection();
        
        $stmt = $conn->prepare($sql);
        $resultSet = $stmt->executeQuery();
        
        return $resultSet->fetchAllAssociative();
    }

    //    /**
    //     * @return ImportMembre[] Returns an array of ImportMembre objects
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

    //    public function findOneBySomeField($value): ?ImportMembre
    //    {
    //        return $this->createQueryBuilder('e')
    //            ->andWhere('e.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
