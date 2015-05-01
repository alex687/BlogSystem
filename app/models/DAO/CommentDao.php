<?php

namespace Models;

use Doctrine\ORM\EntityManager;
use  Doctrine\ORM\Mapping\ClassMetadata;

class CommentDao
{

    public static function add(EntityManager $entityManager, $text, User $user, Post $post)
    {
        $comment = new Comment();
        $comment->setText($text);
        $comment->setUser($user);
        $comment->setPost($post);
        $comment->setDate(new \DateTime());

        $entityManager->persist($comment);
    }

    public static function getAllCommentsForPost(EntityManager $entityManager, $postId)
    {
        $queryBuilder = $entityManager->createQueryBuilder();
        $query = $queryBuilder
            ->select('c')
            ->from("Models\Comment", "c")
            ->where($queryBuilder->expr()->eq('c.post_id', '?1'))
            ->orderBy("c.id", "DESC")
            ->setParameter(1, $postId)
            ->getQuery()
            ->setFetchMode("Models\User", "user", ClassMetadata::FETCH_EAGER);

        return $query->getResult();
    }

}