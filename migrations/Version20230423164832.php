<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230423164832 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE categorie (id INT NOT NULL, nom VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE images (id INT NOT NULL, produits_id INT NOT NULL, nom VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_E01FBE6ACD11A2CF ON images (produits_id)');
        $this->addSql('CREATE TABLE produits (id INT NOT NULL, categorie_id INT NOT NULL, nom VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, prix DOUBLE PRECISION NOT NULL, promotions DOUBLE PRECISION DEFAULT NULL, new_prix DOUBLE PRECISION DEFAULT NULL, debut TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, fin TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_BE2DDF8CBCF5E72D ON produits (categorie_id)');
        $this->addSql('ALTER TABLE images ADD CONSTRAINT FK_E01FBE6ACD11A2CF FOREIGN KEY (produits_id) REFERENCES produits (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE produits ADD CONSTRAINT FK_BE2DDF8CBCF5E72D FOREIGN KEY (categorie_id) REFERENCES categorie (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE images DROP CONSTRAINT FK_E01FBE6ACD11A2CF');
        $this->addSql('ALTER TABLE produits DROP CONSTRAINT FK_BE2DDF8CBCF5E72D');
        $this->addSql('DROP TABLE categorie');
        $this->addSql('DROP TABLE images');
        $this->addSql('DROP TABLE produits');
    }
}
