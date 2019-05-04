<?php

namespace AceUser\Entity;

use Ace\Datagrid\Annotation as Grid;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Zend\Form\Annotation as Form;

/**
 * @ORM\Entity
 * @ORM\Table(name="role")
 * @Form\Name("role")
 * @Form\Hydrator("Zend\Hydrator\ClassMethods")
 * @Grid\Title(singular="Role", plural="Roles")
 */
class Role
{
    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     * @Form\Exclude()
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=30, unique=true)
     * @Form\Required(true)
     * @Form\Type("Zend\Form\Element\Text")
     * @Form\Options({"label": "Name"})
     * @Form\Filter({"name": "StringTrim"})
     * @Form\Filter({"name": "StripTags"})
     * @Form\Validator({"name": "StringLength", "options": {"max": "30"}})
     * @Grid\Search()
     */
    protected $name;

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->getName();
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     * @Grid\Header(label="Role", sort={"name"})
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }
}