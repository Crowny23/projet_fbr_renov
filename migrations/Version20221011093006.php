<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221011093006 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE raw_materials ADD CONSTRAINT FK_8433378412469DE2 FOREIGN KEY (category_id) REFERENCES raw_materials_categories (id)');
        $this->addSql('CREATE INDEX IDX_8433378412469DE2 ON raw_materials (category_id)');
        $this->addSql('ALTER TABLE raw_materials_ordered ADD total_price_raw_material INT DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE raw_materials DROP FOREIGN KEY FK_8433378412469DE2');
        $this->addSql('DROP INDEX IDX_8433378412469DE2 ON raw_materials');
        $this->addSql('ALTER TABLE raw_materials_ordered DROP total_price_raw_material');
    }
}
