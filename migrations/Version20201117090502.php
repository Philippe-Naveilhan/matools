<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201117090502 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE evaluation ADD level_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE evaluation ADD CONSTRAINT FK_1323A5755FB14BA7 FOREIGN KEY (level_id) REFERENCES level (id)');
        $this->addSql('CREATE INDEX IDX_1323A5755FB14BA7 ON evaluation (level_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE evaluation DROP FOREIGN KEY FK_1323A5755FB14BA7');
        $this->addSql('DROP INDEX IDX_1323A5755FB14BA7 ON evaluation');
        $this->addSql('ALTER TABLE evaluation DROP level_id');
    }
}
