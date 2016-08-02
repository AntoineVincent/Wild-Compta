<?php

namespace ComptaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Echeance
 *
 * @ORM\Table(name="echeance")
 * @ORM\Entity(repositoryClass="ComptaBundle\Repository\EcheanceRepository")
 */
class Echeance
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
     * @ORM\Column(name="iddocument", type="integer", nullable=true)
     */
    private $iddocument;

    /**
     * @var int
     *
     * @ORM\Column(name="idclient", type="integer", nullable=true)
     */
    private $idclient;

    /**
     * @var int
     *
     * @ORM\Column(name="numeroecheance", type="integer", nullable=true)
     */
    private $numeroecheance;

    /**
     * @var \string
     *
     * @ORM\Column(name="date", type="string", nullable=true)
     */
    private $date;

    /**
     * @var bool
     *
     * @ORM\Column(name="etat", type="boolean", nullable=true)
     */
    private $etat;

    /**
     * @var int
     *
     * @ORM\Column(name="montant", type="integer", nullable=true)
     */
    private $montant;


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
     * Set iddocument
     *
     * @param integer $iddocument
     * @return Echeance
     */
    public function setIddocument($iddocument)
    {
        $this->iddocument = $iddocument;

        return $this;
    }

    /**
     * Get iddocument
     *
     * @return integer 
     */
    public function getIddocument()
    {
        return $this->iddocument;
    }

    /**
     * Set idclient
     *
     * @param integer $idclient
     * @return Echeance
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
     * Set numeroecheance
     *
     * @param integer $numeroecheance
     * @return Echeance
     */
    public function setNumeroecheance($numeroecheance)
    {
        $this->numeroecheance = $numeroecheance;

        return $this;
    }

    /**
     * Get numeroecheance
     *
     * @return integer 
     */
    public function getNumeroecheance()
    {
        return $this->numeroecheance;
    }

    /**
     * Set date
     *
     * @param \string $date
     * @return Echeance
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \string 
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set etat
     *
     * @param boolean $etat
     * @return Echeance
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
     * Set montant
     *
     * @param integer $montant
     * @return Echeance
     */
    public function setMontant($montant)
    {
        $this->montant = $montant;

        return $this;
    }

    /**
     * Get montant
     *
     * @return integer 
     */
    public function getMontant()
    {
        return $this->montant;
    }
}
