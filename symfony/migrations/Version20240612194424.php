<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240612194424 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE order_item (id_item INT AUTO_INCREMENT NOT NULL, id_order INT NOT NULL, spare_part_id INT NOT NULL, quantity INT NOT NULL, INDEX IDX_52EA1F091BACD2A8 (id_order), INDEX IDX_52EA1F0949B7A72 (spare_part_id), PRIMARY KEY(id_item)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE service_order (id_order INT AUTO_INCREMENT NOT NULL, vehicle_id INT DEFAULT NULL, order_name INT NOT NULL, INDEX IDX_5C5B7E7F545317D1 (vehicle_id), PRIMARY KEY(id_order)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE order_item ADD CONSTRAINT FK_52EA1F091BACD2A8 FOREIGN KEY (id_order) REFERENCES service_order (id_order)');
        $this->addSql('ALTER TABLE order_item ADD CONSTRAINT FK_52EA1F0949B7A72 FOREIGN KEY (spare_part_id) REFERENCES spare_part (spare_part_id)');
        $this->addSql('ALTER TABLE service_order ADD CONSTRAINT FK_5C5B7E7F545317D1 FOREIGN KEY (vehicle_id) REFERENCES vehicle (vehicle_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE order_item DROP FOREIGN KEY FK_52EA1F091BACD2A8');
        $this->addSql('ALTER TABLE order_item DROP FOREIGN KEY FK_52EA1F0949B7A72');
        $this->addSql('ALTER TABLE service_order DROP FOREIGN KEY FK_5C5B7E7F545317D1');
        $this->addSql('DROP TABLE order_item');
        $this->addSql('DROP TABLE service_order');
    }
}
