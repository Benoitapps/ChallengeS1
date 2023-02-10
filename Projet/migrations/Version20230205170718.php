<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230205170718 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE annonce_user (annonce_id INT NOT NULL, user_id INT NOT NULL, PRIMARY KEY(annonce_id, user_id))');
        $this->addSql('CREATE INDEX IDX_B7E60AD78805AB2F ON annonce_user (annonce_id)');
        $this->addSql('CREATE INDEX IDX_B7E60AD7A76ED395 ON annonce_user (user_id)');
        $this->addSql('ALTER TABLE annonce_user ADD CONSTRAINT FK_B7E60AD78805AB2F FOREIGN KEY (annonce_id) REFERENCES annonce (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE annonce_user ADD CONSTRAINT FK_B7E60AD7A76ED395 FOREIGN KEY (user_id) REFERENCES "user" (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE annonce DROP CONSTRAINT fk_f65593e587a2e12');
        $this->addSql('DROP INDEX idx_f65593e587a2e12');
        $this->addSql('ALTER TABLE annonce DROP composition_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE annonce_user DROP CONSTRAINT FK_B7E60AD78805AB2F');
        $this->addSql('ALTER TABLE annonce_user DROP CONSTRAINT FK_B7E60AD7A76ED395');
        $this->addSql('DROP TABLE annonce_user');
        $this->addSql('ALTER TABLE annonce ADD composition_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE annonce ADD CONSTRAINT fk_f65593e587a2e12 FOREIGN KEY (composition_id) REFERENCES composition (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_f65593e587a2e12 ON annonce (composition_id)');
    }
}
