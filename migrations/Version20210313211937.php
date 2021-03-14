<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210313211937 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE carousels');
        $this->addSql('ALTER TABLE images DROP FOREIGN KEY FK_E01FBE6ADA1947F7');
        $this->addSql('DROP INDEX UNIQ_E01FBE6ADA1947F7 ON images');
        $this->addSql('ALTER TABLE images DROP images_carousel_accueil_id');
        $this->addSql('ALTER TABLE images_carousel_accueil ADD name VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE carousels (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE images ADD images_carousel_accueil_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE images ADD CONSTRAINT FK_E01FBE6ADA1947F7 FOREIGN KEY (images_carousel_accueil_id) REFERENCES images_carousel_accueil (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_E01FBE6ADA1947F7 ON images (images_carousel_accueil_id)');
        $this->addSql('ALTER TABLE images_carousel_accueil DROP name');
    }
}
