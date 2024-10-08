<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241008035136 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE role_suspendu_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE role_suspendu (id INT NOT NULL, id_admin_id INT NOT NULL, date_suspension DATE NOT NULL, date_fin_suspension DATE NOT NULL, role VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_C855050C34F06E85 ON role_suspendu (id_admin_id)');
        $this->addSql('ALTER TABLE role_suspendu ADD CONSTRAINT FK_C855050C34F06E85 FOREIGN KEY (id_admin_id) REFERENCES users (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE role_suspendu_id_seq CASCADE');
        $this->addSql('ALTER TABLE role_suspendu DROP CONSTRAINT FK_C855050C34F06E85');
        $this->addSql('DROP TABLE role_suspendu');
    }
}
