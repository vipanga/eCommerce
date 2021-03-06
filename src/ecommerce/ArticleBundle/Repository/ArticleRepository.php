<?php

namespace ecommerce\ArticleBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;

/**
 * ArticleRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ArticleRepository extends EntityRepository
{
    public function getArticlesByCategory($numberItemsPerPage, $page, $category)
    {
        // On déplace la vérification du numéro de page dans cette méthode
        if ($page < 1) {
            throw new \InvalidArgumentException('L\'argument $page ne peut être inférieur à 1 (valeur : "' . $page . '").');
        }

        // La construction de la requête reste inchangée
        $query = $this->createQueryBuilder('a')
            ->where('g.category = :category')
            ->setParameter('category', $category)
            ->leftJoin('a.image', 'i')
            ->addSelect('i')
            ->leftJoin('a.genre', 'g')
            ->addSelect('g')
            ->orderBy('a.datepublication', 'DESC')
            ->getQuery();

        // On définit l'article à partir duquel commencer la liste
        $query->setFirstResult(($page - 1) * $numberItemsPerPage)
            // Ainsi que le nombre d'articles à afficher
            ->setMaxResults($numberItemsPerPage);

        // Enfin, on retourne l'objet Paginator correspondant à la requête construite
        // (n'oubliez pas le use correspondant en début de fichier)
        return new Paginator($query);
    }

    public function getArticles($numberItemsPerPage, $page, $genre)
    {
        // On déplace la vérification du numéro de page dans cette méthode
        if ($page < 1) {
            throw new \InvalidArgumentException('L\'argument $page ne peut être inférieur à 1 (valeur : "' . $page . '").');
        }

        // La construction de la requête reste inchangée
        $query = $this->createQueryBuilder('a')
            ->where('a.genre = :genre')
            ->setParameter('genre', $genre)
            ->leftJoin('a.image', 'i')
            ->addSelect('i')
            ->leftJoin('a.genre', 'g')
            ->addSelect('g')
            ->orderBy('a.datepublication', 'DESC')
            ->getQuery();

        // On définit l'article à partir duquel commencer la liste
        $query->setFirstResult(($page - 1) * $numberItemsPerPage)
            // Ainsi que le nombre d'articles à afficher
            ->setMaxResults($numberItemsPerPage);

        // Enfin, on retourne l'objet Paginator correspondant à la requête construite
        // (n'oubliez pas le use correspondant en début de fichier)
        return new Paginator($query);
    }

    public function getTelephones()
    {
        $query = $this->createQueryBuilder('a')
            ->leftJoin('a.image', 'i')
            ->addSelect('i')
            ->leftJoin('a.genre', 'g')
            ->addSelect('g')
            ->where('g.name = :name_genre')
            ->setParameter('name_genre', 'Téléphonie, Mobilité')
            ->orderBy('a.datepublication', 'DESC')
            ->setMaxResults(6)
            ->getQuery();

        return $query->getResult();
    }

    public function getTeleviseurs()
    {
        $query = $this->createQueryBuilder('a')
            ->leftJoin('a.image', 'i')
            ->addSelect('i')
            ->leftJoin('a.genre', 'g')
            ->addSelect('g')
            ->where('g.name = :name_genre')
            ->setParameter('name_genre', 'Téléviseurs, Lecteurs')
            ->orderBy('a.datepublication', 'DESC')
            ->setMaxResults(6)
            ->getQuery();

        return $query->getResult();
    }

    public function getMateriaux()
    {
        $query = $this->createQueryBuilder('a')
            ->leftJoin('a.image', 'i')
            ->addSelect('i')
            ->leftJoin('a.genre', 'g')
            ->addSelect('g')
            ->where('g.name = :name_genre')
            ->setParameter('name_genre', 'Matériaux de construction')
            ->orderBy('a.datepublication', 'DESC')
            ->setMaxResults(6)
            ->getQuery();

        return $query->getResult();
    }

    public function getUserArticles($numberItemsPerPage, $page, $user)
    {
        // On déplace la vérification du numéro de page dans cette méthode
        if ($page < 1) {
            throw new \InvalidArgumentException('L\'argument $page ne peut être inférieur à 1 (valeur : "' . $page . '").');
        }

        // La construction de la requête reste inchangée
        $query = $this->createQueryBuilder('a')
            ->where('a.user = :user')
            ->setParameter('user', $user)
            ->leftJoin('a.image', 'i')
            ->addSelect('i')
            ->leftJoin('a.genre', 'g')
            ->addSelect('g')
            ->orderBy('a.datepublication', 'DESC')
            ->getQuery();

        // On définit l'article à partir duquel commencer la liste
        $query->setFirstResult(($page - 1) * $numberItemsPerPage)
            // Ainsi que le nombre d'articles à afficher
            ->setMaxResults($numberItemsPerPage);

        // Enfin, on retourne l'objet Paginator correspondant à la requête construite
        // (n'oubliez pas le use correspondant en début de fichier)
        return new Paginator($query);
    }

    public function getSearchArticles($numberItemsPerPage, $page, $product, $province)
    {
        // On déplace la vérification du numéro de page dans cette méthode
        if ($page < 1) {
            throw new \InvalidArgumentException('L\'argument $page ne peut être inférieur à 1 (valeur : "' . $page . '").');
        }

        // La construction de la requête reste inchangée
        $query = $this->createQueryBuilder('a')
            ->where('a.name_item LIKE :product')
            ->setParameter('product', "%$product%")
            ->andWhere('a.province = :province')
            ->setParameter('province', $province)
            ->leftJoin('a.image', 'i')
            ->addSelect('i')
            ->leftJoin('a.genre', 'g')
            ->addSelect('g')
            ->orderBy('a.datepublication', 'DESC')
            ->getQuery();

        // On définit l'article à partir duquel commencer la liste
        $query->setFirstResult(($page - 1) * $numberItemsPerPage)
            // Ainsi que le nombre d'articles à afficher
            ->setMaxResults($numberItemsPerPage);

        // Enfin, on retourne l'objet Paginator correspondant à la requête construite
        // (n'oubliez pas le use correspondant en début de fichier)
        return new Paginator($query);
    }

    public function getSearchArticlesOnly($numberItemsPerPage, $page, $product)
    {
        // On déplace la vérification du numéro de page dans cette méthode
        if ($page < 1) {
            throw new \InvalidArgumentException('L\'argument $page ne peut être inférieur à 1 (valeur : "' . $page . '").');
        }

        // La construction de la requête reste inchangée
        $query = $this->createQueryBuilder('a')
            ->where('a.name_item LIKE :product')
            ->setParameter('product', "%$product%")
            ->leftJoin('a.image', 'i')
            ->addSelect('i')
            ->leftJoin('a.genre', 'g')
            ->addSelect('g')
            ->orderBy('a.datepublication', 'DESC')
            ->getQuery();

        // On définit l'article à partir duquel commencer la liste
        $query->setFirstResult(($page - 1) * $numberItemsPerPage)
            // Ainsi que le nombre d'articles à afficher
            ->setMaxResults($numberItemsPerPage);

        // Enfin, on retourne l'objet Paginator correspondant à la requête construite
        // (n'oubliez pas le use correspondant en début de fichier)
        return new Paginator($query);
    }
}
