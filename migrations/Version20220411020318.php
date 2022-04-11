<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220411020318 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE destination (id CHAR(36) NOT NULL, name VARCHAR(128) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE export (id CHAR(36) NOT NULL, destination_id CHAR(36) DEFAULT NULL, created_by_id CHAR(36) DEFAULT NULL, name VARCHAR(128) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_428C1694816C6140 ON export (destination_id)');
        $this->addSql('CREATE INDEX IDX_428C1694B03A8386 ON export (created_by_id)');
        $this->addSql('CREATE INDEX IDX_428C16948B8E8428 ON export (created_at)');
        $this->addSql('COMMENT ON COLUMN export.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE "user" (id CHAR(36) NOT NULL, name VARCHAR(128) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE export ADD CONSTRAINT FK_428C1694816C6140 FOREIGN KEY (destination_id) REFERENCES destination (id) ON DELETE SET NULL NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE export ADD CONSTRAINT FK_428C1694B03A8386 FOREIGN KEY (created_by_id) REFERENCES "user" (id) ON DELETE SET NULL NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE export DROP CONSTRAINT FK_428C1694816C6140');
        $this->addSql('ALTER TABLE export DROP CONSTRAINT FK_428C1694B03A8386');
        $this->addSql('DROP TABLE destination');
        $this->addSql('DROP TABLE export');
        $this->addSql('DROP TABLE "user"');
    }
}
