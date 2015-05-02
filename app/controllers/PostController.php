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
            $this->notFound();
        }
        $post->setViews($post->getViews() + 1);
        $this->entityManager->flush();

        $comments = CommentDao::getAllCommentsForPost($this->entityManager, $id);
        $this->view("posts/view.twig", compact("user", "post", "comments"));
    }

    public function add()
    {
        $user = $this->getLoggedUser();
        if (empty($user) || !$user->getIsAdmin()) {
            $this->notFound();
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            try {
                $title = $_POST['title'];
                $text = $_POST['text'];
                $category = CategoryDao::get($this->entityManager, $_POST['category']);

                $post = PostDao::add($this->entityManager, $text, $title, $user, $category, array());
                PostDao::addTagsToPost($this->entityManager, $post, $_POST['tags']);

                $this->entityManager->flush();

                URL::redirect("post/get/" . $post->getId());
            } catch (FilterException $e) {
                $error = $e->getMessage();
                $oldInput = $_POST;

                $this->view("posts/add.twig", compact("error", "oldInput", 'user'));

                return;
            }
        } else {
            $this->view("posts/add.twig", compact('user'));
        }
    }

    public function edit($postId)
    {
        $user = $this->getLoggedUser();
        if (empty($user) || !$user->getIsAdmin()) {
            $this->notFound();
        }

        $post = PostDao::get($this->entityManager, $postId);
        if (empty($post)) {
            $this->notFound();
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            try {
                $title = $_POST['title'];
                $text = $_POST['text'];
                $category = CategoryDao::get($this->entityManager, $_POST['category']);

                $post->setTitle($title);
                $post->setText($text);
                $post->setCategory($category);
                PostDao::addTagsToPost($this->entityManager, $post, $_POST['tags']);

                $this->entityManager->flush();

                URL::redirect("post/get/" . $post->getId());
            } catch (FilterException $e) {
                $error = $e->getMessage();
                $oldInput = $_POST;

                $this->view("posts/add-edit.twig", compact("error", "oldInput"));

                return;
            }
        } else {
            $tags = $this->tagsToStr($post);

            $this->view("posts/edit.twig", compact("post", "tags"));
        }
    }

    public function delete($postId)
    {
        $this->checkIsAdmin();

        $post = PostDao::get($this->entityManager, $postId);
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->entityManager->remove($post);

            $this->entityManager->flush();

            URL::redirect('post/all');

        } else {
            $this->view('posts/delete.twig', compact("post"));
        }
    }

    private function tagsToStr(Post $post)
    {
        $tagsArr = array();
        foreach($post->getTags() as $tag )
        {
            $tagsArr[] = $tag->getName();
        }

        return implode(',', $tagsArr);
    }
}