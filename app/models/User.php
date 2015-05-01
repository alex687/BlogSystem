<?php

namespace Models;

use Config\Config;
use Database\FilterException;
use Database\FilterVariables;

/**
 * @Entity @Table(name="users")
 **/
class User
{
    /** @Id @Column(type="integer") @GeneratedValue * */
    protected $id;

    /** @Column(type="string", nullable=false, unique=true) * */
    protected $username;

    /** @Column(type="string", nullable=false) * */
    protected $password;

    /** @Column(type="string", nullable=false, unique=true) * */
    protected $email;

    /** @Column(type="string", nullable=true) * */
    protected $firstName;

    /** @Column(type="string", nullable=true) * */
    protected $lastName;

    /** @Column(type="boolean", nullable=false, options={"unsigned":true, "default":0}) * */
    protected $isAdmin;

    /**
     * @return mixed
     */
    public function getIsAdmin()
    {
        return $this->isAdmin;
    }

    /**
     * @param mixed $isAdmin
     */
    public function setIsAdmin($isAdmin)
    {
        $this->isAdmin = $isAdmin;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password)
    {
        $this->password = md5($password);
    }

    /**
     * @return mixed
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param mixed $username
     */
    public function setUsername($username)
    {
        if (FilterVariables::minLength($username, 3)) {
            $this->username = $username;
        } else {
            throw new FilterException("Username must be at least 3");
        }
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail($email)
    {
        if (FilterVariables::email($email)) {
            $this->email = $email;
        } else {
            throw new FilterException("Email is not valid");
        }
    }

    /**
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @param string $firstName
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    }

    /**
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @param string $lastName
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    }

    public function getId()
    {
        return $this->id;
    }
}