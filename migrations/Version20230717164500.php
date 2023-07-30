<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230717164500 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE images DROP FOREIGN KEY FK_E01FBE6AA0EF1B80');
        $this->addSql('DROP INDEX IDX_E01FBE6AA0EF1B80 ON images');
        $this->addSql('ALTER TABLE images CHANGE car_id_id car_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE images ADD CONSTRAINT FK_E01FBE6AC3C6F69F FOREIGN KEY (car_id) REFERENCES cars (id)');
        $this->addSql('CREATE INDEX IDX_E01FBE6AC3C6F69F ON images (car_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE images DROP FOREIGN KEY FK_E01FBE6AC3C6F69F');
        $this->addSql('DROP INDEX IDX_E01FBE6AC3C6F69F ON images');
        $this->addSql('ALTER TABLE images CHANGE car_id car_id_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE images ADD CONSTRAINT FK_E01FBE6AA0EF1B80 FOREIGN KEY (car_id_id) REFERENCES cars (id)');
        $this->addSql('CREATE INDEX IDX_E01FBE6AA0EF1B80 ON images (car_id_id)');
    }
}
