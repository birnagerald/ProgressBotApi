<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190628220448 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE episode CHANGE translation translation TINYINT(1) NOT NULL, CHANGE time time TINYINT(1) NOT NULL, CHANGE proofreading proofreading TINYINT(1) NOT NULL, CHANGE edition edition TINYINT(1) NOT NULL, CHANGE quality_check quality_check TINYINT(1) NOT NULL, CHANGE encoding encoding TINYINT(1) NOT NULL, CHANGE typeset typeset TINYINT(1) NOT NULL, CHANGE published published TINYINT(1) NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE episode CHANGE translation translation TINYINT(1) DEFAULT \'0\' NOT NULL, CHANGE time time TINYINT(1) DEFAULT \'0\' NOT NULL, CHANGE proofreading proofreading TINYINT(1) DEFAULT \'0\' NOT NULL, CHANGE edition edition TINYINT(1) DEFAULT \'0\' NOT NULL, CHANGE quality_check quality_check TINYINT(1) DEFAULT \'0\' NOT NULL, CHANGE encoding encoding TINYINT(1) DEFAULT \'0\' NOT NULL, CHANGE typeset typeset TINYINT(1) DEFAULT \'0\' NOT NULL, CHANGE published published TINYINT(1) DEFAULT \'0\' NOT NULL');
    }
}
