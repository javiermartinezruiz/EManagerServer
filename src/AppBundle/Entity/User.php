<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\ORM\Mapping\ManyToMany;
use Doctrine\ORM\Mapping\JoinTable;
use Doctrine\ORM\Mapping\JoinColumns;
use Doctrine\ORM\Mapping\JoinColumn;

/**
 * User
 *
 * @ORM\Table(name="users")
 * @ORM\Entity(repositoryClass="AppBundle\Entity\UserRepository")
 */
class User implements UserInterface, \Serializable
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var boolean
     *
     * @ORM\Column(name="status", type="boolean")
     */
    private $status;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="create_date", type="datetime")
     */
    private $createDate;

    /**
     * @var string
     *
     * @ORM\Column(name="create_user", type="string", length=255)
     */
    private $createUser;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="write_date", type="datetime")
     */
    private $writeDate;

    /**
     * @var string
     *
     * @ORM\Column(name="write_user", type="string", length=255)
     */
    private $writeUser;

    /**
     * @var string
     *
     * @ORM\Column(name="username", type="string", length=255)
     */
    private $username;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=255)
     */
    private $password;

    /**
     * @var string
     *
     * @ORM\Column(name="complete_name", type="string", length=255)
     */
    private $completeName;


    /**
     * @ManyToMany(targetEntity="Role", inversedBy="users")
     * @JoinTable(
     *      name="users_roles",
     *      joinColumns={@JoinColumn(name="users_id", referencedColumnName="id")},
     *      inverseJoinColumns={@JoinColumn(name="roles_id", referencedColumnName="id")}
     * )
     */
    private $roles;


    /**
     * @ORM\Column(name="is_active", type="boolean")
     */
    private $isActive;

    public function __construct(){
        $this->isActive = true;
        // may not be needed, see section on salt below
        // $this->salt = md5(uniqid(null, true));
        //$this->roles = new \Doctrine\Common\Collections\ArrayCollection();
    }


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set status
     *
     * @param boolean $status
     * @return User
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return boolean 
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set createDate
     *
     * @param \DateTime $createDate
     * @return User
     */
    public function setCreateDate($createDate)
    {
        $this->createDate = $createDate;

        return $this;
    }

    /**
     * Get createDate
     *
     * @return \DateTime 
     */
    public function getCreateDate()
    {
        return $this->createDate;
    }

    /**
     * Set createUser
     *
     * @param string $createUser
     * @return User
     */
    public function setCreateUser($createUser)
    {
        $this->createUser = $createUser;

        return $this;
    }

    /**
     * Get createUser
     *
     * @return string 
     */
    public function getCreateUser()
    {
        return $this->createUser;
    }

    /**
     * Set writeDate
     *
     * @param \DateTime $writeDate
     * @return User
     */
    public function setWriteDate($writeDate)
    {
        $this->writeDate = $writeDate;

        return $this;
    }

    /**
     * Get writeDate
     *
     * @return \DateTime 
     */
    public function getWriteDate()
    {
        return $this->writeDate;
    }

    /**
     * Set writeUser
     *
     * @param string $writeUser
     * @return User
     */
    public function setWriteUser($writeUser)
    {
        $this->writeUser = $writeUser;

        return $this;
    }

    /**
     * Get writeUser
     *
     * @return string 
     */
    public function getWriteUser()
    {
        return $this->writeUser;
    }

    /**
     * Set username
     *
     * @param string $username
     * @return User
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get username
     *
     * @return string 
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set password
     *
     * @param string $password
     * @return User
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string 
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set completeName
     *
     * @param string $completeName
     * @return User
     */
    public function setCompleteName($completeName)
    {
        $this->completeName = $completeName;

        return $this;
    }

    /**
     * Get completeName
     *
     * @return string 
     */
    public function getCompleteName()
    {
        return $this->completeName;
    }

    /**
     * Get roles
     *
     * @return array
     */
    public function getRoles(){
        $roles = array();
        $theRoles = $this->roles;
        foreach($theRoles as $role){
            array_push($roles, $role->getName());
        }
        return $roles;
        //return $this->roles;
    }

    /**
     * Set roles
     *
     * @param array $roles
     * @return User
     */
    public function setRoles($roles){
        $this->roles = $roles;

        return $this;
    }

    public function getSalt()
    {
        // you *may* need a real salt depending on your encoder
        // see section on salt below
        return null;
    }

    public function eraseCredentials()
    {

    }

    /** @see \Serializable::serialize() */
    public function serialize()
    {
        return serialize(array(
            $this->id,
            $this->username,
            $this->password,
            // see section on salt below
            // $this->salt,
        ));
    }

    /** @see \Serializable::unserialize() */
    public function unserialize($serialized)
    {
        list (
            $this->id,
            $this->username,
            $this->password,
            // see section on salt below
            // $this->salt
            ) = unserialize($serialized);
    }

}
