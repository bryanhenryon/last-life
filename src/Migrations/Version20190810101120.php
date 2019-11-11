<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190810101120 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE article CHANGE date_time_publication date_time_publication DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE membre ADD password VARCHAR(300) NOT NULL, ADD role VARCHAR(60) NOT NULL, ADD salt VARCHAR(60) DEFAULT NULL, DROP mdp, CHANGE pseudo username VARCHAR(20) NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE article CHANGE date_time_publication date_time_publication DATETIME NOT NULL');
        $this->addSql('ALTER TABLE membre ADD mdp VARCHAR(50) NOT NULL COLLATE utf8mb4_unicode_ci, DROP password, DROP role, DROP salt, CHANGE username pseudo VARCHAR(20) NOT NULL COLLATE utf8mb4_unicode_ci');
    }
}
