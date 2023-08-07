<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230805102535 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE facture (id INT AUTO_INCREMENT NOT NULL, ref_facture VARCHAR(255) NOT NULL, montant_electricite INT NOT NULL, montant_eau INT NOT NULL, date DATE NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE materiel (id INT AUTO_INCREMENT NOT NULL, nom_materiel VARCHAR(255) NOT NULL, nombre_kw INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE moderateur (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_6DDC35546C6E55B5 (nom), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE utiliser_materiel (id INT AUTO_INCREMENT NOT NULL, utilisateur_id INT DEFAULT NULL, materiel_id INT DEFAULT NULL, duree_utilisation INT NOT NULL, INDEX IDX_19506D66FB88E14F (utilisateur_id), INDEX IDX_19506D6616880AAF (materiel_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE utiliser_materiel ADD CONSTRAINT FK_19506D66FB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE utiliser_materiel ADD CONSTRAINT FK_19506D6616880AAF FOREIGN KEY (materiel_id) REFERENCES materiel (id)');
        $this->addSql('ALTER TABLE adresse ADD facture_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE adresse ADD CONSTRAINT FK_C35F08167F2DEE08 FOREIGN KEY (facture_id) REFERENCES facture (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_C35F08167F2DEE08 ON adresse (facture_id)');
        $this->addSql('ALTER TABLE utilisateur ADD adresse_id INT DEFAULT NULL, CHANGE roles roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\'');
        $this->addSql('ALTER TABLE utilisateur ADD CONSTRAINT FK_1D1C63B34DE7DC5C FOREIGN KEY (adresse_id) REFERENCES adresse (id)');
        $this->addSql('CREATE INDEX IDX_1D1C63B34DE7DC5C ON utilisateur (adresse_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE adresse DROP FOREIGN KEY FK_C35F08167F2DEE08');
        $this->addSql('ALTER TABLE utiliser_materiel DROP FOREIGN KEY FK_19506D66FB88E14F');
        $this->addSql('ALTER TABLE utiliser_materiel DROP FOREIGN KEY FK_19506D6616880AAF');
        $this->addSql('DROP TABLE facture');
        $this->addSql('DROP TABLE materiel');
        $this->addSql('DROP TABLE moderateur');
        $this->addSql('DROP TABLE utiliser_materiel');
        $this->addSql('DROP INDEX UNIQ_C35F08167F2DEE08 ON adresse');
        $this->addSql('ALTER TABLE adresse DROP facture_id');
        $this->addSql('ALTER TABLE utilisateur DROP FOREIGN KEY FK_1D1C63B34DE7DC5C');
        $this->addSql('DROP INDEX IDX_1D1C63B34DE7DC5C ON utilisateur');
        $this->addSql('ALTER TABLE utilisateur DROP adresse_id, CHANGE roles roles LONGTEXT NOT NULL COLLATE `utf8mb4_bin`');
    }
}
