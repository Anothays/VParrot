<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230801225946 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cars DROP FOREIGN KEY FK_95C71D142B8541DC');
        $this->addSql('ALTER TABLE car_models DROP FOREIGN KEY FK_FCBEDCFB522C4A1C');
        $this->addSql('ALTER TABLE car_models DROP FOREIGN KEY FK_FCBEDCFBFB2CA69D');
        $this->addSql('DROP TABLE car_constructors');
        $this->addSql('DROP TABLE car_engine');
        $this->addSql('DROP TABLE car_models');
        $this->addSql('DROP INDEX IDX_95C71D142B8541DC ON cars');
        $this->addSql('ALTER TABLE cars ADD constructor VARCHAR(50) NOT NULL, ADD model VARCHAR(50) NOT NULL, ADD engine VARCHAR(50) NOT NULL, DROP car_model_id_id');
        $this->addSql('ALTER TABLE photos CHANGE modified_at modified_at DATETIME on update CURRENT_TIMESTAMP');
        $this->addSql('ALTER TABLE services CHANGE modified_at modified_at DATETIME on update CURRENT_TIMESTAMP');
        $this->addSql('ALTER TABLE testimonials CHANGE modified_at modified_at DATETIME on update CURRENT_TIMESTAMP');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE car_constructors (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(30) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE car_engine (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(30) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE car_models (id INT AUTO_INCREMENT NOT NULL, constructor_id_id INT NOT NULL, engine_id_id INT NOT NULL, name VARCHAR(30) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, INDEX IDX_FCBEDCFB522C4A1C (engine_id_id), INDEX IDX_FCBEDCFBFB2CA69D (constructor_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE car_models ADD CONSTRAINT FK_FCBEDCFB522C4A1C FOREIGN KEY (engine_id_id) REFERENCES car_engine (id)');
        $this->addSql('ALTER TABLE car_models ADD CONSTRAINT FK_FCBEDCFBFB2CA69D FOREIGN KEY (constructor_id_id) REFERENCES car_constructors (id)');
        $this->addSql('ALTER TABLE cars ADD car_model_id_id INT NOT NULL, DROP constructor, DROP model, DROP engine');
        $this->addSql('ALTER TABLE cars ADD CONSTRAINT FK_95C71D142B8541DC FOREIGN KEY (car_model_id_id) REFERENCES car_models (id)');
        $this->addSql('CREATE INDEX IDX_95C71D142B8541DC ON cars (car_model_id_id)');
        $this->addSql('ALTER TABLE photos CHANGE modified_at modified_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE services CHANGE modified_at modified_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE testimonials CHANGE modified_at modified_at DATETIME DEFAULT NULL');
    }
}
