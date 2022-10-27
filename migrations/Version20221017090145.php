<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221017090145 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE orders (id INT AUTO_INCREMENT NOT NULL, worksite_id INT DEFAULT NULL, supplier_id INT DEFAULT NULL, name_order VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', reference VARCHAR(255) NOT NULL, total_price INT DEFAULT NULL, INDEX IDX_E52FFDEEA47737E7 (worksite_id), INDEX IDX_E52FFDEE2ADD6D8C (supplier_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE raw_materials (id INT AUTO_INCREMENT NOT NULL, category_id INT NOT NULL, name_raw_material VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', unit VARCHAR(255) NOT NULL, price INT DEFAULT NULL, INDEX IDX_8433378412469DE2 (category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE raw_materials_categories (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE raw_materials_ordered (id INT AUTO_INCREMENT NOT NULL, orders_id INT NOT NULL, raw_material_id INT NOT NULL, quantity INT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', total_price_raw_material INT DEFAULT NULL, INDEX IDX_CB678D49CFFE9AD6 (orders_id), INDEX IDX_CB678D49693CA4A7 (raw_material_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE supplier (id INT AUTO_INCREMENT NOT NULL, name_supplier VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, phone INT NOT NULL, city VARCHAR(255) NOT NULL, cp INT NOT NULL, adress VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE orders ADD CONSTRAINT FK_E52FFDEEA47737E7 FOREIGN KEY (worksite_id) REFERENCES worksites (id)');
        $this->addSql('ALTER TABLE orders ADD CONSTRAINT FK_E52FFDEE2ADD6D8C FOREIGN KEY (supplier_id) REFERENCES supplier (id)');
        $this->addSql('ALTER TABLE raw_materials ADD CONSTRAINT FK_8433378412469DE2 FOREIGN KEY (category_id) REFERENCES raw_materials_categories (id)');
        $this->addSql('ALTER TABLE raw_materials_ordered ADD CONSTRAINT FK_CB678D49CFFE9AD6 FOREIGN KEY (orders_id) REFERENCES orders (id)');
        $this->addSql('ALTER TABLE raw_materials_ordered ADD CONSTRAINT FK_CB678D49693CA4A7 FOREIGN KEY (raw_material_id) REFERENCES raw_materials (id)');
        $this->addSql('ALTER TABLE designation DROP FOREIGN KEY FK_8947610DB4EA4E60');
        $this->addSql('DROP TABLE designation');
        $this->addSql('ALTER TABLE quotation DROP object');
        $this->addSql('ALTER TABLE repairs_images DROP mime_type');
        $this->addSql('ALTER TABLE worksite_images DROP mime_type, CHANGE image_worksite_images image_worksite_images VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE worksites CHANGE start_at start_at DATETIME NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE designation (id INT AUTO_INCREMENT NOT NULL, quotation_id INT DEFAULT NULL, name VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, unity VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, quantity INT NOT NULL, price_unitary_ht INT NOT NULL, tva INT NOT NULL, price_ht INT NOT NULL, INDEX IDX_8947610DB4EA4E60 (quotation_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE designation ADD CONSTRAINT FK_8947610DB4EA4E60 FOREIGN KEY (quotation_id) REFERENCES quotation (id)');
        $this->addSql('ALTER TABLE orders DROP FOREIGN KEY FK_E52FFDEEA47737E7');
        $this->addSql('ALTER TABLE orders DROP FOREIGN KEY FK_E52FFDEE2ADD6D8C');
        $this->addSql('ALTER TABLE raw_materials DROP FOREIGN KEY FK_8433378412469DE2');
        $this->addSql('ALTER TABLE raw_materials_ordered DROP FOREIGN KEY FK_CB678D49CFFE9AD6');
        $this->addSql('ALTER TABLE raw_materials_ordered DROP FOREIGN KEY FK_CB678D49693CA4A7');
        $this->addSql('DROP TABLE orders');
        $this->addSql('DROP TABLE raw_materials');
        $this->addSql('DROP TABLE raw_materials_categories');
        $this->addSql('DROP TABLE raw_materials_ordered');
        $this->addSql('DROP TABLE supplier');
        $this->addSql('ALTER TABLE quotation ADD object VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE repairs_images ADD mime_type VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE worksite_images ADD mime_type VARCHAR(255) DEFAULT NULL, CHANGE image_worksite_images image_worksite_images VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE worksites CHANGE start_at start_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
    }
}
