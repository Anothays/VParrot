<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230704213233 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE schedule ADD open_morning_time VARCHAR(255) DEFAULT NULL, ADD open_afternoon_time VARCHAR(255) DEFAULT NULL, DROP open_time, DROP closed_time');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE schedule ADD open_time VARCHAR(255) DEFAULT NULL, ADD closed_time VARCHAR(255) DEFAULT NULL, DROP open_morning_time, DROP open_afternoon_time');
    }
}
