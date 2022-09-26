<?php

namespace AceUser\Entity;

use AceDatagrid\Annotation as Grid;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Laminas\Form\Annotation as Form;

/**
 * @ORM\Entity(repositoryClass="AceUser\Entity\Repository\UserRepository")
 * @ORM\Table(name="ace_user")
 * @ORM\Cache(usage="NONSTRICT_READ_WRITE")
 * @Gedmo\Loggable(logEntryClass="LogEntry")
 * @Form\Name("user")
 * @Form\Hydrator("Laminas\Hydrator\ClassMethodsHydrator")
 * @Grid\Title(singular="User", plural="Users")
 */
class User
{
    use TimestampableEntity;

    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Form\Exclude()
     */
    protected $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime")
     * @Gedmo\Timestampable(on="create")
     * @Form\Exclude()
     */
    protected $createdAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime")
     * @Gedmo\Timestampable(on="update")
     * @Form\Exclude()
     */
    protected $updatedAt;

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->getId();
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
}
