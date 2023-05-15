<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230515075732 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commentaire_cours DROP INDEX UNIQ_78464480F675F31B, ADD INDEX IDX_78464480F675F31B (author_id)');
        $this->addSql('ALTER TABLE matiere DROP FOREIGN KEY FK_9014574ADE94FEFF');
        $this->addSql('DROP INDEX IDX_9014574ADE94FEFF ON matiere');
        $this->addSql('ALTER TABLE matiere ADD couleur_calendrier VARCHAR(255) DEFAULT NULL, DROP intervenant_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commentaire_cours DROP INDEX IDX_78464480F675F31B, ADD UNIQUE INDEX UNIQ_78464480F675F31B (author_id)');
        $this->addSql('ALTER TABLE matiere ADD intervenant_id INT DEFAULT NULL, DROP couleur_calendrier');
        $this->addSql('ALTER TABLE matiere ADD CONSTRAINT FK_9014574ADE94FEFF FOREIGN KEY (intervenant_id) REFERENCES intervenant (id)');
        $this->addSql('CREATE INDEX IDX_9014574ADE94FEFF ON matiere (intervenant_id)');
    }
}
