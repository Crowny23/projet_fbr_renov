<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221011075119 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE orders (id INT AUTO_INCREMENT NOT NULL, name_order VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE raw_materials (id INT AUTO_INCREMENT NOT NULL, name_raw_material VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE raw_materials_ordered (id INT AUTO_INCREMENT NOT NULL, orders_id INT NOT NULL, raw_material_id INT NOT NULL, quantity INT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_CB678D49CFFE9AD6 (orders_id), INDEX IDX_CB678D49693CA4A7 (raw_material_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE raw_materials_ordered ADD CONSTRAINT FK_CB678D49CFFE9AD6 FOREIGN KEY (orders_id) REFERENCES orders (id)');
        $this->addSql('ALTER TABLE raw_materials_ordered ADD CONSTRAINT FK_CB678D49693CA4A7 FOREIGN KEY (raw_material_id) REFERENCES raw_materials (id)');
        $this->addSql('ALTER TABLE worksite_images CHANGE updated_at updated_at DATETIME DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE raw_materials_ordered DROP FOREIGN KEY FK_CB678D49CFFE9AD6');
        $this->addSql('ALTER TABLE raw_materials_ordered DROP FOREIGN KEY FK_CB678D49693CA4A7');
        $this->addSql('DROP TABLE orders');
        $this->addSql('DROP TABLE raw_materials');
        $this->addSql('DROP TABLE raw_materials_ordered');
        $this->addSql('ALTER TABLE worksite_images CHANGE updated_at updated_at VARCHAR(255) DEFAULT NULL');
    }
}
