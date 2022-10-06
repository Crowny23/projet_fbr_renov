<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221005113345 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE repairs DROP FOREIGN KEY FK_57E93B6112469DE2');
        $this->addSql('ALTER TABLE repairs CHANGE category_id category_id INT NOT NULL');
        $this->addSql('ALTER TABLE repairs ADD CONSTRAINT FK_57E93B6112469DE2 FOREIGN KEY (category_id) REFERENCES repairs_categories (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE repairs DROP FOREIGN KEY FK_57E93B6112469DE2');
        $this->addSql('ALTER TABLE repairs CHANGE category_id category_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE repairs ADD CONSTRAINT FK_57E93B6112469DE2 FOREIGN KEY (category_id) REFERENCES repairs_categories (id)');
    }
}
