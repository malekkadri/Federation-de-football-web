<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220322141437 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE commande (id INT AUTO_INCREMENT NOT NULL, id_u_id INT NOT NULL, id_p_id INT NOT NULL, prix_u DOUBLE PRECISION NOT NULL, qte INT NOT NULL, date DATE NOT NULL, etat INT NOT NULL, taille VARCHAR(255) NOT NULL, INDEX IDX_6EEAA67D6F858F92 (id_u_id), INDEX IDX_6EEAA67D585B7FA0 (id_p_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE jour (id INT AUTO_INCREMENT NOT NULL, clu_id INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, INDEX IDX_DA17D9C5A6810A97 (clu_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE marques (id INT AUTO_INCREMENT NOT NULL, nom_m VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE commande ADD CONSTRAINT FK_6EEAA67D6F858F92 FOREIGN KEY (id_u_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE commande ADD CONSTRAINT FK_6EEAA67D585B7FA0 FOREIGN KEY (id_p_id) REFERENCES produit (id)');
        $this->addSql('ALTER TABLE jour ADD CONSTRAINT FK_DA17D9C5A6810A97 FOREIGN KEY (clu_id) REFERENCES club (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE arbitre ADD image VARCHAR(255) NOT NULL, ADD descrp VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE article ADD CONSTRAINT FK_23A0E66A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE badge CHANGE id id INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE categorie CHANGE id id INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE classement CHANGE id id INT AUTO_INCREMENT NOT NULL, ADD PRIMARY KEY (id)');
        $this->addSql('ALTER TABLE classement ADD CONSTRAINT FK_55EE9D6D61190A32 FOREIGN KEY (club_id) REFERENCES club (id)');
        $this->addSql('ALTER TABLE classement ADD CONSTRAINT FK_55EE9D6DF607770A FOREIGN KEY (tournoi_id) REFERENCES tournoi (id)');
        $this->addSql('CREATE INDEX IDX_55EE9D6D61190A32 ON classement (club_id)');
        $this->addSql('CREATE INDEX IDX_55EE9D6DF607770A ON classement (tournoi_id)');
        $this->addSql('ALTER TABLE club CHANGE id id INT AUTO_INCREMENT NOT NULL, ADD PRIMARY KEY (id)');
        $this->addSql('ALTER TABLE club ADD CONSTRAINT FK_B8EE387212F7FB51 FOREIGN KEY (sponsor_id) REFERENCES sponsor (id) ON DELETE SET NULL');
        $this->addSql('CREATE INDEX IDX_B8EE387212F7FB51 ON club (sponsor_id)');
        $this->addSql('ALTER TABLE game CHANGE id id INT AUTO_INCREMENT NOT NULL, ADD PRIMARY KEY (id)');
        $this->addSql('ALTER TABLE game ADD CONSTRAINT FK_232B318C1EDA6519 FOREIGN KEY (club1_id) REFERENCES club (id)');
        $this->addSql('ALTER TABLE game ADD CONSTRAINT FK_232B318CC6FCAF7 FOREIGN KEY (club2_id) REFERENCES club (id)');
        $this->addSql('ALTER TABLE game ADD CONSTRAINT FK_232B318C943A5F0 FOREIGN KEY (arbitre_id) REFERENCES arbitre (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE game ADD CONSTRAINT FK_232B318C6538AB43 FOREIGN KEY (stade_id) REFERENCES stade (id)');
        $this->addSql('ALTER TABLE game ADD CONSTRAINT FK_232B318CF607770A FOREIGN KEY (tournoi_id) REFERENCES tournoi (id)');
        $this->addSql('CREATE INDEX IDX_232B318C1EDA6519 ON game (club1_id)');
        $this->addSql('CREATE INDEX IDX_232B318CC6FCAF7 ON game (club2_id)');
        $this->addSql('CREATE INDEX IDX_232B318C943A5F0 ON game (arbitre_id)');
        $this->addSql('CREATE INDEX IDX_232B318C6538AB43 ON game (stade_id)');
        $this->addSql('CREATE INDEX IDX_232B318CF607770A ON game (tournoi_id)');
        $this->addSql('ALTER TABLE interaction CHANGE idi idi INT AUTO_INCREMENT NOT NULL, ADD PRIMARY KEY (idi)');
        $this->addSql('ALTER TABLE interaction ADD CONSTRAINT FK_378DFDA7A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE interaction ADD CONSTRAINT FK_378DFDA77294869C FOREIGN KEY (article_id) REFERENCES article (id)');
        $this->addSql('CREATE INDEX IDX_378DFDA7A76ED395 ON interaction (user_id)');
        $this->addSql('CREATE INDEX IDX_378DFDA77294869C ON interaction (article_id)');
        $this->addSql('ALTER TABLE joueur CHANGE cin cin INT AUTO_INCREMENT NOT NULL, ADD PRIMARY KEY (cin)');
        $this->addSql('ALTER TABLE joueur ADD CONSTRAINT FK_FD71A9C561190A32 FOREIGN KEY (club_id) REFERENCES club (id) ON DELETE SET NULL');
        $this->addSql('CREATE INDEX IDX_FD71A9C561190A32 ON joueur (club_id)');
        $this->addSql('ALTER TABLE panier CHANGE id id INT AUTO_INCREMENT NOT NULL, ADD PRIMARY KEY (id)');
        $this->addSql('ALTER TABLE panier ADD CONSTRAINT FK_24CC0DF2A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE panier ADD CONSTRAINT FK_24CC0DF2F347EFB FOREIGN KEY (produit_id) REFERENCES produit (id)');
        $this->addSql('CREATE INDEX IDX_24CC0DF2A76ED395 ON panier (user_id)');
        $this->addSql('CREATE INDEX IDX_24CC0DF2F347EFB ON panier (produit_id)');
        $this->addSql('ALTER TABLE produit CHANGE id id INT AUTO_INCREMENT NOT NULL, ADD PRIMARY KEY (id)');
        $this->addSql('ALTER TABLE produit ADD CONSTRAINT FK_29A5EC27BCF5E72D FOREIGN KEY (categorie_id) REFERENCES categorie (id)');
        $this->addSql('ALTER TABLE produit ADD CONSTRAINT FK_29A5EC27D0E3E7D2 FOREIGN KEY (marquep_id) REFERENCES marques (id)');
        $this->addSql('CREATE INDEX IDX_29A5EC27BCF5E72D ON produit (categorie_id)');
        $this->addSql('CREATE INDEX IDX_29A5EC27D0E3E7D2 ON produit (marquep_id)');
        $this->addSql('ALTER TABLE reclamation CHANGE idr idr INT AUTO_INCREMENT NOT NULL, ADD PRIMARY KEY (idr)');
        $this->addSql('ALTER TABLE reclamation ADD CONSTRAINT FK_CE606404A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_CE606404A76ED395 ON reclamation (user_id)');
        $this->addSql('ALTER TABLE rewards CHANGE id_r id_r INT AUTO_INCREMENT NOT NULL, ADD PRIMARY KEY (id_r)');
        $this->addSql('ALTER TABLE rewards ADD CONSTRAINT FK_E9221E37F607770A FOREIGN KEY (tournoi_id) REFERENCES tournoi (id)');
        $this->addSql('CREATE INDEX IDX_E9221E37F607770A ON rewards (tournoi_id)');
        $this->addSql('ALTER TABLE sponsor CHANGE id id INT AUTO_INCREMENT NOT NULL, ADD PRIMARY KEY (id)');
        $this->addSql('ALTER TABLE stade CHANGE id id INT AUTO_INCREMENT NOT NULL, ADD PRIMARY KEY (id)');
        $this->addSql('ALTER TABLE tournoi CHANGE id id INT AUTO_INCREMENT NOT NULL, ADD PRIMARY KEY (id)');
        $this->addSql('ALTER TABLE user CHANGE id id INT AUTO_INCREMENT NOT NULL, ADD PRIMARY KEY (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649F7A2C2FC FOREIGN KEY (badge_id) REFERENCES badge (id)');
        $this->addSql('CREATE INDEX IDX_8D93D649F7A2C2FC ON user (badge_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE produit DROP FOREIGN KEY FK_29A5EC27D0E3E7D2');
        $this->addSql('DROP TABLE commande');
        $this->addSql('DROP TABLE jour');
        $this->addSql('DROP TABLE marques');
        $this->addSql('ALTER TABLE arbitre DROP image, DROP descrp');
        $this->addSql('ALTER TABLE article DROP FOREIGN KEY FK_23A0E66A76ED395');
        $this->addSql('ALTER TABLE badge CHANGE id id INT NOT NULL');
        $this->addSql('ALTER TABLE categorie CHANGE id id INT NOT NULL');
        $this->addSql('ALTER TABLE classement MODIFY id INT NOT NULL');
        $this->addSql('ALTER TABLE classement DROP FOREIGN KEY FK_55EE9D6D61190A32');
        $this->addSql('ALTER TABLE classement DROP FOREIGN KEY FK_55EE9D6DF607770A');
        $this->addSql('DROP INDEX IDX_55EE9D6D61190A32 ON classement');
        $this->addSql('DROP INDEX IDX_55EE9D6DF607770A ON classement');
        $this->addSql('ALTER TABLE classement DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE classement CHANGE id id INT NOT NULL');
        $this->addSql('ALTER TABLE club MODIFY id INT NOT NULL');
        $this->addSql('ALTER TABLE club DROP FOREIGN KEY FK_B8EE387212F7FB51');
        $this->addSql('DROP INDEX IDX_B8EE387212F7FB51 ON club');
        $this->addSql('ALTER TABLE club DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE club CHANGE id id INT NOT NULL');
        $this->addSql('ALTER TABLE game MODIFY id INT NOT NULL');
        $this->addSql('ALTER TABLE game DROP FOREIGN KEY FK_232B318C1EDA6519');
        $this->addSql('ALTER TABLE game DROP FOREIGN KEY FK_232B318CC6FCAF7');
        $this->addSql('ALTER TABLE game DROP FOREIGN KEY FK_232B318C943A5F0');
        $this->addSql('ALTER TABLE game DROP FOREIGN KEY FK_232B318C6538AB43');
        $this->addSql('ALTER TABLE game DROP FOREIGN KEY FK_232B318CF607770A');
        $this->addSql('DROP INDEX IDX_232B318C1EDA6519 ON game');
        $this->addSql('DROP INDEX IDX_232B318CC6FCAF7 ON game');
        $this->addSql('DROP INDEX IDX_232B318C943A5F0 ON game');
        $this->addSql('DROP INDEX IDX_232B318C6538AB43 ON game');
        $this->addSql('DROP INDEX IDX_232B318CF607770A ON game');
        $this->addSql('ALTER TABLE game DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE game CHANGE id id INT NOT NULL');
        $this->addSql('ALTER TABLE interaction MODIFY idi INT NOT NULL');
        $this->addSql('ALTER TABLE interaction DROP FOREIGN KEY FK_378DFDA7A76ED395');
        $this->addSql('ALTER TABLE interaction DROP FOREIGN KEY FK_378DFDA77294869C');
        $this->addSql('DROP INDEX IDX_378DFDA7A76ED395 ON interaction');
        $this->addSql('DROP INDEX IDX_378DFDA77294869C ON interaction');
        $this->addSql('ALTER TABLE interaction DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE interaction CHANGE idi idi INT NOT NULL');
        $this->addSql('ALTER TABLE joueur MODIFY cin INT NOT NULL');
        $this->addSql('ALTER TABLE joueur DROP FOREIGN KEY FK_FD71A9C561190A32');
        $this->addSql('DROP INDEX IDX_FD71A9C561190A32 ON joueur');
        $this->addSql('ALTER TABLE joueur DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE joueur CHANGE cin cin INT NOT NULL');
        $this->addSql('ALTER TABLE panier MODIFY id INT NOT NULL');
        $this->addSql('ALTER TABLE panier DROP FOREIGN KEY FK_24CC0DF2A76ED395');
        $this->addSql('ALTER TABLE panier DROP FOREIGN KEY FK_24CC0DF2F347EFB');
        $this->addSql('DROP INDEX IDX_24CC0DF2A76ED395 ON panier');
        $this->addSql('DROP INDEX IDX_24CC0DF2F347EFB ON panier');
        $this->addSql('ALTER TABLE panier DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE panier CHANGE id id INT NOT NULL');
        $this->addSql('ALTER TABLE produit MODIFY id INT NOT NULL');
        $this->addSql('ALTER TABLE produit DROP FOREIGN KEY FK_29A5EC27BCF5E72D');
        $this->addSql('DROP INDEX IDX_29A5EC27BCF5E72D ON produit');
        $this->addSql('DROP INDEX IDX_29A5EC27D0E3E7D2 ON produit');
        $this->addSql('ALTER TABLE produit DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE produit CHANGE id id INT NOT NULL');
        $this->addSql('ALTER TABLE reclamation MODIFY idr INT NOT NULL');
        $this->addSql('ALTER TABLE reclamation DROP FOREIGN KEY FK_CE606404A76ED395');
        $this->addSql('DROP INDEX IDX_CE606404A76ED395 ON reclamation');
        $this->addSql('ALTER TABLE reclamation DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE reclamation CHANGE idr idr INT NOT NULL');
        $this->addSql('ALTER TABLE rewards MODIFY id_r INT NOT NULL');
        $this->addSql('ALTER TABLE rewards DROP FOREIGN KEY FK_E9221E37F607770A');
        $this->addSql('DROP INDEX IDX_E9221E37F607770A ON rewards');
        $this->addSql('ALTER TABLE rewards DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE rewards CHANGE id_r id_r INT NOT NULL');
        $this->addSql('ALTER TABLE sponsor MODIFY id INT NOT NULL');
        $this->addSql('ALTER TABLE sponsor DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE sponsor CHANGE id id INT NOT NULL');
        $this->addSql('ALTER TABLE stade MODIFY id INT NOT NULL');
        $this->addSql('ALTER TABLE stade DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE stade CHANGE id id INT NOT NULL');
        $this->addSql('ALTER TABLE tournoi MODIFY id INT NOT NULL');
        $this->addSql('ALTER TABLE tournoi DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE tournoi CHANGE id id INT NOT NULL');
        $this->addSql('ALTER TABLE user MODIFY id INT NOT NULL');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649F7A2C2FC');
        $this->addSql('DROP INDEX IDX_8D93D649F7A2C2FC ON user');
        $this->addSql('ALTER TABLE user DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE user CHANGE id id INT NOT NULL');
    }
}
