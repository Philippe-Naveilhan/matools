<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201103150305 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE competencestudent (id INT AUTO_INCREMENT NOT NULL, evalstudent_id INT NOT NULL, competence_id INT NOT NULL, note INT DEFAULT NULL, comment VARCHAR(255) DEFAULT NULL, INDEX IDX_7F32DAC2F3382E (evalstudent_id), INDEX IDX_7F32DAC15761DAB (competence_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE evalstudent (id INT AUTO_INCREMENT NOT NULL, student_id INT NOT NULL, evaluation_id INT NOT NULL, comment VARCHAR(255) DEFAULT NULL, INDEX IDX_57402E17CB944F1A (student_id), INDEX IDX_57402E17456C5646 (evaluation_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE evaluation (id INT AUTO_INCREMENT NOT NULL, teacher_id INT NOT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_1323A57541807E1D (teacher_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE competencestudent ADD CONSTRAINT FK_7F32DAC2F3382E FOREIGN KEY (evalstudent_id) REFERENCES evalstudent (id)');
        $this->addSql('ALTER TABLE competencestudent ADD CONSTRAINT FK_7F32DAC15761DAB FOREIGN KEY (competence_id) REFERENCES evalcompetence (id)');
        $this->addSql('ALTER TABLE evalstudent ADD CONSTRAINT FK_57402E17CB944F1A FOREIGN KEY (student_id) REFERENCES student (id)');
        $this->addSql('ALTER TABLE evalstudent ADD CONSTRAINT FK_57402E17456C5646 FOREIGN KEY (evaluation_id) REFERENCES evaluation (id)');
        $this->addSql('ALTER TABLE evaluation ADD CONSTRAINT FK_1323A57541807E1D FOREIGN KEY (teacher_id) REFERENCES user (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE competencestudent DROP FOREIGN KEY FK_7F32DAC2F3382E');
        $this->addSql('ALTER TABLE evalstudent DROP FOREIGN KEY FK_57402E17456C5646');
        $this->addSql('DROP TABLE competencestudent');
        $this->addSql('DROP TABLE evalstudent');
        $this->addSql('DROP TABLE evaluation');
    }
}
