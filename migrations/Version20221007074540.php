<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221007074540 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE worksite_images DROP created_at');
        $this->addSql('ALTER TABLE worksites ADD CONSTRAINT FK_18E66B40A53C12DC FOREIGN KEY (client_worksite_id) REFERENCES customers (id)');
        $this->addSql('CREATE INDEX IDX_18E66B40A53C12DC ON worksites (client_worksite_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE worksite_images ADD created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE worksites DROP FOREIGN KEY FK_18E66B40A53C12DC');
        $this->addSql('DROP INDEX IDX_18E66B40A53C12DC ON worksites');
    }
}
