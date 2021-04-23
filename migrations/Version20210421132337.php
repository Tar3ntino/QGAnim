<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210421132337 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE presentation ADD image_top_id INT DEFAULT NULL, ADD image_bottom_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE presentation ADD CONSTRAINT FK_9B66E8936731EC9E FOREIGN KEY (image_top_id) REFERENCES images (id)');
        $this->addSql('ALTER TABLE presentation ADD CONSTRAINT FK_9B66E893866FBC40 FOREIGN KEY (image_bottom_id) REFERENCES images (id)');
        $this->addSql('CREATE INDEX IDX_9B66E8936731EC9E ON presentation (image_top_id)');
        $this->addSql('CREATE INDEX IDX_9B66E893866FBC40 ON presentation (image_bottom_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE presentation DROP FOREIGN KEY FK_9B66E8936731EC9E');
        $this->addSql('ALTER TABLE presentation DROP FOREIGN KEY FK_9B66E893866FBC40');
        $this->addSql('DROP INDEX IDX_9B66E8936731EC9E ON presentation');
        $this->addSql('DROP INDEX IDX_9B66E893866FBC40 ON presentation');
        $this->addSql('ALTER TABLE presentation DROP image_top_id, DROP image_bottom_id');
    }
}
