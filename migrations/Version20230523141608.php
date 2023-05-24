<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230523141608 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
       
        $this->addSql('CREATE TEMPORARY TABLE __temp__menu AS SELECT id, date_creation FROM menu');
        $this->addSql('DROP TABLE menu');
        $this->addSql('CREATE TABLE menu (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, date_creation DATE NOT NULL)');
        $this->addSql('INSERT INTO menu (id, date_creation) SELECT id, date_creation FROM __temp__menu');
        $this->addSql('DROP TABLE __temp__menu');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE avis');
        $this->addSql('CREATE TEMPORARY TABLE __temp__menu AS SELECT id, date_creation FROM menu');
        $this->addSql('DROP TABLE menu');
        $this->addSql('CREATE TABLE menu (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, date_creation DATE DEFAULT NULL)');
        $this->addSql('INSERT INTO menu (id, date_creation) SELECT id, date_creation FROM __temp__menu');
        $this->addSql('DROP TABLE __temp__menu');
    }
}
