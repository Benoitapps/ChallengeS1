<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230112094810 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE date_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE date (id INT NOT NULL, start_date DATE NOT NULL, end_date DATE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE date_reservation (date_id INT NOT NULL, reservation_id INT NOT NULL, PRIMARY KEY(date_id, reservation_id))');
        $this->addSql('CREATE INDEX IDX_7DB17C89B897366B ON date_reservation (date_id)');
        $this->addSql('CREATE INDEX IDX_7DB17C89B83297E7 ON date_reservation (reservation_id)');
        $this->addSql('ALTER TABLE date_reservation ADD CONSTRAINT FK_7DB17C89B897366B FOREIGN KEY (date_id) REFERENCES date (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE date_reservation ADD CONSTRAINT FK_7DB17C89B83297E7 FOREIGN KEY (reservation_id) REFERENCES reservation (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE date_id_seq CASCADE');
        $this->addSql('ALTER TABLE date_reservation DROP CONSTRAINT FK_7DB17C89B897366B');
        $this->addSql('ALTER TABLE date_reservation DROP CONSTRAINT FK_7DB17C89B83297E7');
        $this->addSql('DROP TABLE date');
        $this->addSql('DROP TABLE date_reservation');
    }
}
