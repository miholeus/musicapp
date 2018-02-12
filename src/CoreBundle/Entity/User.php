<?php

namespace CoreBundle\Entity;

/**
 * User
 */
class User
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $firstname;

    /**
     * @var string
     */
    private $lastname;

    /**
     * @var string
     */
    private $login;

    /**
     * @var string|null
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
     */
    private $status;

    /**
     * @var \CoreBundle\Entity\UserRole
     */
    private $role;


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
}
