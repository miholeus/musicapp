<?php

namespace CoreBundle\Entity;

use Symfony\Component\Security\Core\User\AdvancedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * User
 *
 * @UniqueEntity(
 *     fields = {"email"},
 *     errorPath = "email",
 *     message = "This email is already in use"
 * )
 * @UniqueEntity(
 *     fields = {"login"},
 *     errorPath = "login",
 *     message = "This login is already in use"
 * )
 */
class User implements UserInterface, \Serializable, AdvancedUserInterface
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     * @Assert\NotBlank()
     * @Assert\Length(min=3, max=50)
     */
    private $firstname;

    /**
     * @var string
     * @Assert\NotBlank()
     * @Assert\Length(min=3, max=50)
     */
    private $lastname;

    /**
     * @var string
     * @Assert\NotBlank()
     */
    private $login;

    /**
     * @var string|null
     * @Assert\Email()
     */
    private $email;

    /**
     * @var string
     */
    private $password;

    /**
     * @var \DateTime|null
     */
    private $lastLoginOn;

    /**
     * @var \DateTime|null
     */
    private $createdOn;

    /**
     * @var \DateTime|null
     */
    private $updatedOn;

    /**
     * @var bool|null
     */
    private $isActive;

    /**
     * @var bool
     */
    private $isBlocked = false;

    /**
     * @var bool
     */
    private $isDeleted = false;

    /**
     * @var bool|null
     */
    private $isSuperuser;

    /**
     * @var \CoreBundle\Entity\UserStatus
     * @Assert\NotBlank()
     */
    private $status;

    /**
     * Main user role
     *
     * @var \CoreBundle\Entity\UserRole
     * @Assert\NotBlank()
     */
    private $role;

    /**
     * List of user roles
     *
     * @var array
     */
    private $roles = [];

    public function isAccountNonExpired()
    {
        return !$this->isDeleted;
    }

    public function isAccountNonLocked()
    {
        return !$this->isBlocked;
    }

    public function isCredentialsNonExpired()
    {
        return true;
    }

    public function isEnabled()
    {
        return $this->isActive;
    }

    public function serialize()
    {
        return serialize([
            $this->id,
            $this->login,
            $this->password,
            $this->roles,
            $this->isActive
        ]);
    }

    public function unserialize($serialized)
    {
        list(
            $this->id,
            $this->login,
            $this->password,
            $this->roles,
            $this->isActive
            ) = unserialize($serialized);
    }


    public function getRoles()
    {
        $roles = $this->roles;
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles)
    {
        $this->roles = $roles;
    }


    /**
     * Add user role
     *
     * @param $role
     */
    public function addRole($role)
    {
        $this->roles[] = $role;
    }

    public function getUsername()
    {
        return $this->login;
    }

    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
    }


    /**
     * @param array $data
     * @return User
     */
    public static function fromArray(array $data)
    {
        $self = new self();
        foreach ($data as $key => $value) {
            $self->{"set" . ucfirst($key)}($value);
        }

        return $self;
    }

    public function __construct(array $data = array())
    {
        if (!empty($data)) {
            $this->setFromArray($data);
        } else {
            $this->createdOn = new \DateTime();
        }

        $this->updatedOn = new \DateTime();
    }


    public function __toString()
    {
        return sprintf("%s %s", $this->getFirstname(), $this->getLastname());
    }

    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set firstname.
     *
     * @param string $firstname
     *
     * @return User
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * Get firstname.
     *
     * @return string
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * Set lastname.
     *
     * @param string $lastname
     *
     * @return User
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * Get lastname.
     *
     * @return string
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * Set login.
     *
     * @param string $login
     *
     * @return User
     */
    public function setLogin($login)
    {
        $this->login = $login;

        return $this;
    }

    /**
     * Get login.
     *
     * @return string
     */
    public function getLogin()
    {
        return $this->login;
    }

    /**
     * Set email.
     *
     * @param string|null $email
     *
     * @return User
     */
    public function setEmail($email = null)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email.
     *
     * @return string|null
     */
    public function getEmail()
    {
        return $this->email;
    }


    /**
     * Get salt
     *
     * @return string
     */
    public function getSalt()
    {
        // no salt used
    }
    /**
     * Set password.
     *
     * @param string $password
     *
     * @return User
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password.
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set lastLoginOn.
     *
     * @param \DateTime|null $lastLoginOn
     *
     * @return User
     */
    public function setLastLoginOn($lastLoginOn = null)
    {
        $this->lastLoginOn = $lastLoginOn;

        return $this;
    }

    /**
     * Get lastLoginOn.
     *
     * @return \DateTime|null
     */
    public function getLastLoginOn()
    {
        return $this->lastLoginOn;
    }

    /**
     * Set createdOn.
     *
     * @param \DateTime|null $createdOn
     *
     * @return User
     */
    public function setCreatedOn($createdOn = null)
    {
        $this->createdOn = $createdOn;

        return $this;
    }

    /**
     * Get createdOn.
     *
     * @return \DateTime|null
     */
    public function getCreatedOn()
    {
        return $this->createdOn;
    }

    /**
     * Set updatedOn.
     *
     * @param \DateTime|null $updatedOn
     *
     * @return User
     */
    public function setUpdatedOn($updatedOn = null)
    {
        $this->updatedOn = $updatedOn;

        return $this;
    }

    /**
     * Get updatedOn.
     *
     * @return \DateTime|null
     */
    public function getUpdatedOn()
    {
        return $this->updatedOn;
    }

    /**
     * Set isActive.
     *
     * @param bool|null $isActive
     *
     * @return User
     */
    public function setIsActive($isActive = null)
    {
        $this->isActive = $isActive;

        return $this;
    }

    /**
     * Get isActive.
     *
     * @return bool|null
     */
    public function getIsActive()
    {
        return $this->isActive;
    }

    /**
     * Set isBlocked.
     *
     * @param bool $isBlocked
     *
     * @return User
     */
    public function setIsBlocked($isBlocked)
    {
        $this->isBlocked = $isBlocked;

        return $this;
    }

    /**
     * Get isBlocked.
     *
     * @return bool
     */
    public function getIsBlocked()
    {
        return $this->isBlocked;
    }

    /**
     * Set isDeleted.
     *
     * @param bool $isDeleted
     *
     * @return User
     */
    public function setIsDeleted($isDeleted)
    {
        $this->isDeleted = $isDeleted;

        return $this;
    }

    /**
     * Get isDeleted.
     *
     * @return bool
     */
    public function getIsDeleted()
    {
        return $this->isDeleted;
    }

    /**
     * Set isSuperuser.
     *
     * @param bool|null $isSuperuser
     *
     * @return User
     */
    public function setIsSuperuser($isSuperuser = null)
    {
        $this->isSuperuser = $isSuperuser;

        return $this;
    }

    /**
     * Get isSuperuser.
     *
     * @return bool|null
     */
    public function getIsSuperuser()
    {
        return $this->isSuperuser;
    }

    /**
     * Set status.
     *
     * @param \CoreBundle\Entity\UserStatus $status
     *
     * @return User
     */
    public function setStatus(\CoreBundle\Entity\UserStatus $status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status.
     *
     * @return \CoreBundle\Entity\UserStatus
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set role.
     *
     * @param \CoreBundle\Entity\UserRole $role
     *
     * @return User
     */
    public function setRole(\CoreBundle\Entity\UserRole $role)
    {
        $this->role = $role;

        return $this;
    }

    /**
     * Get role.
     *
     * @return \CoreBundle\Entity\UserRole
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * Set data from array
     *
     * @param array $data
     */
    public function setFromArray(array $data)
    {
        foreach ($data as $key => $value) {
            $this->{"set" . ucfirst($key)}($value);
        }
    }
}
