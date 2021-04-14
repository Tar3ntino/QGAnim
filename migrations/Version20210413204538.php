<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210413204538 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE devis (id INT AUTO_INCREMENT NOT NULL, address LONGTEXT DEFAULT NULL, date_of_issue DATE NOT NULL, expiration_date DATE NOT NULL, description LONGTEXT NOT NULL, quantity INT NOT NULL, unit_price INT NOT NULL, tax NUMERIC(3, 2) DEFAULT NULL, amount NUMERIC(6, 2) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE images ADD devis_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE images ADD CONSTRAINT FK_E01FBE6A41DEFADA FOREIGN KEY (devis_id) REFERENCES devis (id)');
        $this->addSql('CREATE INDEX IDX_E01FBE6A41DEFADA ON images (devis_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE images DROP FOREIGN KEY FK_E01FBE6A41DEFADA');
        $this->addSql('DROP TABLE devis');
        $this->addSql('DROP INDEX IDX_E01FBE6A41DEFADA ON images');
        $this->addSql('ALTER TABLE images DROP devis_id');
    }
}
