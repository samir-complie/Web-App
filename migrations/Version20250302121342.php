<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250302121342 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE historique CHANGE offre offre INT NOT NULL');
        $this->addSql('ALTER TABLE produit_enchere DROP prix_i');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE historique CHANGE offre offre DOUBLE PRECISION NOT NULL');
        $this->addSql('ALTER TABLE produit_enchere ADD prix_i DOUBLE PRECISION DEFAULT NULL');
    }
}
