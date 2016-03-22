<?php

// src/ecommerce/ArticleBundle/DataFixtures/ORM/Categories.php

namespace ecommerce\ArticleBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use ecommerce\ArticleBundle\Entity\Category;
use ecommerce\ArticleBundle\Entity\Genre;

class Categories implements FixtureInterface {

    // Dans l'argument de la méthode load, l'objet $manager est l'EntityManager
    public function load(ObjectManager $manager) {
        $category = new Category();
        $category->setName("Mode");
        $manager->persist($category);
        $manager->flush();

        // Liste des noms de catégorie à ajouter
        $names = array('Vêtements Femmes', 'Vêtements Hommes', 'Vêtements Enfants', 'Bijoux, Montres', 'Beauté, Parfums', 'Sport');

        foreach ($names as $i => $name) {
            // On crée la catégorie
            $liste_genres[$i] = new Genre();
            $liste_genres[$i]->setName($name);
            $liste_genres[$i]->setCategory($category);

            // On la persiste
            $manager->persist($liste_genres[$i]);
            $manager->flush();
        }

        //HIGH-TECH
        $category = new Category();
        $category->setName("High-Tech");
        $manager->persist($category);
        $manager->flush();

        // Liste des noms de catégorie à ajouter
        $names = array('Téléphonie, Mobilité', 'Informatique, Réseaux', 'Téléviseurs, Lecteurs', 'Jeux Vidéo, Consoles', 'Appareils Photos', 'Caméscope');

        foreach ($names as $i => $name) {
            // On crée la catégorie
            $liste_genres[$i] = new Genre();
            $liste_genres[$i]->setName($name);
            $liste_genres[$i]->setCategory($category);

            // On la persiste
            $manager->persist($liste_genres[$i]);
            $manager->flush();
        }

        //MAISON
        $category = new Category();
        $category->setName("Maison");
        $manager->persist($category);
        $manager->flush();

        // Liste des noms de catégorie à ajouter
        $names = array('Maison', 'Matériaux de construction', 'Bricolage', 'Electroménager', 'Bébé, Puériculture', 'Animalerie', 'Vins, Gastronomie', 'Loisirs créatifs');

        foreach ($names as $i => $name) {
            // On crée la catégorie
            $liste_genres[$i] = new Genre();
            $liste_genres[$i]->setName($name);
            $liste_genres[$i]->setCategory($category);

            // On la persiste
            $manager->persist($liste_genres[$i]);
            $manager->flush();
        }

        //AUTO & MOTO
        $category = new Category();
        $category->setName("Auto & Moto");
        $manager->persist($category);
        $manager->flush();

        // Liste des noms de catégorie à ajouter
        $names = array('Auto', 'Moto', 'Outils dépannage', 'Autoradio, Hi-fi', 'GPS', 'Casques, Vêtements');

        foreach ($names as $i => $name) {
            // On crée la catégorie
            $liste_genres[$i] = new Genre();
            $liste_genres[$i]->setName($name);
            $liste_genres[$i]->setCategory($category);

            // On la persiste
            $manager->persist($liste_genres[$i]);
            $manager->flush();
        }
    }

}
