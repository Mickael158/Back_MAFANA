<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241014114545 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE qui_somme_nous_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE qui_somme_nous (id INT NOT NULL, personne_id_id INT NOT NULL, profession_id_id INT NOT NULL, image VARCHAR(255) NOT NULL, date_debut_mondat DATE NOT NULL, date_fin_mondat DATE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_81DA14526BA58F3E ON qui_somme_nous (personne_id_id)');
        $this->addSql('CREATE INDEX IDX_81DA1452452BDD64 ON qui_somme_nous (profession_id_id)');
        $this->addSql('ALTER TABLE qui_somme_nous ADD CONSTRAINT FK_81DA14526BA58F3E FOREIGN KEY (personne_id_id) REFERENCES personne_membre (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE qui_somme_nous ADD CONSTRAINT FK_81DA1452452BDD64 FOREIGN KEY (profession_id_id) REFERENCES profession (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE qui_somme_nous_id_seq CASCADE');
        $this->addSql('ALTER TABLE qui_somme_nous DROP CONSTRAINT FK_81DA14526BA58F3E');
        $this->addSql('ALTER TABLE qui_somme_nous DROP CONSTRAINT FK_81DA1452452BDD64');
        $this->addSql('DROP TABLE qui_somme_nous');
    }
}
