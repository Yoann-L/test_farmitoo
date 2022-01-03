<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220103214812 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE cart_promotion');
        $this->addSql('DROP TABLE product_promotion');
        $this->addSql('DROP TABLE user_promotion');
        $this->addSql('ALTER TABLE promotion ADD user_id INT DEFAULT NULL, ADD usage_limit_by_user INT NOT NULL, ADD nb_product_stock INT DEFAULT NULL, ADD min_price_cart INT DEFAULT NULL, ADD min_nb_product_cart INT DEFAULT NULL, ADD discount_fix INT DEFAULT NULL, ADD free_shipping_fees TINYINT(1) NOT NULL, ADD type VARCHAR(255) NOT NULL, DROP quantity_available, DROP discount_value, DROP min_amount, CHANGE expirated_at expirated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE promotion ADD CONSTRAINT FK_C11D7DD1A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_C11D7DD1A76ED395 ON promotion (user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE cart_promotion (cart_id INT NOT NULL, promotion_id INT NOT NULL, INDEX IDX_1BE35A4E139DF194 (promotion_id), INDEX IDX_1BE35A4E1AD5CDBF (cart_id), PRIMARY KEY(cart_id, promotion_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE product_promotion (product_id INT NOT NULL, promotion_id INT NOT NULL, INDEX IDX_AFBDCB5C139DF194 (promotion_id), INDEX IDX_AFBDCB5C4584665A (product_id), PRIMARY KEY(product_id, promotion_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE user_promotion (user_id INT NOT NULL, promotion_id INT NOT NULL, INDEX IDX_C1FDF035139DF194 (promotion_id), INDEX IDX_C1FDF035A76ED395 (user_id), PRIMARY KEY(user_id, promotion_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE cart_promotion ADD CONSTRAINT FK_1BE35A4E139DF194 FOREIGN KEY (promotion_id) REFERENCES promotion (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE cart_promotion ADD CONSTRAINT FK_1BE35A4E1AD5CDBF FOREIGN KEY (cart_id) REFERENCES cart (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE product_promotion ADD CONSTRAINT FK_AFBDCB5C139DF194 FOREIGN KEY (promotion_id) REFERENCES promotion (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE product_promotion ADD CONSTRAINT FK_AFBDCB5C4584665A FOREIGN KEY (product_id) REFERENCES product (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_promotion ADD CONSTRAINT FK_C1FDF035139DF194 FOREIGN KEY (promotion_id) REFERENCES promotion (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_promotion ADD CONSTRAINT FK_C1FDF035A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE promotion DROP FOREIGN KEY FK_C11D7DD1A76ED395');
        $this->addSql('DROP INDEX IDX_C11D7DD1A76ED395 ON promotion');
        $this->addSql('ALTER TABLE promotion ADD quantity_available INT DEFAULT NULL, ADD discount_value INT DEFAULT NULL, ADD min_amount DOUBLE PRECISION DEFAULT NULL, DROP user_id, DROP usage_limit_by_user, DROP nb_product_stock, DROP min_price_cart, DROP min_nb_product_cart, DROP discount_fix, DROP free_shipping_fees, DROP type, CHANGE expirated_at expirated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
    }
}
