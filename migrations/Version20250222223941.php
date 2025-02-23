<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250222223941 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE livraison DROP FOREIGN KEY FK_A60C9F1F7E96AC2C');
        $this->addSql('DROP INDEX IDX_A60C9F1F7E96AC2C ON livraison');
        $this->addSql('ALTER TABLE livraison CHANGE id_transporteur_id transporteur_id INT NOT NULL');
        $this->addSql('ALTER TABLE livraison ADD CONSTRAINT FK_A60C9F1F97C86FA4 FOREIGN KEY (transporteur_id) REFERENCES transporteur (id)');
        $this->addSql('CREATE INDEX IDX_A60C9F1F97C86FA4 ON livraison (transporteur_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE livraison DROP FOREIGN KEY FK_A60C9F1F97C86FA4');
        $this->addSql('DROP INDEX IDX_A60C9F1F97C86FA4 ON livraison');
        $this->addSql('ALTER TABLE livraison CHANGE transporteur_id id_transporteur_id INT NOT NULL');
        $this->addSql('ALTER TABLE livraison ADD CONSTRAINT FK_A60C9F1F7E96AC2C FOREIGN KEY (id_transporteur_id) REFERENCES transporteur (id)');
        $this->addSql('CREATE INDEX IDX_A60C9F1F7E96AC2C ON livraison (id_transporteur_id)');
    }
}
