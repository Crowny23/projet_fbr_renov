<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221004095353 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE customers (id INT AUTO_INCREMENT NOT NULL, id_user_id INT DEFAULT NULL, firstname VARCHAR(120) NOT NULL, lastname VARCHAR(120) NOT NULL, town VARCHAR(255) NOT NULL, postalcode INT NOT NULL, address VARCHAR(255) NOT NULL, mail VARCHAR(255) NOT NULL, phone INT NOT NULL, social_reason VARCHAR(255) NOT NULL, customer_note VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, update_at DATETIME NOT NULL, INDEX IDX_62534E2179F37AE5 (id_user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE materials (id INT AUTO_INCREMENT NOT NULL, name_material VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE quotation (id INT AUTO_INCREMENT NOT NULL, worksite_id INT NOT NULL, reference_quotation VARCHAR(255) NOT NULL, price_quotation INT NOT NULL, status_quotation VARCHAR(255) NOT NULL, deposit_quotation INT NOT NULL, intermediate_payment_quotation INT NOT NULL, final_payment_quotation INT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', UNIQUE INDEX UNIQ_474A8DB9A47737E7 (worksite_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE rentals (id INT AUTO_INCREMENT NOT NULL, renter_rentals_id INT NOT NULL, materials_rental_id INT NOT NULL, worksite_rental_id INT DEFAULT NULL, repair_rental_id INT DEFAULT NULL, quantity_rental INT NOT NULL, unit_price INT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_35ACDB4810F44388 (renter_rentals_id), INDEX IDX_35ACDB48C6E7E346 (materials_rental_id), INDEX IDX_35ACDB482E486C46 (worksite_rental_id), INDEX IDX_35ACDB48E6A2C130 (repair_rental_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE renter (id INT AUTO_INCREMENT NOT NULL, name_renter VARCHAR(255) NOT NULL, city_renter VARCHAR(255) NOT NULL, cp_renter INT NOT NULL, adress_renter VARCHAR(255) NOT NULL, website_renter VARCHAR(255) DEFAULT NULL, email_renter VARCHAR(255) NOT NULL, phone_renter INT NOT NULL, note_admin_renter VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE repairs (id INT AUTO_INCREMENT NOT NULL, name_repair VARCHAR(255) NOT NULL, city_repair VARCHAR(255) NOT NULL, cp_repair INT NOT NULL, adress_repair VARCHAR(255) NOT NULL, price_repair INT NOT NULL, reference_repair INT NOT NULL, schedule_repair VARCHAR(255) NOT NULL, travel_distance_repair INT NOT NULL, note_admin_repair VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE repairs_categories (id INT AUTO_INCREMENT NOT NULL, name_repairs_category VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE repairs_images (id INT AUTO_INCREMENT NOT NULL, repair_id INT NOT NULL, image_repairs_images VARCHAR(255) NOT NULL, INDEX IDX_294E7B6343833CFF (repair_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tasks (id INT AUTO_INCREMENT NOT NULL, worksite_id INT NOT NULL, name_task VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_50586597A47737E7 (worksite_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE users (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_1483A5E9E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE worksite_categories (id INT AUTO_INCREMENT NOT NULL, name_worksite_categories VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE worksite_images (id INT AUTO_INCREMENT NOT NULL, worksite_id INT NOT NULL, image_worksite_images VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_E8994D9EA47737E7 (worksite_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE worksites (id INT AUTO_INCREMENT NOT NULL, category_worksite_id INT NOT NULL, name_worksite VARCHAR(255) NOT NULL, city_worksite VARCHAR(255) NOT NULL, cp_worksite INT NOT NULL, adress_worksite VARCHAR(255) NOT NULL, start_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', duration_worksite DATETIME NOT NULL, supplement_worksite TIME DEFAULT NULL, travel_distance_worksite INT NOT NULL, note_client_worksite VARCHAR(255) DEFAULT NULL, note_admin_worksite VARCHAR(255) DEFAULT NULL, is_urgent TINYINT(1) NOT NULL, status_worksite VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_18E66B4013EC758C (category_worksite_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE customers ADD CONSTRAINT FK_62534E2179F37AE5 FOREIGN KEY (id_user_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE quotation ADD CONSTRAINT FK_474A8DB9A47737E7 FOREIGN KEY (worksite_id) REFERENCES worksites (id)');
        $this->addSql('ALTER TABLE rentals ADD CONSTRAINT FK_35ACDB4810F44388 FOREIGN KEY (renter_rentals_id) REFERENCES renter (id)');
        $this->addSql('ALTER TABLE rentals ADD CONSTRAINT FK_35ACDB48C6E7E346 FOREIGN KEY (materials_rental_id) REFERENCES materials (id)');
        $this->addSql('ALTER TABLE rentals ADD CONSTRAINT FK_35ACDB482E486C46 FOREIGN KEY (worksite_rental_id) REFERENCES worksites (id)');
        $this->addSql('ALTER TABLE rentals ADD CONSTRAINT FK_35ACDB48E6A2C130 FOREIGN KEY (repair_rental_id) REFERENCES repairs (id)');
        $this->addSql('ALTER TABLE repairs_images ADD CONSTRAINT FK_294E7B6343833CFF FOREIGN KEY (repair_id) REFERENCES repairs (id)');
        $this->addSql('ALTER TABLE tasks ADD CONSTRAINT FK_50586597A47737E7 FOREIGN KEY (worksite_id) REFERENCES worksites (id)');
        $this->addSql('ALTER TABLE worksite_images ADD CONSTRAINT FK_E8994D9EA47737E7 FOREIGN KEY (worksite_id) REFERENCES worksites (id)');
        $this->addSql('ALTER TABLE worksites ADD CONSTRAINT FK_18E66B4013EC758C FOREIGN KEY (category_worksite_id) REFERENCES worksite_categories (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE customers DROP FOREIGN KEY FK_62534E2179F37AE5');
        $this->addSql('ALTER TABLE quotation DROP FOREIGN KEY FK_474A8DB9A47737E7');
        $this->addSql('ALTER TABLE rentals DROP FOREIGN KEY FK_35ACDB4810F44388');
        $this->addSql('ALTER TABLE rentals DROP FOREIGN KEY FK_35ACDB48C6E7E346');
        $this->addSql('ALTER TABLE rentals DROP FOREIGN KEY FK_35ACDB482E486C46');
        $this->addSql('ALTER TABLE rentals DROP FOREIGN KEY FK_35ACDB48E6A2C130');
        $this->addSql('ALTER TABLE repairs_images DROP FOREIGN KEY FK_294E7B6343833CFF');
        $this->addSql('ALTER TABLE tasks DROP FOREIGN KEY FK_50586597A47737E7');
        $this->addSql('ALTER TABLE worksite_images DROP FOREIGN KEY FK_E8994D9EA47737E7');
        $this->addSql('ALTER TABLE worksites DROP FOREIGN KEY FK_18E66B4013EC758C');
        $this->addSql('DROP TABLE customers');
        $this->addSql('DROP TABLE materials');
        $this->addSql('DROP TABLE quotation');
        $this->addSql('DROP TABLE rentals');
        $this->addSql('DROP TABLE renter');
        $this->addSql('DROP TABLE repairs');
        $this->addSql('DROP TABLE repairs_categories');
        $this->addSql('DROP TABLE repairs_images');
        $this->addSql('DROP TABLE tasks');
        $this->addSql('DROP TABLE users');
        $this->addSql('DROP TABLE worksite_categories');
        $this->addSql('DROP TABLE worksite_images');
        $this->addSql('DROP TABLE worksites');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
