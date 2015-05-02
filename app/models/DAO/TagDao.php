<?php

namespace Models;


use Doctrine\ORM\EntityManager;

class TagDao
{
    public static function add(EntityManager $entityManager, $text)
    {
        $tag = new Tag();
        $tag->setName($text);

        $entityManager->persist($tag);

        return $tag;
    }
}