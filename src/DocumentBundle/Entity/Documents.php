<?php

namespace DocumentBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Document
 *
 * @ORM\Table(name="document")
 * @ORM\Entity(repositoryClass="DocumentBundle\Repository\DocumentRepository")
 */
class Documents
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
     * @ORM\Column(name="idclient", type="integer", nullable=true)
     */
    private $idclient;

    /**
     * @var int
     *
     * @ORM\Column(name="idproduct", type="integer", nullable=true)
     */
    private $idproduct;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=255, nullable=true)
     */
    private $type;

    /**
     * @var string
     *
     * @ORM\Column(name="reference", type="string", length=255, nullable=true)
     */
    private $reference;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="datecreation", type="date", nullable=true)
     */
    private $datecreation;

    /**
     * @var bool
     *
     * @ORM\Column(name="etat", type="boolean", nullable=true)
     */
    private $etat;

    /**
     * @var int
     *
     * @ORM\Column(name="nbreecheance", type="integer", nullable=true)
     */
    private $nbreecheance;

    /**
     * @var int
     *
     * @ORM\Column(name="value", type="integer", nullable=true)
     */
    private $value;


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
     * Set idclient
     *
     * @param integer $idclient
     * @return Document
     */
    public function setIdclient($idclient)
    {
        $this->idclient = $idclient;

        return $this;
    }

    /**
     * Get idclient
     *
     * @return integer 
     */
    public function getIdclient()
    {
        return $this->idclient;
    }

    /**
     * Set idproduct
     *
     * @param integer $idproduct
     * @return Document
     */
    public function setIdproduct($idproduct)
    {
        $this->idproduct = $idproduct;

        return $this;
    }

    /**
     * Get idproduct
     *
     * @return integer 
     */
    public function getIdproduct()
    {
        return $this->idproduct;
    }

    /**
     * Set type
     *
     * @param string $type
     * @return Document
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
     * Set reference
     *
     * @param string $reference
     * @return Document
     */
    public function setReference($reference)
    {
        $this->reference = $reference;

        return $this;
    }

    /**
     * Get reference
     *
     * @return string 
     */
    public function getReference()
    {
        return $this->reference;
    }

    /**
     * Set datecreation
     *
     * @param \DateTime $datecreation
     * @return Document
     */
    public function setDatecreation($datecreation)
    {
        $this->datecreation = $datecreation;

        return $this;
    }

    /**
     * Get datecreation
     *
     * @return \DateTime 
     */
    public function getDatecreation()
    {
        return $this->datecreation;
    }

    /**
     * Set etat
     *
     * @param boolean $etat
     * @return Document
     */
    public function setEtat($etat)
    {
        $this->etat = $etat;

        return $this;
    }

    /**
     * Get etat
     *
     * @return boolean 
     */
    public function getEtat()
    {
        return $this->etat;
    }

    /**
     * Set nbreecheance
     *
     * @param integer $nbreecheance
     * @return Document
     */
    public function setNbreecheance($nbreecheance)
    {
        $this->nbreecheance = $nbreecheance;

        return $this;
    }

    /**
     * Get nbreecheance
     *
     * @return integer 
     */
    public function getNbreecheance()
    {
        return $this->nbreecheance;
    }

    /**
     * Set value
     *
     * @param integer $value
     * @return Document
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
