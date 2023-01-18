<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230112100218 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE company_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE composition_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE country_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE company (id INT NOT NULL, name VARCHAR(50) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE company_country (company_id INT NOT NULL, country_id INT NOT NULL, PRIMARY KEY(company_id, country_id))');
        $this->addSql('CREATE INDEX IDX_7321D3B1979B1AD6 ON company_country (company_id)');
        $this->addSql('CREATE INDEX IDX_7321D3B1F92F3E70 ON company_country (country_id)');
        $this->addSql('CREATE TABLE composition (id INT NOT NULL, nb_adult INT DEFAULT NULL, nb_child INT DEFAULT NULL, nb_animals INT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE country (id INT NOT NULL, name VARCHAR(50) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE company_country ADD CONSTRAINT FK_7321D3B1979B1AD6 FOREIGN KEY (company_id) REFERENCES company (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE company_country ADD CONSTRAINT FK_7321D3B1F92F3E70 FOREIGN KEY (country_id) REFERENCES country (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE reservation ADD composition_id INT NOT NULL');
        $this->addSql('ALTER TABLE reservation ADD country_id INT NOT NULL');
        $this->addSql('ALTER TABLE reservation ADD company_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C8495587A2E12 FOREIGN KEY (composition_id) REFERENCES composition (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C84955F92F3E70 FOREIGN KEY (country_id) REFERENCES country (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C84955979B1AD6 FOREIGN KEY (company_id) REFERENCES company (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_42C8495587A2E12 ON reservation (composition_id)');
        $this->addSql('CREATE INDEX IDX_42C84955F92F3E70 ON reservation (country_id)');
        $this->addSql('CREATE INDEX IDX_42C84955979B1AD6 ON reservation (company_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE reservation DROP CONSTRAINT FK_42C84955979B1AD6');
        $this->addSql('ALTER TABLE reservation DROP CONSTRAINT FK_42C8495587A2E12');
        $this->addSql('ALTER TABLE reservation DROP CONSTRAINT FK_42C84955F92F3E70');
        $this->addSql('DROP SEQUENCE company_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE composition_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE country_id_seq CASCADE');
        $this->addSql('ALTER TABLE company_country DROP CONSTRAINT FK_7321D3B1979B1AD6');
        $this->addSql('ALTER TABLE company_country DROP CONSTRAINT FK_7321D3B1F92F3E70');
        $this->addSql('DROP TABLE company');
        $this->addSql('DROP TABLE company_country');
        $this->addSql('DROP TABLE composition');
        $this->addSql('DROP TABLE country');
        $this->addSql('DROP INDEX IDX_42C8495587A2E12');
        $this->addSql('DROP INDEX IDX_42C84955F92F3E70');
        $this->addSql('DROP INDEX IDX_42C84955979B1AD6');
        $this->addSql('ALTER TABLE reservation DROP composition_id');
        $this->addSql('ALTER TABLE reservation DROP country_id');
        $this->addSql('ALTER TABLE reservation DROP company_id');
    }
}
