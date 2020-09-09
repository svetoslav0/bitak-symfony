<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200909105831 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE ad_status (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ad (id INT AUTO_INCREMENT NOT NULL, category_id INT DEFAULT NULL, city_id INT DEFAULT NULL, status_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, contact_name VARCHAR(255) NOT NULL, contact_email VARCHAR(255) NOT NULL, contact_phone VARCHAR(255) DEFAULT NULL, INDEX IDX_77E0ED5812469DE2 (category_id), INDEX IDX_77E0ED588BAC62AF (city_id), INDEX IDX_77E0ED586BF700BD (status_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE ad ADD CONSTRAINT FK_77E0ED5812469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE ad ADD CONSTRAINT FK_77E0ED588BAC62AF FOREIGN KEY (city_id) REFERENCES city (id)');
        $this->addSql('ALTER TABLE ad ADD CONSTRAINT FK_77E0ED586BF700BD FOREIGN KEY (status_id) REFERENCES ad_status (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ad DROP FOREIGN KEY FK_77E0ED586BF700BD');
        $this->addSql('DROP TABLE ad');
        $this->addSql('DROP TABLE ad_status');
    }
}
