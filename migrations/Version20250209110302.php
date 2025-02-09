<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250209110302 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE joueur_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE joueur (id INT NOT NULL, user_id INT DEFAULT NULL, firstname VARCHAR(255) NOT NULL, lastname VARCHAR(255) NOT NULL, phone_number INT NOT NULL, birthdate DATE NOT NULL, numero_maillot INT NOT NULL, position VARCHAR(255) NOT NULL, salaire DOUBLE PRECISION NOT NULL, date_affectation DATE NOT NULL, date_fin_contrat DATE DEFAULT NULL, nb_carton_jaune INT DEFAULT NULL, nb_carton_rouge INT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_FD71A9C5A76ED395 ON joueur (user_id)');
        $this->addSql('ALTER TABLE joueur ADD CONSTRAINT FK_FD71A9C5A76ED395 FOREIGN KEY (user_id) REFERENCES "users" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE joueur_id_seq CASCADE');
        $this->addSql('ALTER TABLE joueur DROP CONSTRAINT FK_FD71A9C5A76ED395');
        $this->addSql('DROP TABLE joueur');
    }
}
