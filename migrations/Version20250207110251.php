<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250207110251 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX idx_1bda53c6a76ed395');
        $this->addSql('ALTER TABLE medecin ALTER user_id SET NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1BDA53C6A76ED395 ON medecin (user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP INDEX UNIQ_1BDA53C6A76ED395');
        $this->addSql('ALTER TABLE medecin ALTER user_id DROP NOT NULL');
        $this->addSql('CREATE INDEX idx_1bda53c6a76ed395 ON medecin (user_id)');
    }
}
