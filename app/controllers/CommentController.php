<?php
namespace Controllers;


use Models\CommentDao;
use Models\PostDao;
use URL\URL;

class CommentController extends BaseController
{

    public function edit($id)
    {
        $this->checkIsAdmin();

        $comment = $this->entityManager
            ->getRepository("Models\\Comment")
            ->find($id);
        if (empty($comment)) {
            $this->notFound();
        }
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $text = $_POST['commentText'];
            $comment->setText($text);
            $this->entityManager->flush();

            URL::redirect('post/get/' . $comment->getPostId());
        } else {
            $this->view("comments/edit.twig", compact("comment"));
        }
    }

    public function add($postId)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $post = PostDao::get($this->entityManager, $postId);
            if (empty($post)) {
                $this->notFound();
            }

            $user = $this->getLoggedUser();
            if (empty($user)) {
                $this->login();
            }

            $commentText = $_POST['commentText'];
            CommentDao::add($this->entityManager, $commentText, $user, $post);
            $this->entityManager->flush();

            URL::redirect('post/get/' . $postId);
        } else {
            //TODO return not found
        }
    }

    public function delete($id)
    {
        $this->checkIsAdmin();

        $comment = $this->entityManager
            ->getRepository("Models\\Comment")
            ->find($id);
        if (empty($comment)) {
            $this->notFound();
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->entityManager->remove($comment);

            $this->entityManager->flush();

            URL::redirect('post/get/' . $comment->getPostId());

        } else {
            $this->view('comments/delete.twig', compact("comment"));
        }
    }
}