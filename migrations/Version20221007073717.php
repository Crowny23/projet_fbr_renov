<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221007073717 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE customers CHANGE customer_note customer_note VARCHAR(255) DEFAULT NULL, CHANGE update_at update_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE repairs ADD client_id INT NOT NULL, ADD category_id INT NOT NULL');
        $this->addSql('ALTER TABLE repairs ADD CONSTRAINT FK_57E93B6119EB6921 FOREIGN KEY (client_id) REFERENCES customers (id)');
        $this->addSql('ALTER TABLE repairs ADD CONSTRAINT FK_57E93B6112469DE2 FOREIGN KEY (category_id) REFERENCES repairs_categories (id) ON DELETE CASCADE');
        $this->addSql('CREATE INDEX IDX_57E93B6119EB6921 ON repairs (client_id)');
        $this->addSql('CREATE INDEX IDX_57E93B6112469DE2 ON repairs (category_id)');
        $this->addSql('ALTER TABLE repairs_images DROP FOREIGN KEY FK_294E7B6343833CFF');
        $this->addSql('ALTER TABLE repairs_images ADD updated_at DATETIME DEFAULT NULL, ADD image_size INT DEFAULT NULL, CHANGE image_repairs_images image_repairs_images VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE repairs_images ADD CONSTRAINT FK_294E7B6343833CFF FOREIGN KEY (repair_id) REFERENCES repairs (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE worksite_images ADD updated_at VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE worksites ADD client_worksite_id INT NOT NULL, CHANGE duration_worksite duration_worksite INT NOT NULL, CHANGE supplement_worksite supplement_worksite INT NOT NULL, CHANGE is_urgent is_urgent TINYINT(1) DEFAULT NULL');
        $this->addSql('ALTER TABLE worksites ADD CONSTRAINT FK_18E66B40A53C12DC FOREIGN KEY (client_worksite_id) REFERENCES customers (id)');
        $this->addSql('CREATE INDEX IDX_18E66B40A53C12DC ON worksites (client_worksite_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE customers CHANGE customer_note customer_note VARCHAR(255) NOT NULL, CHANGE update_at update_at DATETIME NOT NULL');
        $this->addSql('ALTER TABLE repairs DROP FOREIGN KEY FK_57E93B6119EB6921');
        $this->addSql('ALTER TABLE repairs DROP FOREIGN KEY FK_57E93B6112469DE2');
        $this->addSql('DROP INDEX IDX_57E93B6119EB6921 ON repairs');
        $this->addSql('DROP INDEX IDX_57E93B6112469DE2 ON repairs');
        $this->addSql('ALTER TABLE repairs DROP client_id, DROP category_id');
        $this->addSql('ALTER TABLE repairs_images DROP FOREIGN KEY FK_294E7B6343833CFF');
        $this->addSql('ALTER TABLE repairs_images DROP updated_at, DROP image_size, CHANGE image_repairs_images image_repairs_images VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE repairs_images ADD CONSTRAINT FK_294E7B6343833CFF FOREIGN KEY (repair_id) REFERENCES repairs (id)');
        $this->addSql('ALTER TABLE worksite_images DROP updated_at');
        $this->addSql('ALTER TABLE worksites DROP FOREIGN KEY FK_18E66B40A53C12DC');
        $this->addSql('DROP INDEX IDX_18E66B40A53C12DC ON worksites');
        $this->addSql('ALTER TABLE worksites DROP client_worksite_id, CHANGE duration_worksite duration_worksite DATETIME NOT NULL, CHANGE supplement_worksite supplement_worksite TIME DEFAULT NULL, CHANGE is_urgent is_urgent TINYINT(1) NOT NULL');
    }
}
