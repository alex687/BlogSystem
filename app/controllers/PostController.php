<?php

namespace Controllers;

use Database\FilterException;
use Models\CategoryDao;
use Models\CommentDao;
use Models\Post;
use Models\PostDao;
use URL\URL;

class PostController extends BaseController
{
    public function all()
    {
        $page = 1;
        if (isset($_GET['page']) && $_GET['page'] > 1) {
            $page = $_GET['page'];
        }

        $posts = PostDao::getAllPosts($this->entityManager, 10, $page);
        $hasNextPage = (PostDao::countPosts($this->entityManager) / 10) > $page;
        $user = $this->getLoggedUser();

        $this->view("posts/view-all.twig", compact("user", "posts", "page", "hasNextPage"));
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
        $user = $this->getLoggedUser();
        if (!$user || !$user->getIsAdmin()) {
            //todo Return not found
            die();
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            try {
                $title = $_POST['title'];
                $text = $_POST['text'];
                $category = CategoryDao::get($this->entityManager, $_POST['category']);

                $post = PostDao::add($this->entityManager, $text, $title, $user, $category, array());
                $this->entityManager->flush();

                URL::redirect("post/get/" . $post->getId());
            } catch (FilterException $e) {
                $error = $e->getMessage();
                $oldInput = $_POST;

                $this->view("posts/add-edit.twig", compact("error", "oldInput"));
                return;
            }
        } else {
            $this->view("posts/add-edit.twig");
        }
    }
}