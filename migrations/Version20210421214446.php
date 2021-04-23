<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210421214446 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE images DROP FOREIGN KEY FK_E01FBE6AAB627E8B');
        $this->addSql('DROP INDEX IDX_E01FBE6AAB627E8B ON images');
        $this->addSql('ALTER TABLE images DROP presentation_id');
        $this->addSql('ALTER TABLE presentation DROP FOREIGN KEY FK_9B66E8936731EC9E');
        $this->addSql('DROP INDEX IDX_9B66E8936731EC9E ON presentation');
        $this->addSql('ALTER TABLE presentation DROP image_top_id');
        $this->addSql('ALTER TABLE users CHANGE active active TINYINT(1) NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE images ADD presentation_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE images ADD CONSTRAINT FK_E01FBE6AAB627E8B FOREIGN KEY (presentation_id) REFERENCES presentation (id)');
        $this->addSql('CREATE INDEX IDX_E01FBE6AAB627E8B ON images (presentation_id)');
        $this->addSql('ALTER TABLE presentation ADD image_top_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE presentation ADD CONSTRAINT FK_9B66E8936731EC9E FOREIGN KEY (image_top_id) REFERENCES images (id)');
        $this->addSql('CREATE INDEX IDX_9B66E8936731EC9E ON presentation (image_top_id)');
        $this->addSql('ALTER TABLE users CHANGE active active TINYINT(1) DEFAULT NULL');
    }
}
