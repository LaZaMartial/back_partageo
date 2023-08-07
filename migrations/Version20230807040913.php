<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230807040913 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE adresse DROP FOREIGN KEY FK_C35F08167F2DEE08');
        $this->addSql('DROP INDEX UNIQ_C35F08167F2DEE08 ON adresse');
        $this->addSql('ALTER TABLE adresse DROP facture_id');
        $this->addSql('ALTER TABLE facture ADD adresse_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE facture ADD CONSTRAINT FK_FE8664104DE7DC5C FOREIGN KEY (adresse_id) REFERENCES adresse (id)');
        $this->addSql('CREATE INDEX IDX_FE8664104DE7DC5C ON facture (adresse_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE adresse ADD facture_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE adresse ADD CONSTRAINT FK_C35F08167F2DEE08 FOREIGN KEY (facture_id) REFERENCES facture (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_C35F08167F2DEE08 ON adresse (facture_id)');
        $this->addSql('ALTER TABLE facture DROP FOREIGN KEY FK_FE8664104DE7DC5C');
        $this->addSql('DROP INDEX IDX_FE8664104DE7DC5C ON facture');
        $this->addSql('ALTER TABLE facture DROP adresse_id');
    }
}
