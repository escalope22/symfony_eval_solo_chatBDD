<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221207213546 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE chaton_proprietaire ADD CONSTRAINT FK_7060315F640066C9 FOREIGN KEY (chaton_id) REFERENCES chaton (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE chaton_proprietaire ADD CONSTRAINT FK_7060315F76C50E4A FOREIGN KEY (proprietaire_id) REFERENCES proprietaire (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE proprietaire ADD prenom VARCHAR(50) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE chaton_proprietaire DROP FOREIGN KEY FK_7060315F640066C9');
        $this->addSql('ALTER TABLE chaton_proprietaire DROP FOREIGN KEY FK_7060315F76C50E4A');
        $this->addSql('ALTER TABLE proprietaire DROP prenom');
    }
}
