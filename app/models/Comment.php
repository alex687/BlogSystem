<?php

namespace Models;

/**
 * @Entity @Table(name="comments")
 **/
class Comment
{
    /** @Id @Column(type="integer") @GeneratedValue * */
    protected $id;

    /** @Column(type="text", nullable=false) * */
    protected $text;

    /** @Column(type="integer", nullable=false) * */
    protected $user_id;

    /**
     * @ManyToOne(targetEntity="User", cascade={"persist"}, fetch="LAZY")
     * @JoinColumn(name="user_id", referencedColumnName="id")
     * */
    protected $user;

    /** @Column(type="integer", nullable=false) * */
    protected $post_id;

    /**
     * @ManyToOne(targetEntity="Post", cascade={"persist"}, fetch="LAZY")
     * @JoinColumn(name="post_id", referencedColumnName="id")
     * */
    protected $post;

    /** @Column(type="datetime", nullable=false) * */
    protected $date;

    /**
     * @return mixed
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param mixed $date
     */
    public function setDate($date)
    {
        $this->date = $date;
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

    /**
     * @return mixed
     */
    public function getPostId()
    {
        return $this->post_id;
    }

    /**
     * @param mixed $post_id
     */
    public function setPostId($post_id)
    {
        $this->post_id = $post_id;
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

}