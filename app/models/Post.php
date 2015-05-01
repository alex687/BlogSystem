<?php

namespace Models;

/**
 * @Entity @Table(name="posts", indexes={@Index(name="text_index", columns={"title"})})
 **/
class Post
{
    /** @Id @Column(type="integer") @GeneratedValue * */
    protected $id;

    /** @Column(type="string", nullable=false) * */
    protected $title;

    /** @Column(type="text", nullable=false) * */
    protected $text;

    /** @Column(type="integer", nullable=false) * */
    protected $user_id;

    /**
     * @ManyToOne(targetEntity="User", cascade={"all"}, fetch="LAZY")
     * @JoinColumn(name="user_id", referencedColumnName="id")
     * */
    protected $user;


    /** @Column(type="integer", nullable=false) * */
    protected $category_id;

    /**
     * @ManyToOne(targetEntity="Category", cascade={"all"}, fetch="LAZY")
     * @JoinColumn(name="category_id", referencedColumnName="id")
     * */
    protected $category;


    /**
     * @ManyToMany(targetEntity="Tag")
     * @JoinTable(name="posts_tags",
     *      joinColumns={@JoinColumn(name="post_id", referencedColumnName="id")},
     *      inverseJoinColumns={@JoinColumn(name="tag_id", referencedColumnName="id", unique=true)}
     *      )
     **/
    protected $tags;

    public function __constrtuct()
    {
        $this->tags = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getCategoryId()
    {
        return $this->category_id;
    }

    /**
     * @param mixed $category_id
     */
    public function setCategoryId($category_id)
    {
        $this->category_id = $category_id;
    }

    /**
     * @return mixed
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @param mixed $category
     */
    public function setCategory($category)
    {
        $this->category = $category;
    }


    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return mixed
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * @param mixed $text
     */
    public function setText($text)
    {
        $this->text = $text;
    }

    /**
     * @return mixed
     */
    public function getUserId()
    {
        return $this->user_id;
    }

    /**
     * @param mixed $user_id
     */
    public function setUserId($user_id)
    {
        $this->user_id = $user_id;
    }

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param mixed $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }

}