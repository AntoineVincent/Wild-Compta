<?php

namespace ComptaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Reglement
 *
 * @ORM\Table(name="reglement")
 * @ORM\Entity(repositoryClass="ComptaBundle\Repository\ReglementRepository")
 */
class Reglement
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
     * @var float
     *
     * @ORM\Column(name="montant", type="float", nullable=true)
     */
    private $montant;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="datereg", type="datetime", nullable=true)
     */
    private $datereg;

    /**
     * @var string
     *
     * @ORM\Column(name="modereg", type="string", length=255, nullable=true)
     */
    private $modereg;

    /**
     * @var string
     *
     * @ORM\Column(name="numerochq", type="string", nullable=true)
     */
    private $numerochq;

    /**
     * @var string
     *
     * @ORM\Column(name="emetteur", type="string", length=255, nullable=true)
     */
    private $emetteur;

    /**
     * @var string
     *
     * @ORM\Column(name="banque", type="string", length=255, nullable=true)
     */
    private $banque;


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
     * @return Reglement
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
     * Set montant
     *
     * @param float $montant
     * @return Reglement
     */
    public function setMontant($montant)
    {
        $this->montant = $montant;

        return $this;
    }

    /**
     * Get montant
     *
     * @return float 
     */
    public function getMontant()
    {
        return $this->montant;
    }

    /**
     * Set datereg
     *
     * @param \DateTime $datereg
     * @return Reglement
     */
    public function setDatereg($datereg)
    {
        $this->datereg = $datereg;

        return $this;
    }

    /**
     * Get datereg
     *
     * @return \DateTime 
     */
    public function getDatereg()
    {
        return $this->datereg;
    }

    /**
     * Set modereg
     *
     * @param string $modereg
     * @return Reglement
     */
    public function setModereg($modereg)
    {
        $this->modereg = $modereg;

        return $this;
    }

    /**
     * Get modereg
     *
     * @return string 
     */
    public function getModereg()
    {
        return $this->modereg;
    }

    /**
     * Set numerochq
     *
     * @param string $numerochq
     * @return Reglement
     */
    public function setNumerochq($numerochq)
    {
        $this->numerochq = $numerochq;

        return $this;
    }

    /**
     * Get numerochq
     *
     * @return string 
     */
    public function getNumerochq()
    {
        return $this->numerochq;
    }

    /**
     * Set emetteur
     *
     * @param string $emetteur
     * @return Reglement
     */
    public function setEmetteur($emetteur)
    {
        $this->emetteur = $emetteur;

        return $this;
    }

    /**
     * Get emetteur
     *
     * @return string 
     */
    public function getEmetteur()
    {
        return $this->emetteur;
    }

    /**
     * Set banque
     *
     * @param string $banque
     * @return Reglement
     */
    public function setBanque($banque)
    {
        $this->banque = $banque;

        return $this;
    }

    /**
     * Get banque
     *
     * @return string 
     */
    public function getBanque()
    {
        return $this->banque;
    }
}
