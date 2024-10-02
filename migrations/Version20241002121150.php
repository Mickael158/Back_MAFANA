<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241002121150 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE suivis_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE suivis (id INT NOT NULL, administrateur_id_id INT NOT NULL, utilisateur_id_id INT NOT NULL, date_attribution DATE NOT NULL, role VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_6627ED706B298048 ON suivis (administrateur_id_id)');
        $this->addSql('CREATE INDEX IDX_6627ED70B981C689 ON suivis (utilisateur_id_id)');
        $this->addSql('ALTER TABLE suivis ADD CONSTRAINT FK_6627ED706B298048 FOREIGN KEY (administrateur_id_id) REFERENCES users (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE suivis ADD CONSTRAINT FK_6627ED70B981C689 FOREIGN KEY (utilisateur_id_id) REFERENCES users (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE suivis_id_seq CASCADE');
        $this->addSql('ALTER TABLE suivis DROP CONSTRAINT FK_6627ED706B298048');
        $this->addSql('ALTER TABLE suivis DROP CONSTRAINT FK_6627ED70B981C689');
        $this->addSql('DROP TABLE suivis');
    }
}
