<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230216195659 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE matiere ADD couleur_calendrier VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE matiere RENAME INDEX idx_9014574ade94feff TO IDX_9014574AAB9A1716');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE matiere DROP couleur_calendrier');
        $this->addSql('ALTER TABLE matiere RENAME INDEX idx_9014574aab9a1716 TO IDX_9014574ADE94FEFF');
    }
}
