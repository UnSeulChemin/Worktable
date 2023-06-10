<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230610173842 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE css DROP FOREIGN KEY FK_78CEA6D8A76ED395');
        $this->addSql('ALTER TABLE css ADD CONSTRAINT FK_78CEA6D8A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE html DROP FOREIGN KEY FK_1879F8E5A76ED395');
        $this->addSql('ALTER TABLE html ADD CONSTRAINT FK_1879F8E5A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE css DROP FOREIGN KEY FK_78CEA6D8A76ED395');
        $this->addSql('ALTER TABLE css ADD CONSTRAINT FK_78CEA6D8A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE html DROP FOREIGN KEY FK_1879F8E5A76ED395');
        $this->addSql('ALTER TABLE html ADD CONSTRAINT FK_1879F8E5A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
    }
}
