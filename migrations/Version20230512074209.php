<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230512074209 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__avis AS SELECT id, commentaire, note FROM avis');
        $this->addSql('DROP TABLE avis');
        $this->addSql('CREATE TABLE avis (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, commentaire VARCHAR(255) NOT NULL, note INTEGER NOT NULL, auteur VARCHAR(255) NOT NULL, date DATE NOT NULL)');
        $this->addSql('INSERT INTO avis (id, commentaire, note) SELECT id, commentaire, note FROM __temp__avis');
        $this->addSql('DROP TABLE __temp__avis');
        $this->addSql('CREATE TEMPORARY TABLE __temp__menu AS SELECT id, date_creation FROM menu');
        $this->addSql('DROP TABLE menu');
        $this->addSql('CREATE TABLE menu (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, date_creation DATE NOT NULL)');
        $this->addSql('INSERT INTO menu (id, date_creation) SELECT id, date_creation FROM __temp__menu');
        $this->addSql('DROP TABLE __temp__menu');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__avis AS SELECT id, note, commentaire FROM avis');
        $this->addSql('DROP TABLE avis');
        $this->addSql('CREATE TABLE avis (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, note INTEGER NOT NULL, commentaire VARCHAR(255) DEFAULT NULL)');
        $this->addSql('INSERT INTO avis (id, note, commentaire) SELECT id, note, commentaire FROM __temp__avis');
        $this->addSql('DROP TABLE __temp__avis');
        $this->addSql('CREATE TEMPORARY TABLE __temp__menu AS SELECT id, date_creation FROM menu');
        $this->addSql('DROP TABLE menu');
        $this->addSql('CREATE TABLE menu (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, date_creation DATE DEFAULT NULL)');
        $this->addSql('INSERT INTO menu (id, date_creation) SELECT id, date_creation FROM __temp__menu');
        $this->addSql('DROP TABLE __temp__menu');
    }
}
