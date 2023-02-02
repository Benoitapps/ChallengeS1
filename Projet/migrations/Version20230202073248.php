<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230202073248 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE annonce DROP CONSTRAINT fk_f65593e5cad7d5f2');
        $this->addSql('ALTER TABLE annonce DROP CONSTRAINT fk_f65593e57abfe0b3');
        $this->addSql('ALTER TABLE annonce DROP CONSTRAINT fk_f65593e5a1e24203');
        $this->addSql('ALTER TABLE annonce DROP CONSTRAINT fk_f65593e519735d9d');
        $this->addSql('DROP INDEX idx_f65593e519735d9d');
        $this->addSql('DROP INDEX idx_f65593e5a1e24203');
        $this->addSql('DROP INDEX idx_f65593e57abfe0b3');
        $this->addSql('DROP INDEX idx_f65593e5cad7d5f2');
        $this->addSql('ALTER TABLE annonce ADD date_depart_aller VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE annonce ADD date_depart_arriver VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE annonce ADD date_retour_aller VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE annonce ADD date_retour_arriver VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE annonce DROP date_depart_aller_id');
        $this->addSql('ALTER TABLE annonce DROP date_depart_arriver_id');
        $this->addSql('ALTER TABLE annonce DROP date_retour_aller_id');
        $this->addSql('ALTER TABLE annonce DROP date_retour_arriver_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE annonce ADD date_depart_aller_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE annonce ADD date_depart_arriver_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE annonce ADD date_retour_aller_id INT NOT NULL');
        $this->addSql('ALTER TABLE annonce ADD date_retour_arriver_id INT NOT NULL');
        $this->addSql('ALTER TABLE annonce DROP date_depart_aller');
        $this->addSql('ALTER TABLE annonce DROP date_depart_arriver');
        $this->addSql('ALTER TABLE annonce DROP date_retour_aller');
        $this->addSql('ALTER TABLE annonce DROP date_retour_arriver');
        $this->addSql('ALTER TABLE annonce ADD CONSTRAINT fk_f65593e5cad7d5f2 FOREIGN KEY (date_depart_aller_id) REFERENCES date (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE annonce ADD CONSTRAINT fk_f65593e57abfe0b3 FOREIGN KEY (date_depart_arriver_id) REFERENCES date (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE annonce ADD CONSTRAINT fk_f65593e5a1e24203 FOREIGN KEY (date_retour_aller_id) REFERENCES date (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE annonce ADD CONSTRAINT fk_f65593e519735d9d FOREIGN KEY (date_retour_arriver_id) REFERENCES date (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_f65593e519735d9d ON annonce (date_retour_arriver_id)');
        $this->addSql('CREATE INDEX idx_f65593e5a1e24203 ON annonce (date_retour_aller_id)');
        $this->addSql('CREATE INDEX idx_f65593e57abfe0b3 ON annonce (date_depart_arriver_id)');
        $this->addSql('CREATE INDEX idx_f65593e5cad7d5f2 ON annonce (date_depart_aller_id)');
    }
}
