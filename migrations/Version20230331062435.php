<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230331062435 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE dessert (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, ingredient VARCHAR(255) NOT NULL, prix INTEGER DEFAULT NULL)');
        $this->addSql('CREATE TABLE entree (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, ingredient VARCHAR(255) NOT NULL, prix INTEGER DEFAULT NULL)');
        $this->addSql('CREATE TABLE menu (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL)');
        $this->addSql('CREATE TABLE menu_entree (menu_id INTEGER NOT NULL, entree_id INTEGER NOT NULL, PRIMARY KEY(menu_id, entree_id), CONSTRAINT FK_8AC42F7ECCD7E912 FOREIGN KEY (menu_id) REFERENCES menu (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_8AC42F7EAF7BD910 FOREIGN KEY (entree_id) REFERENCES entree (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_8AC42F7ECCD7E912 ON menu_entree (menu_id)');
        $this->addSql('CREATE INDEX IDX_8AC42F7EAF7BD910 ON menu_entree (entree_id)');
        $this->addSql('CREATE TABLE menu_plat (menu_id INTEGER NOT NULL, plat_id INTEGER NOT NULL, PRIMARY KEY(menu_id, plat_id), CONSTRAINT FK_E8775249CCD7E912 FOREIGN KEY (menu_id) REFERENCES menu (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_E8775249D73DB560 FOREIGN KEY (plat_id) REFERENCES plat (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_E8775249CCD7E912 ON menu_plat (menu_id)');
        $this->addSql('CREATE INDEX IDX_E8775249D73DB560 ON menu_plat (plat_id)');
        $this->addSql('CREATE TABLE menu_dessert (menu_id INTEGER NOT NULL, dessert_id INTEGER NOT NULL, PRIMARY KEY(menu_id, dessert_id), CONSTRAINT FK_F1F20628CCD7E912 FOREIGN KEY (menu_id) REFERENCES menu (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_F1F20628745B52FD FOREIGN KEY (dessert_id) REFERENCES dessert (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_F1F20628CCD7E912 ON menu_dessert (menu_id)');
        $this->addSql('CREATE INDEX IDX_F1F20628745B52FD ON menu_dessert (dessert_id)');
        $this->addSql('CREATE TABLE plat (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, ingredient VARCHAR(255) NOT NULL, prix INTEGER DEFAULT NULL)');
       
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE dessert');
        $this->addSql('DROP TABLE entree');
        $this->addSql('DROP TABLE menu');
        $this->addSql('DROP TABLE menu_entree');
        $this->addSql('DROP TABLE menu_plat');
        $this->addSql('DROP TABLE menu_dessert');
        $this->addSql('DROP TABLE plat');
        $this->addSql('DROP TABLE post');
    }
}
