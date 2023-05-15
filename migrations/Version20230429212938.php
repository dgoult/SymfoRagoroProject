<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230429212938 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commentaire_cours ADD author_id INT NOT NULL, CHANGE date_creation date_creation DATETIME NOT NULL');
        $this->addSql('ALTER TABLE commentaire_cours ADD CONSTRAINT FK_78464480F675F31B FOREIGN KEY (author_id) REFERENCES user (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_78464480F675F31B ON commentaire_cours (author_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commentaire_cours DROP FOREIGN KEY FK_78464480F675F31B');
        $this->addSql('DROP INDEX UNIQ_78464480F675F31B ON commentaire_cours');
        $this->addSql('ALTER TABLE commentaire_cours DROP author_id, CHANGE date_creation date_creation DATETIME DEFAULT NULL');
    }
}
