<?php
namespace Models;


use Doctrine\ORM\EntityManager;
use  \Doctrine\ORM\Mapping\ClassMetadata;

class PostDao
{
    public static function get(EntityManager $entityManager, $id)
    {
        $post = $entityManager
            ->getRepository("Models\Post")
            ->find($id);

        return $post;
    }

    public static function add(EntityManager $entityManager, $text, $title, User $user, Category $category, array $tags)
    {
        $post = new Post();
        $post->setUser($user);
        $post->setText($text);
        $post->setCategory($category);
        $post->setTitle($title);

        $entityManager->persist($post);

        return $post;
    }

    public static function getAllPosts(EntityManager $entityManager, $postsPerPage, $page)
    {
        $queryBuilder = $entityManager->createQueryBuilder();

        $query = $queryBuilder
            ->select('p')
            ->from("Models\\Post", "p")
            ->orderBy("p.id", "DESC")
            ->setFirstResult(($page - 1) * $postsPerPage)
            ->setMaxResults($postsPerPage)
            ->getQuery();

        $posts = $query
            ->setFetchMode("Models\\User", "user", ClassMetadata::FETCH_EAGER)
            ->setFetchMode("Models\\Category", "category", ClassMetadata::FETCH_EAGER)
            ->getResult();

        return $posts;
    }

    public static function countPosts(EntityManager $entityManager)
    {
        $queryBuilder = $entityManager->createQueryBuilder();
        $result = $queryBuilder
            ->select('COUNT(p)')
            ->from("Models\Post", "p")
            ->getQuery()
            ->getResult();

        return $result[0][1];
    }
}