<?php

namespace Models;


use Doctrine\ORM\EntityManager;

class CategoryDao
{
    public static function getAllCategories(EntityManager $entityManager)
    {
        return $entityManager->getRepository("Models\\Category")->findAll();
    }

    public static function get(EntityManager $entityManager, $id)
    {
        return  $entityManager->getRepository("Models\\Category")->find($id);
    }
}