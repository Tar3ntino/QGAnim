<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210421225031 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE images ADD presentation_id INT DEFAULT NULL, ADD presentations_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE images ADD CONSTRAINT FK_E01FBE6AAB627E8B FOREIGN KEY (presentation_id) REFERENCES presentation (id)');
        $this->addSql('ALTER TABLE images ADD CONSTRAINT FK_E01FBE6A9DB085F3 FOREIGN KEY (presentations_id) REFERENCES presentation (id)');
        $this->addSql('CREATE INDEX IDX_E01FBE6AAB627E8B ON images (presentation_id)');
        $this->addSql('CREATE INDEX IDX_E01FBE6A9DB085F3 ON images (presentations_id)');
        $this->addSql('ALTER TABLE presentation DROP FOREIGN KEY FK_9B66E893866FBC40');
        $this->addSql('DROP INDEX IDX_9B66E893866FBC40 ON presentation');
        $this->addSql('ALTER TABLE presentation DROP image_bottom_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE images DROP FOREIGN KEY FK_E01FBE6AAB627E8B');
        $this->addSql('ALTER TABLE images DROP FOREIGN KEY FK_E01FBE6A9DB085F3');
        $this->addSql('DROP INDEX IDX_E01FBE6AAB627E8B ON images');
        $this->addSql('DROP INDEX IDX_E01FBE6A9DB085F3 ON images');
        $this->addSql('ALTER TABLE images DROP presentation_id, DROP presentations_id');
        $this->addSql('ALTER TABLE presentation ADD image_bottom_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE presentation ADD CONSTRAINT FK_9B66E893866FBC40 FOREIGN KEY (image_bottom_id) REFERENCES images (id)');
        $this->addSql('CREATE INDEX IDX_9B66E893866FBC40 ON presentation (image_bottom_id)');
    }
}
