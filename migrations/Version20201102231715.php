<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201102231715 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE circo (id INT AUTO_INCREMENT NOT NULL, district_id INT NOT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_9A36BA9AB08FA272 (district_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE evalbloc (id INT AUTO_INCREMENT NOT NULL, category_id INT NOT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_BC7985212469DE2 (category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE evalcategory (id INT AUTO_INCREMENT NOT NULL, theme_id INT NOT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_3AAF9E9159027487 (theme_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE evalcompetence (id INT AUTO_INCREMENT NOT NULL, bloc_id INT NOT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_5DB31F4B5582E9C0 (bloc_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE evaltheme (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE circo ADD CONSTRAINT FK_9A36BA9AB08FA272 FOREIGN KEY (district_id) REFERENCES district (id)');
        $this->addSql('ALTER TABLE evalbloc ADD CONSTRAINT FK_BC7985212469DE2 FOREIGN KEY (category_id) REFERENCES evalcategory (id)');
        $this->addSql('ALTER TABLE evalcategory ADD CONSTRAINT FK_3AAF9E9159027487 FOREIGN KEY (theme_id) REFERENCES evaltheme (id)');
        $this->addSql('ALTER TABLE evalcompetence ADD CONSTRAINT FK_5DB31F4B5582E9C0 FOREIGN KEY (bloc_id) REFERENCES evalbloc (id)');
        $this->addSql('ALTER TABLE school DROP FOREIGN KEY FK_F99EDABBB08FA272');
        $this->addSql('DROP INDEX IDX_F99EDABBB08FA272 ON school');
        $this->addSql('ALTER TABLE school CHANGE district_id circo_id INT NOT NULL');
        $this->addSql('ALTER TABLE school ADD CONSTRAINT FK_F99EDABB47552B27 FOREIGN KEY (circo_id) REFERENCES circo (id)');
        $this->addSql('CREATE INDEX IDX_F99EDABB47552B27 ON school (circo_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE school DROP FOREIGN KEY FK_F99EDABB47552B27');
        $this->addSql('ALTER TABLE evalcompetence DROP FOREIGN KEY FK_5DB31F4B5582E9C0');
        $this->addSql('ALTER TABLE evalbloc DROP FOREIGN KEY FK_BC7985212469DE2');
        $this->addSql('ALTER TABLE evalcategory DROP FOREIGN KEY FK_3AAF9E9159027487');
        $this->addSql('DROP TABLE circo');
        $this->addSql('DROP TABLE evalbloc');
        $this->addSql('DROP TABLE evalcategory');
        $this->addSql('DROP TABLE evalcompetence');
        $this->addSql('DROP TABLE evaltheme');
        $this->addSql('DROP INDEX IDX_F99EDABB47552B27 ON school');
        $this->addSql('ALTER TABLE school CHANGE circo_id district_id INT NOT NULL');
        $this->addSql('ALTER TABLE school ADD CONSTRAINT FK_F99EDABBB08FA272 FOREIGN KEY (district_id) REFERENCES district (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_F99EDABBB08FA272 ON school (district_id)');
    }
}
