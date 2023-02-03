<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230203192516 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE payment_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE payment (id INT NOT NULL, payeur_id INT DEFAULT NULL, num_carte INT NOT NULL, expiration DATE NOT NULL, cvv INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_6D28840D422667C5 ON payment (payeur_id)');
        $this->addSql('ALTER TABLE payment ADD CONSTRAINT FK_6D28840D422667C5 FOREIGN KEY (payeur_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE payment_id_seq CASCADE');
        $this->addSql('ALTER TABLE payment DROP CONSTRAINT FK_6D28840D422667C5');
        $this->addSql('DROP TABLE payment');
    }
}
