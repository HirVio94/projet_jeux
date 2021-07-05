<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210705094616 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE classifications (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE developpeurs (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE genres (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE jeux (id INT AUTO_INCREMENT NOT NULL, developpeur_id INT DEFAULT NULL, classification_id INT DEFAULT NULL, titre VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, video_path VARCHAR(255) DEFAULT NULL, couverture_path VARCHAR(255) DEFAULT NULL, date_sortie DATE NOT NULL, INDEX IDX_3755B50D84E66085 (developpeur_id), INDEX IDX_3755B50D2A86559F (classification_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE jeux_genres (jeux_id INT NOT NULL, genres_id INT NOT NULL, INDEX IDX_E7076130EC2AA9D2 (jeux_id), INDEX IDX_E70761306A3B2603 (genres_id), PRIMARY KEY(jeux_id, genres_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE jeux_plate_formes (jeux_id INT NOT NULL, plate_formes_id INT NOT NULL, INDEX IDX_3C21CEADEC2AA9D2 (jeux_id), INDEX IDX_3C21CEADB265E572 (plate_formes_id), PRIMARY KEY(jeux_id, plate_formes_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE plate_formes (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE jeux ADD CONSTRAINT FK_3755B50D84E66085 FOREIGN KEY (developpeur_id) REFERENCES developpeurs (id)');
        $this->addSql('ALTER TABLE jeux ADD CONSTRAINT FK_3755B50D2A86559F FOREIGN KEY (classification_id) REFERENCES classifications (id)');
        $this->addSql('ALTER TABLE jeux_genres ADD CONSTRAINT FK_E7076130EC2AA9D2 FOREIGN KEY (jeux_id) REFERENCES jeux (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE jeux_genres ADD CONSTRAINT FK_E70761306A3B2603 FOREIGN KEY (genres_id) REFERENCES genres (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE jeux_plate_formes ADD CONSTRAINT FK_3C21CEADEC2AA9D2 FOREIGN KEY (jeux_id) REFERENCES jeux (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE jeux_plate_formes ADD CONSTRAINT FK_3C21CEADB265E572 FOREIGN KEY (plate_formes_id) REFERENCES plate_formes (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE jeux DROP FOREIGN KEY FK_3755B50D2A86559F');
        $this->addSql('ALTER TABLE jeux DROP FOREIGN KEY FK_3755B50D84E66085');
        $this->addSql('ALTER TABLE jeux_genres DROP FOREIGN KEY FK_E70761306A3B2603');
        $this->addSql('ALTER TABLE jeux_genres DROP FOREIGN KEY FK_E7076130EC2AA9D2');
        $this->addSql('ALTER TABLE jeux_plate_formes DROP FOREIGN KEY FK_3C21CEADEC2AA9D2');
        $this->addSql('ALTER TABLE jeux_plate_formes DROP FOREIGN KEY FK_3C21CEADB265E572');
        $this->addSql('DROP TABLE classifications');
        $this->addSql('DROP TABLE developpeurs');
        $this->addSql('DROP TABLE genres');
        $this->addSql('DROP TABLE jeux');
        $this->addSql('DROP TABLE jeux_genres');
        $this->addSql('DROP TABLE jeux_plate_formes');
        $this->addSql('DROP TABLE plate_formes');
    }
}
