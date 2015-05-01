<?php

namespace Models;

/**
 * @Entity @Table(name="categories", indexes={@Index(name="category_names_index", columns={"name"})})
 **/
class Category
{
    /** @Id @Column(type="integer") @GeneratedValue * */
    protected $id;

    /** @Column(type="string", nullable=false) * */
    protected $name;

    /**
     * @OneToMany(targetEntity="Post", mappedBy="posts",  fetch="LAZY")
     **/
    protected $posts;

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getPost()
    {
        return $this->post;
    }

    /**
     * @param mixed $post
     */
    public function setPost($post)
    {
        $this->post = $post;
    }

    /**
     * @return mixed
     */
    public function getPosts()
    {
        return $this->posts;
    }

    /**
     * @param mixed $posts
     */
    public function setPosts($posts)
    {
        $this->posts = $posts;
    }


    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }
}