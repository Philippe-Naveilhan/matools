<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201116204335 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE evalcompetence ADD evaluation_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE evalcompetence ADD CONSTRAINT FK_5DB31F4B456C5646 FOREIGN KEY (evaluation_id) REFERENCES evaluation (id)');
        $this->addSql('CREATE INDEX IDX_5DB31F4B456C5646 ON evalcompetence (evaluation_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE evalcompetence DROP FOREIGN KEY FK_5DB31F4B456C5646');
        $this->addSql('DROP INDEX IDX_5DB31F4B456C5646 ON evalcompetence');
        $this->addSql('ALTER TABLE evalcompetence DROP evaluation_id');
    }
}
