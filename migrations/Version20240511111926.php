<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240511111926 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE albums (id INT AUTO_INCREMENT NOT NULL, media_id INT NOT NULL, title VARCHAR(255) NOT NULL, year INT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', update_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', valid TINYINT(1) NOT NULL, INDEX IDX_F4E2474FEA9FDD75 (media_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE album_song (album_id INT NOT NULL, song_id INT NOT NULL, INDEX IDX_57E658E11137ABCF (album_id), INDEX IDX_57E658E1A0BDB2F3 (song_id), PRIMARY KEY(album_id, song_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE album_format (album_id INT NOT NULL, format_id INT NOT NULL, INDEX IDX_CC14F681137ABCF (album_id), INDEX IDX_CC14F68D629F605 (format_id), PRIMARY KEY(album_id, format_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE artists (id INT AUTO_INCREMENT NOT NULL, media_id INT NOT NULL, country_id INT NOT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, birth_date DATETIME NOT NULL, death_date DATETIME DEFAULT NULL, valid TINYINT(1) NOT NULL, INDEX IDX_68D3801EEA9FDD75 (media_id), INDEX IDX_68D3801EF92F3E70 (country_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE artist_album (artist_id INT NOT NULL, album_id INT NOT NULL, INDEX IDX_59945E10B7970CF8 (artist_id), INDEX IDX_59945E101137ABCF (album_id), PRIMARY KEY(artist_id, album_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE artist_song (artist_id INT NOT NULL, song_id INT NOT NULL, INDEX IDX_8F53683EB7970CF8 (artist_id), INDEX IDX_8F53683EA0BDB2F3 (song_id), PRIMARY KEY(artist_id, song_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE countries (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE formats (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE genres (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE medias (id INT AUTO_INCREMENT NOT NULL, url VARCHAR(255) NOT NULL, alt VARCHAR(255) NOT NULL, url_source VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE songs (id INT AUTO_INCREMENT NOT NULL, genre_id INT NOT NULL, title VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, duration INT NOT NULL, valid TINYINT(1) NOT NULL, INDEX IDX_BAECB19B4296D31F (genre_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_album_format (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, album_id INT NOT NULL, format_id INT NOT NULL, type VARCHAR(255) NOT NULL, INDEX IDX_8C0D336AA76ED395 (user_id), INDEX IDX_8C0D336A1137ABCF (album_id), INDEX IDX_8C0D336AD629F605 (format_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE users (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(255) NOT NULL, roles JSON NOT NULL COMMENT \'(DC2Type:json)\', email VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', is_verified TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE albums ADD CONSTRAINT FK_F4E2474FEA9FDD75 FOREIGN KEY (media_id) REFERENCES medias (id)');
        $this->addSql('ALTER TABLE album_song ADD CONSTRAINT FK_57E658E11137ABCF FOREIGN KEY (album_id) REFERENCES albums (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE album_song ADD CONSTRAINT FK_57E658E1A0BDB2F3 FOREIGN KEY (song_id) REFERENCES songs (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE album_format ADD CONSTRAINT FK_CC14F681137ABCF FOREIGN KEY (album_id) REFERENCES albums (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE album_format ADD CONSTRAINT FK_CC14F68D629F605 FOREIGN KEY (format_id) REFERENCES formats (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE artists ADD CONSTRAINT FK_68D3801EEA9FDD75 FOREIGN KEY (media_id) REFERENCES medias (id)');
        $this->addSql('ALTER TABLE artists ADD CONSTRAINT FK_68D3801EF92F3E70 FOREIGN KEY (country_id) REFERENCES countries (id)');
        $this->addSql('ALTER TABLE artist_album ADD CONSTRAINT FK_59945E10B7970CF8 FOREIGN KEY (artist_id) REFERENCES artists (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE artist_album ADD CONSTRAINT FK_59945E101137ABCF FOREIGN KEY (album_id) REFERENCES albums (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE artist_song ADD CONSTRAINT FK_8F53683EB7970CF8 FOREIGN KEY (artist_id) REFERENCES artists (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE artist_song ADD CONSTRAINT FK_8F53683EA0BDB2F3 FOREIGN KEY (song_id) REFERENCES songs (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE songs ADD CONSTRAINT FK_BAECB19B4296D31F FOREIGN KEY (genre_id) REFERENCES genres (id)');
        $this->addSql('ALTER TABLE user_album_format ADD CONSTRAINT FK_8C0D336AA76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE user_album_format ADD CONSTRAINT FK_8C0D336A1137ABCF FOREIGN KEY (album_id) REFERENCES albums (id)');
        $this->addSql('ALTER TABLE user_album_format ADD CONSTRAINT FK_8C0D336AD629F605 FOREIGN KEY (format_id) REFERENCES formats (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE albums DROP FOREIGN KEY FK_F4E2474FEA9FDD75');
        $this->addSql('ALTER TABLE album_song DROP FOREIGN KEY FK_57E658E11137ABCF');
        $this->addSql('ALTER TABLE album_song DROP FOREIGN KEY FK_57E658E1A0BDB2F3');
        $this->addSql('ALTER TABLE album_format DROP FOREIGN KEY FK_CC14F681137ABCF');
        $this->addSql('ALTER TABLE album_format DROP FOREIGN KEY FK_CC14F68D629F605');
        $this->addSql('ALTER TABLE artists DROP FOREIGN KEY FK_68D3801EEA9FDD75');
        $this->addSql('ALTER TABLE artists DROP FOREIGN KEY FK_68D3801EF92F3E70');
        $this->addSql('ALTER TABLE artist_album DROP FOREIGN KEY FK_59945E10B7970CF8');
        $this->addSql('ALTER TABLE artist_album DROP FOREIGN KEY FK_59945E101137ABCF');
        $this->addSql('ALTER TABLE artist_song DROP FOREIGN KEY FK_8F53683EB7970CF8');
        $this->addSql('ALTER TABLE artist_song DROP FOREIGN KEY FK_8F53683EA0BDB2F3');
        $this->addSql('ALTER TABLE songs DROP FOREIGN KEY FK_BAECB19B4296D31F');
        $this->addSql('ALTER TABLE user_album_format DROP FOREIGN KEY FK_8C0D336AA76ED395');
        $this->addSql('ALTER TABLE user_album_format DROP FOREIGN KEY FK_8C0D336A1137ABCF');
        $this->addSql('ALTER TABLE user_album_format DROP FOREIGN KEY FK_8C0D336AD629F605');
        $this->addSql('DROP TABLE albums');
        $this->addSql('DROP TABLE album_song');
        $this->addSql('DROP TABLE album_format');
        $this->addSql('DROP TABLE artists');
        $this->addSql('DROP TABLE artist_album');
        $this->addSql('DROP TABLE artist_song');
        $this->addSql('DROP TABLE countries');
        $this->addSql('DROP TABLE formats');
        $this->addSql('DROP TABLE genres');
        $this->addSql('DROP TABLE medias');
        $this->addSql('DROP TABLE songs');
        $this->addSql('DROP TABLE user_album_format');
        $this->addSql('DROP TABLE users');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
