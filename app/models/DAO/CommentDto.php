<?php

namespace Models;

use Doctrine\ORM\EntityManager;
use  Doctrine\ORM\Mapping\ClassMetadata;

class CommentDao
{

    public static function addComment(EntityManager $entityManager, $text, User $user, Post $post)
    {
        $comment = new Comment();
        $comment->setText($text);
        $comment->setUser($user);
        $comment->setPost($post);

        $entityManager->persist($comment);
    }

    public static function editComment(EntityManager $entityManager, Comment $comment, $text, User $user, Post $post)
    {
        $comment->setText($text);
        $comment->setUser($user);
        $comment->setPost($post);

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