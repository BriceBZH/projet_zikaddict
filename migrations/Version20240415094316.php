<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240415094316 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE artists (id INT AUTO_INCREMENT NOT NULL, media_id INT NOT NULL, country_id INT NOT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, birth_date DATETIME NOT NULL, death_date DATE DEFAULT NULL COMMENT \'(DC2Type:date_immutable)\', INDEX IDX_68D3801EEA9FDD75 (media_id), INDEX IDX_68D3801EF92F3E70 (country_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE artists ADD CONSTRAINT FK_68D3801EEA9FDD75 FOREIGN KEY (media_id) REFERENCES medias (id)');
        $this->addSql('ALTER TABLE artists ADD CONSTRAINT FK_68D3801EF92F3E70 FOREIGN KEY (country_id) REFERENCES countries (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE artist_album DROP FOREIGN KEY FK_59945E10B7970CF8');
        $this->addSql('ALTER TABLE artist_song DROP FOREIGN KEY FK_8F53683EB7970CF8');
        $this->addSql('ALTER TABLE artists DROP FOREIGN KEY FK_68D3801EEA9FDD75');
        $this->addSql('ALTER TABLE artists DROP FOREIGN KEY FK_68D3801EF92F3E70');
        $this->addSql('DROP TABLE artists');
    }
}
