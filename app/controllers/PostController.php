<?php

namespace Controllers;

use Models\CommentDao;
use Models\Post;
use Models\PostDao;

class PostController extends BaseController
{
    public function all()
    {
        $page = 1;
        if (isset($_GET['page']) && $_GET['page'] > 1) {
            $page = $_GET['page'];
        }

        $posts = PostDao::getAllPosts($this->entityManager, $page);
        $hasNextPage = (Post::countPosts($this->entityManager) / 10) > $page;
        $user = $this->getLoggedUser();

        $this->view("home.twig", compact("user", "posts", "page", "hasNextPage"));
    }

    public function get($id)
    {
        $user = $this->getLoggedUser();
        $post = PostDao::get($this->entityManager, $id);
        if (empty($post)) {
            //TODO return Not FOUND
            die();
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if ($user && isset($_POST['commentText'])) {
                $commentText = $_POST['commentText'];

                CommentDao::addComment($this->entityManager, $commentText, $user, $post);
                $this->entityManager->flush();
            }
        }

        $comments = CommentDao::getAllCommentsForPost($this->entityManager, $id);
        $this->view("posts/view.twig", compact("user", "post", "comments"));
    }

    public function add()
    {
        
    }

}