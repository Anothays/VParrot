<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230731085922 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE photos CHANGE modified_at modified_at DATETIME on update CURRENT_TIMESTAMP');
        $this->addSql('ALTER TABLE services CHANGE modified_at modified_at DATETIME on update CURRENT_TIMESTAMP');
        $this->addSql('ALTER TABLE testimonials CHANGE modified_at modified_at DATETIME on update CURRENT_TIMESTAMP');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE photos CHANGE modified_at modified_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE services CHANGE modified_at modified_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE testimonials CHANGE modified_at modified_at DATETIME DEFAULT NULL');
    }
}