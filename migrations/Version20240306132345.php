<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240306132345 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE albums DROP FOREIGN KEY FK_F4E2474F605D5AE6');
        $this->addSql('DROP INDEX IDX_F4E2474F605D5AE6 ON albums');
        $this->addSql('ALTER TABLE albums CHANGE media_id_id media_id INT NOT NULL');
        $this->addSql('ALTER TABLE albums ADD CONSTRAINT FK_F4E2474FEA9FDD75 FOREIGN KEY (media_id) REFERENCES medias (id)');
        $this->addSql('CREATE INDEX IDX_F4E2474FEA9FDD75 ON albums (media_id)');
        $this->addSql('ALTER TABLE songs DROP FOREIGN KEY FK_BAECB19BC2428192');
        $this->addSql('DROP INDEX IDX_BAECB19BC2428192 ON songs');
        $this->addSql('ALTER TABLE songs CHANGE genre_id_id genre_id INT NOT NULL');
        $this->addSql('ALTER TABLE songs ADD CONSTRAINT FK_BAECB19B4296D31F FOREIGN KEY (genre_id) REFERENCES genres (id)');
        $this->addSql('CREATE INDEX IDX_BAECB19B4296D31F ON songs (genre_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE albums DROP FOREIGN KEY FK_F4E2474FEA9FDD75');
        $this->addSql('DROP INDEX IDX_F4E2474FEA9FDD75 ON albums');
        $this->addSql('ALTER TABLE albums CHANGE media_id media_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE albums ADD CONSTRAINT FK_F4E2474F605D5AE6 FOREIGN KEY (media_id_id) REFERENCES medias (id)');
        $this->addSql('CREATE INDEX IDX_F4E2474F605D5AE6 ON albums (media_id_id)');
        $this->addSql('ALTER TABLE songs DROP FOREIGN KEY FK_BAECB19B4296D31F');
        $this->addSql('DROP INDEX IDX_BAECB19B4296D31F ON songs');
        $this->addSql('ALTER TABLE songs CHANGE genre_id genre_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE songs ADD CONSTRAINT FK_BAECB19BC2428192 FOREIGN KEY (genre_id_id) REFERENCES genres (id)');
        $this->addSql('CREATE INDEX IDX_BAECB19BC2428192 ON songs (genre_id_id)');
    }
}
