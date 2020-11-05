<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201103151620 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE evaluation_evalcompetence (evaluation_id INT NOT NULL, evalcompetence_id INT NOT NULL, INDEX IDX_B97C783456C5646 (evaluation_id), INDEX IDX_B97C78385BC4BE4 (evalcompetence_id), PRIMARY KEY(evaluation_id, evalcompetence_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE evaluation_evalcompetence ADD CONSTRAINT FK_B97C783456C5646 FOREIGN KEY (evaluation_id) REFERENCES evaluation (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE evaluation_evalcompetence ADD CONSTRAINT FK_B97C78385BC4BE4 FOREIGN KEY (evalcompetence_id) REFERENCES evalcompetence (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE evaluation_evalcompetence');
    }
}
