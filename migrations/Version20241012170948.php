<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241012170948 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE restauration_membre_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE restauration_membre (id INT NOT NULL, id_personne_membre_id INT NOT NULL, date_restauration DATE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_A235361EEFCE22FB ON restauration_membre (id_personne_membre_id)');
        $this->addSql('ALTER TABLE restauration_membre ADD CONSTRAINT FK_A235361EEFCE22FB FOREIGN KEY (id_personne_membre_id) REFERENCES personne_membre (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE restauration_membre_id_seq CASCADE');
        $this->addSql('ALTER TABLE restauration_membre DROP CONSTRAINT FK_A235361EEFCE22FB');
        $this->addSql('DROP TABLE restauration_membre');
    }
}
