<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190715184534 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE platform (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) NOT NULL, icon VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user CHANGE cv_filename cv_filename VARCHAR(50) DEFAULT NULL');
        $this->addSql('ALTER TABLE job ADD platform_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE job ADD CONSTRAINT FK_FBD8E0F8FFE6496F FOREIGN KEY (platform_id) REFERENCES platform (id)');
        $this->addSql('CREATE INDEX IDX_FBD8E0F8FFE6496F ON job (platform_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE job DROP FOREIGN KEY FK_FBD8E0F8FFE6496F');
        $this->addSql('DROP TABLE platform');
        $this->addSql('DROP INDEX IDX_FBD8E0F8FFE6496F ON job');
        $this->addSql('ALTER TABLE job DROP platform_id');
        $this->addSql('ALTER TABLE user CHANGE cv_filename cv_filename VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci');
    }
}
