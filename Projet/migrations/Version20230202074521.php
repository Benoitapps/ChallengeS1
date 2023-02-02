<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230202074521 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE annonce ALTER date_depart_aller TYPE TIMESTAMP(0) WITHOUT TIME ZONE');
        $this->addSql('ALTER TABLE annonce ALTER date_depart_arriver TYPE TIMESTAMP(0) WITHOUT TIME ZONE');
        $this->addSql('ALTER TABLE annonce ALTER date_retour_aller TYPE TIMESTAMP(0) WITHOUT TIME ZONE');
        $this->addSql('ALTER TABLE annonce ALTER date_retour_arriver TYPE TIMESTAMP(0) WITHOUT TIME ZONE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE annonce ALTER date_depart_aller TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE annonce ALTER date_depart_arriver TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE annonce ALTER date_retour_aller TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE annonce ALTER date_retour_arriver TYPE VARCHAR(255)');
    }
}
