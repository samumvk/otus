<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240108122603 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE permissions_id_seq');
        $this->addSql('SELECT setval(\'permissions_id_seq\', (SELECT MAX(id) FROM permissions))');
        $this->addSql('ALTER TABLE permissions ALTER id SET DEFAULT nextval(\'permissions_id_seq\')');
        $this->addSql('CREATE SEQUENCE role_id_seq');
        $this->addSql('SELECT setval(\'role_id_seq\', (SELECT MAX(id) FROM role))');
        $this->addSql('ALTER TABLE role ALTER id SET DEFAULT nextval(\'role_id_seq\')');
        $this->addSql('CREATE SEQUENCE user_id_seq');
        $this->addSql('SELECT setval(\'user_id_seq\', (SELECT MAX(id) FROM "user"))');
        $this->addSql('ALTER TABLE "user" ALTER id SET DEFAULT nextval(\'user_id_seq\')');
        $this->addSql('ALTER TABLE "user" ADD CONSTRAINT USER_FK_ROLE_ID FOREIGN KEY (role_id) REFERENCES role (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX user__role_id__ind ON "user" (role_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE permissions ALTER id DROP DEFAULT');
        $this->addSql('ALTER TABLE role ALTER id DROP DEFAULT');
        $this->addSql('ALTER TABLE "user" DROP CONSTRAINT USER_FK_ROLE_ID');
        $this->addSql('DROP INDEX user__role_id__ind');
        $this->addSql('ALTER TABLE "user" ALTER id DROP DEFAULT');
    }
}
