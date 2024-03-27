<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240327125133 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user_album_format (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, album_id INT NOT NULL, format_id INT NOT NULL, INDEX IDX_8C0D336AA76ED395 (user_id), INDEX IDX_8C0D336A1137ABCF (album_id), INDEX IDX_8C0D336AD629F605 (format_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user_album_format ADD CONSTRAINT FK_8C0D336AA76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE user_album_format ADD CONSTRAINT FK_8C0D336A1137ABCF FOREIGN KEY (album_id) REFERENCES albums (id)');
        $this->addSql('ALTER TABLE user_album_format ADD CONSTRAINT FK_8C0D336AD629F605 FOREIGN KEY (format_id) REFERENCES formats (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user_album_format DROP FOREIGN KEY FK_8C0D336AA76ED395');
        $this->addSql('ALTER TABLE user_album_format DROP FOREIGN KEY FK_8C0D336A1137ABCF');
        $this->addSql('ALTER TABLE user_album_format DROP FOREIGN KEY FK_8C0D336AD629F605');
        $this->addSql('DROP TABLE user_album_format');
    }
}
