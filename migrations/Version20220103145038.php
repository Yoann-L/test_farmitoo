<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220103145038 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE brand_country_vat (id INT AUTO_INCREMENT NOT NULL, brand_id INT NOT NULL, country_id INT NOT NULL, vat DOUBLE PRECISION NOT NULL, INDEX IDX_DECA345744F5D008 (brand_id), INDEX IDX_DECA3457F92F3E70 (country_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE brand_country_vat ADD CONSTRAINT FK_DECA345744F5D008 FOREIGN KEY (brand_id) REFERENCES brand (id)');
        $this->addSql('ALTER TABLE brand_country_vat ADD CONSTRAINT FK_DECA3457F92F3E70 FOREIGN KEY (country_id) REFERENCES country (id)');
        $this->addSql('DROP TABLE brand_country_tva');
        $this->addSql('ALTER TABLE brand CHANGE tva vat DOUBLE PRECISION DEFAULT NULL');
        $this->addSql('ALTER TABLE country CHANGE tva vat DOUBLE PRECISION NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE brand_country_tva (id INT AUTO_INCREMENT NOT NULL, brand_id INT NOT NULL, country_id INT NOT NULL, tva DOUBLE PRECISION NOT NULL, INDEX IDX_B510804444F5D008 (brand_id), INDEX IDX_B5108044F92F3E70 (country_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE brand_country_tva ADD CONSTRAINT FK_B510804444F5D008 FOREIGN KEY (brand_id) REFERENCES brand (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE brand_country_tva ADD CONSTRAINT FK_B5108044F92F3E70 FOREIGN KEY (country_id) REFERENCES country (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('DROP TABLE brand_country_vat');
        $this->addSql('ALTER TABLE brand CHANGE vat tva DOUBLE PRECISION DEFAULT NULL');
        $this->addSql('ALTER TABLE country CHANGE vat tva DOUBLE PRECISION NOT NULL');
    }
}
