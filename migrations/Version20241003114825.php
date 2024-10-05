<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241003114825 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE import_membre_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE import_membre (id INT NOT NULL, anarana VARCHAR(255) NOT NULL, fanampiny VARCHAR(255) NOT NULL, daty_naterahana VARCHAR(255) NOT NULL, lahy_na_vavy VARCHAR(255) NOT NULL, adiresy_eto_antananarivo VARCHAR(255) NOT NULL, trangobe VARCHAR(255) NOT NULL, fiaviana_antanana VARCHAR(255) NOT NULL, laharana_finday VARCHAR(255) NOT NULL, mailaka VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE import_membre_id_seq CASCADE');
        $this->addSql('DROP TABLE import_membre');
    }
}
