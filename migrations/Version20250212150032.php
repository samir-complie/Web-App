<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250212150032 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE commande (id INT AUTO_INCREMENT NOT NULL, id_client_commande_id INT NOT NULL, livraison_id INT NOT NULL, produit VARCHAR(255) NOT NULL, prix DOUBLE PRECISION NOT NULL, adresse LONGTEXT NOT NULL, num_tel INT NOT NULL, UNIQUE INDEX UNIQ_6EEAA67D83B9C0 (id_client_commande_id), INDEX IDX_6EEAA67D8E54FB25 (livraison_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE historique (id INT AUTO_INCREMENT NOT NULL, offre DOUBLE PRECISION NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE livraison (id INT AUTO_INCREMENT NOT NULL, id_transporteur_id INT NOT NULL, is_etat TINYINT(1) NOT NULL, INDEX IDX_A60C9F1F7E96AC2C (id_transporteur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE panier (id INT AUTO_INCREMENT NOT NULL, id_client_id INT NOT NULL, UNIQUE INDEX UNIQ_24CC0DF299DED506 (id_client_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE panier_produit_store (panier_id INT NOT NULL, produit_store_id INT NOT NULL, INDEX IDX_CC2EEE7DF77D927C (panier_id), INDEX IDX_CC2EEE7D998D9A02 (produit_store_id), PRIMARY KEY(panier_id, produit_store_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE commande ADD CONSTRAINT FK_6EEAA67D83B9C0 FOREIGN KEY (id_client_commande_id) REFERENCES panier (id)');
        $this->addSql('ALTER TABLE commande ADD CONSTRAINT FK_6EEAA67D8E54FB25 FOREIGN KEY (livraison_id) REFERENCES livraison (id)');
        $this->addSql('ALTER TABLE livraison ADD CONSTRAINT FK_A60C9F1F7E96AC2C FOREIGN KEY (id_transporteur_id) REFERENCES transporteur (id)');
        $this->addSql('ALTER TABLE panier ADD CONSTRAINT FK_24CC0DF299DED506 FOREIGN KEY (id_client_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE panier_produit_store ADD CONSTRAINT FK_CC2EEE7DF77D927C FOREIGN KEY (panier_id) REFERENCES panier (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE panier_produit_store ADD CONSTRAINT FK_CC2EEE7D998D9A02 FOREIGN KEY (produit_store_id) REFERENCES produit_store (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE enchere ADD id_produit_enchere_id INT NOT NULL');
        $this->addSql('ALTER TABLE enchere ADD CONSTRAINT FK_38D1870FC211E559 FOREIGN KEY (id_produit_enchere_id) REFERENCES produit_enchere (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_38D1870FC211E559 ON enchere (id_produit_enchere_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commande DROP FOREIGN KEY FK_6EEAA67D83B9C0');
        $this->addSql('ALTER TABLE commande DROP FOREIGN KEY FK_6EEAA67D8E54FB25');
        $this->addSql('ALTER TABLE livraison DROP FOREIGN KEY FK_A60C9F1F7E96AC2C');
        $this->addSql('ALTER TABLE panier DROP FOREIGN KEY FK_24CC0DF299DED506');
        $this->addSql('ALTER TABLE panier_produit_store DROP FOREIGN KEY FK_CC2EEE7DF77D927C');
        $this->addSql('ALTER TABLE panier_produit_store DROP FOREIGN KEY FK_CC2EEE7D998D9A02');
        $this->addSql('DROP TABLE commande');
        $this->addSql('DROP TABLE historique');
        $this->addSql('DROP TABLE livraison');
        $this->addSql('DROP TABLE panier');
        $this->addSql('DROP TABLE panier_produit_store');
        $this->addSql('ALTER TABLE enchere DROP FOREIGN KEY FK_38D1870FC211E559');
        $this->addSql('DROP INDEX UNIQ_38D1870FC211E559 ON enchere');
        $this->addSql('ALTER TABLE enchere DROP id_produit_enchere_id');
    }
}
