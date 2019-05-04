<?php

namespace AceUser\Entity;

use AceUser\Service\UserService;
use Ace\Datagrid\Annotation as Grid;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Zend\Form\Annotation as Form;
use ZfcRbac\Identity\IdentityInterface;

/**
 * @ORM\Entity
 * @ORM\Table(name="user")
 * @Form\Name("user")
 * @Form\Hydrator("Zend\Hydrator\ClassMethods")
 * @Grid\Title(singular="User", plural="Users")
 */
class User implements IdentityInterface
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
     * @ORM\Column(type="string", unique=true, length=20)
     * @Form\Required(true)
     * @Form\Type("Zend\Form\Element\Text")
     * @Form\Options({"label": "Username"})
     * @Form\Filter({"name": "StringTrim"})
     * @Form\Filter({"name": "StripTags"})
     * @Form\Validator({"name": "StringLength", "options": {"max": "20"}})
     * @Form\Validator({"name": "Regex", "options": {"pattern": "/^[a-zA-Z][a-zA-Z0-9_-]{0,19}$/"}})
     * @Grid\Search()
     * @Grid\Suggest()
     */
    protected $username;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=60)
     * @Form\Exclude()
     */
    protected $password;

    /**
     * @var string
     *
     * @ORM\Column(type="string", unique=true)
     * @Form\Required(true)
     * @Form\Type("Zend\Form\Element\Email")
     * @Form\Options({"label": "Email"})
     * @Grid\Search()
     */
    protected $email;

    /**
     * @var ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="AceUser\Entity\Role", inversedBy="users")
     * @ORM\JoinTable(name="user_role",
     *     joinColumns={@ORM\JoinColumn(name="userId", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="roleId", referencedColumnName="id")}
     * )
     * @Form\Required(false)
     * @Form\Type("AceAdmin\Form\Element\ObjectLiveSearch")
     * @Form\Options({"label": "Roles", "empty_option": "Select Roles",
     *     "find_method": {
     *         "name": "findBy",
     *         "params": {"criteria": {}, "orderBy": {"name": "ASC"}}
     *     }
     * })
     * @Form\Attributes({"multiple": true})
     */
    protected $roles;

    public function __construct()
    {
        $this->roles = new ArrayCollection();
    }


    /**
     * @return string
     */
    public function __toString()
    {
        return $this->getUsername();
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
     * @Grid\Header(label="Username", default=true)
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param string $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword($password)
    {
        $userService = new UserService(); // TODO get UserService from service manager
        $this->password = $userService->makeHashedPassword($password);
    }

    /**
     * @return string
     * @Grid\Header(label="Email", sort={"email"})
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
        $this->email = $email;
    }

    /**
     * @return ArrayCollection
     */
    public function getRoles()
    {
        return $this->roles;
    }

    /**
     * @param Role $role
     * @return boolean
     */
    public function hasRole($role)
    {
        $this->roles->contains($role);
    }

    /**
     * @param ArrayCollection $roles
     */
    public function addRoles(ArrayCollection $roles)
    {
        foreach ($roles as $role) {
            $this->roles->add($role);
        }
    }

    /**
     * @param ArrayCollection $roles
     */
    public function removeRoles(ArrayCollection $roles)
    {
        foreach ($roles as $role) {
            $this->roles->removeElement($role);
        }
    }
}