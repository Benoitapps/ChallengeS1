<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230201192242 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE airport_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE annonce_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE city_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE compagny_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE composition_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE country_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE date_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE reset_password_request_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE "user_id_seq" INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE airport (id INT NOT NULL, city_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_7E91F7C28BAC62AF ON airport (city_id)');
        $this->addSql('CREATE TABLE annonce (id INT NOT NULL, date_depart_aller_id INT DEFAULT NULL, date_depart_arriver_id INT DEFAULT NULL, airport_depart_aller_id INT DEFAULT NULL, airport_depart_arriver_id INT DEFAULT NULL, date_retour_aller_id INT NOT NULL, date_retour_arriver_id INT NOT NULL, airport_retour_aller_id INT DEFAULT NULL, airport_retour_arriver_id INT DEFAULT NULL, composition_id INT DEFAULT NULL, client_id INT DEFAULT NULL, prix DOUBLE PRECISION NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_F65593E5CAD7D5F2 ON annonce (date_depart_aller_id)');
        $this->addSql('CREATE INDEX IDX_F65593E57ABFE0B3 ON annonce (date_depart_arriver_id)');
        $this->addSql('CREATE INDEX IDX_F65593E5AF90A56A ON annonce (airport_depart_aller_id)');
        $this->addSql('CREATE INDEX IDX_F65593E59322F4DA ON annonce (airport_depart_arriver_id)');
        $this->addSql('CREATE INDEX IDX_F65593E5A1E24203 ON annonce (date_retour_aller_id)');
        $this->addSql('CREATE INDEX IDX_F65593E519735D9D ON annonce (date_retour_arriver_id)');
        $this->addSql('CREATE INDEX IDX_F65593E5C4A5329B ON annonce (airport_retour_aller_id)');
        $this->addSql('CREATE INDEX IDX_F65593E5F0EE49F4 ON annonce (airport_retour_arriver_id)');
        $this->addSql('CREATE INDEX IDX_F65593E587A2E12 ON annonce (composition_id)');
        $this->addSql('CREATE INDEX IDX_F65593E519EB6921 ON annonce (client_id)');
        $this->addSql('CREATE TABLE city (id INT NOT NULL, country_id INT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_2D5B0234F92F3E70 ON city (country_id)');
        $this->addSql('CREATE TABLE compagny (id INT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE composition (id INT NOT NULL, nb_adult INT DEFAULT NULL, nb_child INT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE country (id INT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE date (id INT NOT NULL, date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE reset_password_request (id INT NOT NULL, user_id INT NOT NULL, selector VARCHAR(20) NOT NULL, hashed_token VARCHAR(100) NOT NULL, requested_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, expires_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_7CE748AA76ED395 ON reset_password_request (user_id)');
        $this->addSql('COMMENT ON COLUMN reset_password_request.requested_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN reset_password_request.expires_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE "user" (id INT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, is_verified BOOLEAN NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649E7927C74 ON "user" (email)');
        $this->addSql('CREATE TABLE messenger_messages (id BIGSERIAL NOT NULL, body TEXT NOT NULL, headers TEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, available_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, delivered_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_75EA56E0FB7336F0 ON messenger_messages (queue_name)');
        $this->addSql('CREATE INDEX IDX_75EA56E0E3BD61CE ON messenger_messages (available_at)');
        $this->addSql('CREATE INDEX IDX_75EA56E016BA31DB ON messenger_messages (delivered_at)');
        $this->addSql('CREATE OR REPLACE FUNCTION notify_messenger_messages() RETURNS TRIGGER AS $$
            BEGIN
                PERFORM pg_notify(\'messenger_messages\', NEW.queue_name::text);
                RETURN NEW;
            END;
        $$ LANGUAGE plpgsql;');
        $this->addSql('DROP TRIGGER IF EXISTS notify_trigger ON messenger_messages;');
        $this->addSql('CREATE TRIGGER notify_trigger AFTER INSERT OR UPDATE ON messenger_messages FOR EACH ROW EXECUTE PROCEDURE notify_messenger_messages();');
        $this->addSql('ALTER TABLE airport ADD CONSTRAINT FK_7E91F7C28BAC62AF FOREIGN KEY (city_id) REFERENCES city (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE annonce ADD CONSTRAINT FK_F65593E5CAD7D5F2 FOREIGN KEY (date_depart_aller_id) REFERENCES date (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE annonce ADD CONSTRAINT FK_F65593E57ABFE0B3 FOREIGN KEY (date_depart_arriver_id) REFERENCES date (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE annonce ADD CONSTRAINT FK_F65593E5AF90A56A FOREIGN KEY (airport_depart_aller_id) REFERENCES airport (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE annonce ADD CONSTRAINT FK_F65593E59322F4DA FOREIGN KEY (airport_depart_arriver_id) REFERENCES airport (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE annonce ADD CONSTRAINT FK_F65593E5A1E24203 FOREIGN KEY (date_retour_aller_id) REFERENCES date (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE annonce ADD CONSTRAINT FK_F65593E519735D9D FOREIGN KEY (date_retour_arriver_id) REFERENCES date (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE annonce ADD CONSTRAINT FK_F65593E5C4A5329B FOREIGN KEY (airport_retour_aller_id) REFERENCES airport (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE annonce ADD CONSTRAINT FK_F65593E5F0EE49F4 FOREIGN KEY (airport_retour_arriver_id) REFERENCES airport (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE annonce ADD CONSTRAINT FK_F65593E587A2E12 FOREIGN KEY (composition_id) REFERENCES composition (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE annonce ADD CONSTRAINT FK_F65593E519EB6921 FOREIGN KEY (client_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE city ADD CONSTRAINT FK_2D5B0234F92F3E70 FOREIGN KEY (country_id) REFERENCES country (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE reset_password_request ADD CONSTRAINT FK_7CE748AA76ED395 FOREIGN KEY (user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE airport_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE annonce_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE city_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE compagny_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE composition_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE country_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE date_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE reset_password_request_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE "user_id_seq" CASCADE');
        $this->addSql('ALTER TABLE airport DROP CONSTRAINT FK_7E91F7C28BAC62AF');
        $this->addSql('ALTER TABLE annonce DROP CONSTRAINT FK_F65593E5CAD7D5F2');
        $this->addSql('ALTER TABLE annonce DROP CONSTRAINT FK_F65593E57ABFE0B3');
        $this->addSql('ALTER TABLE annonce DROP CONSTRAINT FK_F65593E5AF90A56A');
        $this->addSql('ALTER TABLE annonce DROP CONSTRAINT FK_F65593E59322F4DA');
        $this->addSql('ALTER TABLE annonce DROP CONSTRAINT FK_F65593E5A1E24203');
        $this->addSql('ALTER TABLE annonce DROP CONSTRAINT FK_F65593E519735D9D');
        $this->addSql('ALTER TABLE annonce DROP CONSTRAINT FK_F65593E5C4A5329B');
        $this->addSql('ALTER TABLE annonce DROP CONSTRAINT FK_F65593E5F0EE49F4');
        $this->addSql('ALTER TABLE annonce DROP CONSTRAINT FK_F65593E587A2E12');
        $this->addSql('ALTER TABLE annonce DROP CONSTRAINT FK_F65593E519EB6921');
        $this->addSql('ALTER TABLE city DROP CONSTRAINT FK_2D5B0234F92F3E70');
        $this->addSql('ALTER TABLE reset_password_request DROP CONSTRAINT FK_7CE748AA76ED395');
        $this->addSql('DROP TABLE airport');
        $this->addSql('DROP TABLE annonce');
        $this->addSql('DROP TABLE city');
        $this->addSql('DROP TABLE compagny');
        $this->addSql('DROP TABLE composition');
        $this->addSql('DROP TABLE country');
        $this->addSql('DROP TABLE date');
        $this->addSql('DROP TABLE reset_password_request');
        $this->addSql('DROP TABLE "user"');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
