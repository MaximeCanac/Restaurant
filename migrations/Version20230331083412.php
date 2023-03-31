<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230331083412 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE plats');
        $this->addSql('DROP TABLE selection');
        $this->addSql('ALTER TABLE menu ADD COLUMN date_creation DATE NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE plats (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, nom VARCHAR(255) NOT NULL COLLATE "BINARY", ingredient VARCHAR(255) NOT NULL COLLATE "BINARY", prix DOUBLE PRECISION DEFAULT NULL, type VARCHAR(255) DEFAULT NULL COLLATE "BINARY")');
        $this->addSql('CREATE TABLE selection (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, entrees VARCHAR(255) NOT NULL COLLATE "BINARY", plats VARCHAR(255) NOT NULL COLLATE "BINARY", desserts VARCHAR(255) NOT NULL COLLATE "BINARY")');
        $this->addSql('CREATE TEMPORARY TABLE __temp__menu AS SELECT id FROM menu');
        $this->addSql('DROP TABLE menu');
        $this->addSql('CREATE TABLE menu (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL)');
        $this->addSql('INSERT INTO menu (id) SELECT id FROM __temp__menu');
        $this->addSql('DROP TABLE __temp__menu');
    }
}
