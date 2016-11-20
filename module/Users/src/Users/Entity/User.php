<?php

namespace Users\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zend\Form\Annotation;

/** 
 * User
 * 
 * @ORM\Table(name="user", uniqueConstraints={@ORM\UniqueConstraint(name="UNIQ_123", columns={"usr_name"})})
 * @ORM\Entity(repositoryClass="Users\Entity\Repository\UserRepository")
 * @Annotation\Name("user")
 */
class User
{
    /** 
     * @var integer
     * 
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * 
     * @Annotation\Exclude()
     */
    private $id;

    /** 
     * @var string
     * 
     * @ORM\Column(name="usr_name", type="string", length=100, nullable=false)
     * 
     * @Annotation\Filter({"name":"stringTrim"})
     * @Annotation\Filter({"name":"stripTags"})
     * @Annotation\Attributes({"type":"text", "class":"form-control", "required":"required"})
     * @Annotation\Required({"required":"true"})
     * @Annotation\Options({"label":"Login:"})
     * @Annotation\Validator({"name":"StringLength", "options":{"min":1, "max":100}})
     */
    private $usrName;

    /** 
     * @var string
     * 
     * @ORM\Column(name="usr_password", type="string", length=100, nullable=false)
     * 
     * @Annotation\Filter({"name":"stringTrim"})
     * @Annotation\Attributes({"type":"password", "class":"form-control", "required":"required"})
     * @Annotation\Required({"required":"true"})
     * @Annotation\Options({"label":"Password:"})
     * @Annotation\Validator({"name":"StringLength", "options":{"min":1, "max":100}})
     */
    private $usrPassword;
    
    /** 
     * @var string
     * 
     * @Annotation\Type("Password")
     * @Annotation\Attributes({"type":"password", "class":"form-control"})
     * @Annotation\Options({"label":"Password confirm:"})
     * @Annotation\Validator({"name":"identical", "options":{"token":"usrPassword"}})
     */
    private $usrPasswordConfirm;
    
    /** 
     * @Annotation\Type("Zend\Form\Element\Submit")
     * @Annotation\Attributes({"value":"Enter", "id":"btn-submit", "class":"btn btn-primary", "style":"display:block"})
     * @Annotation\AllowEmpty({"allowempty":"true"})
     */
    private $submit;

    /** 
     * @var string
     * 
     * @ORM\Column(name="usr_email", type="string", length=60, nullable=false)
     * 
     * @Annotation\Type("Zend\Form\Element\Email")
     * @Annotation\Filter({"name":"stringTrim"})
     * @Annotation\Attributes({"type":"email", "class":"form-control", "required":"required"})
     * @Annotation\Required({"required":"true"})
     * @Annotation\Options({"label":"Email:"})
     * @Annotation\Validator({"name":"EmailAddress"})
     */
    private $usrEmail;

    /** 
     * @var string
     * 
     * @ORM\Column(name="usr_password_salt", type="string", length=100, nullable=true)
     * 
     * @Annotation\Attributes({"type":"text"})
     * @Annotation\Options({"label":"Salt:"})
     */
    private $usrPasswordSalt;

    /** 
     * @var \DateTime
     * 
     * @ORM\Column(name="usr_registration_date", type="datetime", nullable=true)
     * 
     * @Annotation\Attributes({"class":"form-control", "type":"datetime","min":"2010-01-01T00:00:00Z", "max":"2020-01-01T00:00:00Z", "step":"1"})
     * @Annotation\Options({"label":"Register date:"})
     */
    private $usrRegistrationDate;

    
    
    public function __construct()
    {
        $this->usrRegistrationDate = new \DateTime();
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
     * Set usrName
     *
     * @param string $usrName
     *
     * @return User
     */
    public function setUsrName($usrName)
    {
        $this->usrName = $usrName;

        return $this;
    }

    /**
     * Get usrName
     *
     * @return string
     */
    public function getUsrName()
    {
        return $this->usrName;
    }

    /**
     * Set usrPassword
     *
     * @param string $usrPassword
     *
     * @return User
     */
    public function setUsrPassword($usrPassword)
    {
        $this->usrPassword = $usrPassword;

        return $this;
    }

    /**
     * Get usrPassword
     *
     * @return string
     */
    public function getUsrPassword()
    {
        return $this->usrPassword;
    }

    /**
     * Set usrEmail
     *
     * @param string $usrEmail
     *
     * @return User
     */
    public function setUsrEmail($usrEmail)
    {
        $this->usrEmail = $usrEmail;

        return $this;
    }

    /**
     * Get usrEmail
     *
     * @return string
     */
    public function getUsrEmail()
    {
        return $this->usrEmail;
    }

    /**
     * Set usrPasswordSalt
     *
     * @param string $usrPasswordSalt
     *
     * @return User
     */
    public function setUsrPasswordSalt($usrPasswordSalt)
    {
        $this->usrPasswordSalt = $usrPasswordSalt;

        return $this;
    }

    /**
     * Get usrPasswordSalt
     *
     * @return string
     */
    public function getUsrPasswordSalt()
    {
        return $this->usrPasswordSalt;
    }

    /**
     * Set usrRegistrationDate
     *
     * @param \DateTime $usrRegistrationDate
     *
     * @return User
     */
    public function setUsrRegistrationDate($usrRegistrationDate)
    {
        $this->usrRegistrationDate = $usrRegistrationDate;

        return $this;
    }

    /**
     * Get usrRegistrationDate
     *
     * @return \DateTime
     */
    public function getUsrRegistrationDate()
    {
        return $this->usrRegistrationDate;
    }
}
