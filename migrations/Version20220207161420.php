<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220207161420 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE UNIQUE INDEX UNIQ_D43829F72B36786B ON food (title)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_6BAF78702B36786B ON ingredient (title)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX UNIQ_D43829F72B36786B ON food');
        $this->addSql('ALTER TABLE food CHANGE title title VARCHAR(255) NOT NULL COLLATE `utf8_unicode_ci`');
        $this->addSql('DROP INDEX UNIQ_6BAF78702B36786B ON ingredient');
        $this->addSql('ALTER TABLE ingredient CHANGE title title VARCHAR(255) NOT NULL COLLATE `utf8_unicode_ci`');
    }
}
