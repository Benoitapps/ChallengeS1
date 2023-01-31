<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230131140714 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE date ADD start_date DATE NOT NULL');
        $this->addSql('ALTER TABLE date ADD end_date DATE NOT NULL');
        $this->addSql('ALTER TABLE date DROP startdate');
        $this->addSql('ALTER TABLE date DROP enddate');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE date ADD startdate DATE NOT NULL');
        $this->addSql('ALTER TABLE date ADD enddate DATE NOT NULL');
        $this->addSql('ALTER TABLE date DROP start_date');
        $this->addSql('ALTER TABLE date DROP end_date');
    }
}
