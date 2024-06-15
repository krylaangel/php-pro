<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240610191940 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE service_order (id_order INT AUTO_INCREMENT NOT NULL, vehicle_id INT DEFAULT NULL, order_name VARCHAR(255) NOT NULL, INDEX IDX_5C5B7E7F545317D1 (vehicle_id), PRIMARY KEY(id_order)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE orders_spares_parts (id_order INT NOT NULL, spare_part_id INT NOT NULL, INDEX IDX_31CB0EA31BACD2A8 (id_order), INDEX IDX_31CB0EA349B7A72 (spare_part_id), PRIMARY KEY(id_order, spare_part_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE service_order ADD CONSTRAINT FK_5C5B7E7F545317D1 FOREIGN KEY (vehicle_id) REFERENCES vehicle (vehicle_id)');
        $this->addSql('ALTER TABLE orders_spares_parts ADD CONSTRAINT FK_31CB0EA31BACD2A8 FOREIGN KEY (id_order) REFERENCES service_order (id_order)');
        $this->addSql('ALTER TABLE orders_spares_parts ADD CONSTRAINT FK_31CB0EA349B7A72 FOREIGN KEY (spare_part_id) REFERENCES spare_part (spare_part_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE service_order DROP FOREIGN KEY FK_5C5B7E7F545317D1');
        $this->addSql('ALTER TABLE orders_spares_parts DROP FOREIGN KEY FK_31CB0EA31BACD2A8');
        $this->addSql('ALTER TABLE orders_spares_parts DROP FOREIGN KEY FK_31CB0EA349B7A72');
        $this->addSql('DROP TABLE service_order');
        $this->addSql('DROP TABLE orders_spares_parts');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
