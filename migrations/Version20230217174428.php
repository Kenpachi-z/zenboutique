<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230217174428 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE adress CHANGE compagny compagny VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE `order` ADD reference VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE order_details RENAME INDEX idx_ed896f46bfcdf877 TO IDX_845CA2C1BFCDF877');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE adress CHANGE compagny compagny VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE `order` DROP reference');
        $this->addSql('ALTER TABLE order_details RENAME INDEX idx_845ca2c1bfcdf877 TO IDX_ED896F46BFCDF877');
    }
}
