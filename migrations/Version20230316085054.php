<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230316085054 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE type (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL)');
        $this->addSql('ALTER TABLE plats ADD COLUMN type VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE type');
        $this->addSql('CREATE TEMPORARY TABLE __temp__plats AS SELECT id, nom, ingredient, prix FROM plats');
        $this->addSql('DROP TABLE plats');
        $this->addSql('CREATE TABLE plats (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, ingredient VARCHAR(255) NOT NULL, prix DOUBLE PRECISION DEFAULT NULL)');
        $this->addSql('INSERT INTO plats (id, nom, ingredient, prix) SELECT id, nom, ingredient, prix FROM __temp__plats');
        $this->addSql('DROP TABLE __temp__plats');
    }
}
