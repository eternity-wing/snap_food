<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220208060849 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE food (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_D43829F72B36786B (title), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE food_order (food_id INT NOT NULL, order_id INT NOT NULL, INDEX IDX_4485672BA8E87C4 (food_id), INDEX IDX_44856728D9F6D38 (order_id), PRIMARY KEY(food_id, order_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE food_ingredient (food_id INT NOT NULL, ingredient_id INT NOT NULL, INDEX IDX_CEAC8D1BA8E87C4 (food_id), INDEX IDX_CEAC8D1933FE08C (ingredient_id), PRIMARY KEY(food_id, ingredient_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ingredient (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, best_before DATE NOT NULL, expires_at DATE NOT NULL, stock INT NOT NULL, UNIQUE INDEX UNIQ_6BAF78702B36786B (title), INDEX search_index (id, stock, expires_at, best_before), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `order` (id INT AUTO_INCREMENT NOT NULL, food_id INT NOT NULL, user_id INT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_F5299398BA8E87C4 (food_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE food_order ADD CONSTRAINT FK_4485672BA8E87C4 FOREIGN KEY (food_id) REFERENCES food (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE food_order ADD CONSTRAINT FK_44856728D9F6D38 FOREIGN KEY (order_id) REFERENCES `order` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE food_ingredient ADD CONSTRAINT FK_CEAC8D1BA8E87C4 FOREIGN KEY (food_id) REFERENCES food (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE food_ingredient ADD CONSTRAINT FK_CEAC8D1933FE08C FOREIGN KEY (ingredient_id) REFERENCES ingredient (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F5299398BA8E87C4 FOREIGN KEY (food_id) REFERENCES food (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE food_order DROP FOREIGN KEY FK_4485672BA8E87C4');
        $this->addSql('ALTER TABLE food_ingredient DROP FOREIGN KEY FK_CEAC8D1BA8E87C4');
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F5299398BA8E87C4');
        $this->addSql('ALTER TABLE food_ingredient DROP FOREIGN KEY FK_CEAC8D1933FE08C');
        $this->addSql('ALTER TABLE food_order DROP FOREIGN KEY FK_44856728D9F6D38');
        $this->addSql('DROP TABLE food');
        $this->addSql('DROP TABLE food_order');
        $this->addSql('DROP TABLE food_ingredient');
        $this->addSql('DROP TABLE ingredient');
        $this->addSql('DROP TABLE `order`');
    }
}
