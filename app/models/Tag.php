<?php
/**
 * Created by PhpStorm.
 * User: Sa6o
 * Date: 1.5.2015 г.
 * Time: 14:53 ч.
 */

namespace Models;

/**
 * @Entity @Table(name="tags")
 **/
class Tag
{
    /** @Id @Column(type="integer") @GeneratedValue * */
    protected $id;

    /** @Column(type="string", nullable=false) * */
    protected $name;

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
    public function getId()
    {
        return $this->id;
    }
}