<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230704192113 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE schedule CHANGE monday monday VARCHAR(255) DEFAULT NULL, CHANGE thuesday thuesday VARCHAR(255) DEFAULT NULL, CHANGE wednesday wednesday VARCHAR(255) DEFAULT NULL, CHANGE thursday thursday VARCHAR(255) DEFAULT NULL, CHANGE friday friday VARCHAR(255) DEFAULT NULL, CHANGE saturday saturday VARCHAR(255) DEFAULT NULL, CHANGE sunday sunday VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE schedule CHANGE monday monday LONGTEXT DEFAULT NULL, CHANGE thuesday thuesday LONGTEXT DEFAULT NULL, CHANGE wednesday wednesday LONGTEXT DEFAULT NULL, CHANGE thursday thursday LONGTEXT DEFAULT NULL, CHANGE friday friday LONGTEXT DEFAULT NULL, CHANGE saturday saturday LONGTEXT DEFAULT NULL, CHANGE sunday sunday LONGTEXT DEFAULT NULL');
    }
}
