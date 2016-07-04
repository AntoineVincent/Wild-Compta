<?php

namespace ClientBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Client
 *
 * @ORM\Table(name="client")
 * @ORM\Entity(repositoryClass="ClientBundle\Repository\ClientRepository")
 */
class Client
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(name="idpipedrive", type="integer", nullable=true)
     */
    private $idpipedrive;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=255, nullable=true)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=255, nullable=true)
     */
    private $type;

    /**
     * @var string
     *
     * @ORM\Column(name="adresse", type="string", length=255, nullable=true)
     */
    private $adresse;

    /**
     * @var string
     *
     * @ORM\Column(name="adressefactu", type="string", length=255, nullable=true)
     */
    private $adressefactu;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255, nullable=true)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="orgapayeur", type="string", nullable=true)
     */
    private $orgapayeur;

    /**
     * @var string
     *
     * @ORM\Column(name="bourse", type="string", nullable=true)
     */
    private $bourse;

    /**
     * @var string
     *
     * @ORM\Column(name="telephonefixe", type="string", nullable=true)
     */
    private $telephonefixe;

    /**
     * @var string
     *
     * @ORM\Column(name="portable", type="string", nullable=true)
     */
    private $portable;

    /**
     * @var string
     *
     * @ORM\Column(name="idecole", type="string", nullable=true)
     */
    private $idecole;

    /**
     * @var int
     *
     * @ORM\Column(name="value", type="integer", nullable=true)
     */
    private $value;

    /**
     * Set id
     *
     * @param integer $id
     * @return Client
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
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
     * Set idpipedrive
     *
     * @param integer $idpipedrive
     * @return Client
     */
    public function setIdpipedrive($idpipedrive)
    {
        $this->idpipedrive = $idpipedrive;

        return $this;
    }

    /**
     * Get idpipedrive
     *
     * @return integer 
     */
    public function getIdpipedrive()
    {
        return $this->idpipedrive;
    }

    /**
     * Set nom
     *
     * @param string $nom
     * @return Client
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string 
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set type
     *
     * @param string $type
     * @return Client
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string 
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set adresse
     *
     * @param string $adresse
     * @return Client
     */
    public function setAdresse($adresse)
    {
        $this->adresse = $adresse;

        return $this;
    }

    /**
     * Get adresse
     *
     * @return string 
     */
    public function getAdresse()
    {
        return $this->adresse;
    }

    /**
     * Set adressefactu
     *
     * @param string $adressefactu
     * @return Client
     */
    public function setAdressefactu($adressefactu)
    {
        $this->adressefactu = $adressefactu;

        return $this;
    }

    /**
     * Get adressefactu
     *
     * @return string 
     */
    public function getAdressefactu()
    {
        return $this->adressefactu;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return Client
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set orgapayeur
     *
     * @param string $orgapayeur
     * @return Client
     */
    public function setOrgapayeur($orgapayeur)
    {
        $this->orgapayeur = $orgapayeur;

        return $this;
    }

    /**
     * Get orgapayeur
     *
     * @return string 
     */
    public function getOrgapayeur()
    {
        return $this->orgapayeur;
    }

    /**
     * Set bourse
     *
     * @param string $bourse
     * @return Client
     */
    public function setBourse($bourse)
    {
        $this->bourse = $bourse;

        return $this;
    }

    /**
     * Get bourse
     *
     * @return string 
     */
    public function getBourse()
    {
        return $this->bourse;
    }

    /**
     * Set telephonefixe
     *
     * @param string $telephonefixe
     * @return Client
     */
    public function setTelephonefixe($telephonefixe)
    {
        $this->telephonefixe = $telephonefixe;

        return $this;
    }

    /**
     * Get telephonefixe
     *
     * @return string 
     */
    public function getTelephonefixe()
    {
        return $this->telephonefixe;
    }

    /**
     * Set portable
     *
     * @param string $portable
     * @return Client
     */
    public function setPortable($portable)
    {
        $this->portable = $portable;

        return $this;
    }

    /**
     * Get portable
     *
     * @return string 
     */
    public function getPortable()
    {
        return $this->portable;
    }

    /**
     * Set idecole
     *
     * @param string $idecole
     * @return Client
     */
    public function setIdecole($idecole)
    {
        $this->idecole = $idecole;

        return $this;
    }

    /**
     * Get idecole
     *
     * @return string 
     */
    public function getIdecole()
    {
        return $this->idecole;
    }

    /**
     * Set value
     *
     * @param integer $value
     * @return Client
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Get value
     *
     * @return integer 
     */
    public function getValue()
    {
        return $this->value;
    }
}
