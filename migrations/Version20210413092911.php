<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210413092911 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE images ADD presentation_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE images ADD CONSTRAINT FK_E01FBE6AAB627E8B FOREIGN KEY (presentation_id) REFERENCES presentation (id)');
        $this->addSql('CREATE INDEX IDX_E01FBE6AAB627E8B ON images (presentation_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE images DROP FOREIGN KEY FK_E01FBE6AAB627E8B');
        $this->addSql('DROP INDEX IDX_E01FBE6AAB627E8B ON images');
        $this->addSql('ALTER TABLE images DROP presentation_id');
    }
}
