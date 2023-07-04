<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230704212305 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE schedule ADD day VARCHAR(255) DEFAULT NULL, ADD open_time VARCHAR(255) DEFAULT NULL, ADD closed_time VARCHAR(255) DEFAULT NULL, DROP monday, DROP thuesday, DROP wednesday, DROP thursday, DROP friday, DROP saturday, DROP sunday');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE schedule ADD monday VARCHAR(255) DEFAULT NULL, ADD thuesday VARCHAR(255) DEFAULT NULL, ADD wednesday VARCHAR(255) DEFAULT NULL, ADD thursday VARCHAR(255) DEFAULT NULL, ADD friday VARCHAR(255) DEFAULT NULL, ADD saturday VARCHAR(255) DEFAULT NULL, ADD sunday VARCHAR(255) DEFAULT NULL, DROP day, DROP open_time, DROP closed_time');
    }
}
