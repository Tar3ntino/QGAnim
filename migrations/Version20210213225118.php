<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210213225118 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE animations (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE animations_categories (animations_id INT NOT NULL, categories_id INT NOT NULL, INDEX IDX_AE4B1D8A50F4B97A (animations_id), INDEX IDX_AE4B1D8AA21214B7 (categories_id), PRIMARY KEY(animations_id, categories_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE animations_categories ADD CONSTRAINT FK_AE4B1D8A50F4B97A FOREIGN KEY (animations_id) REFERENCES animations (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE animations_categories ADD CONSTRAINT FK_AE4B1D8AA21214B7 FOREIGN KEY (categories_id) REFERENCES categories (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE animations_categories DROP FOREIGN KEY FK_AE4B1D8A50F4B97A');
        $this->addSql('DROP TABLE animations');
        $this->addSql('DROP TABLE animations_categories');
    }
}
