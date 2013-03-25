<?php

namespace BFOS\BrasilBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * BFOS\BrasilBundle\Entity\Cidade
 *
 * @ORM\Table(name="bfos_cidades")
 * @ORM\Entity
 */
class Cidade
{
    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string $nome
     *
     * @ORM\Column(name="nome", type="string", length=100)
     */
    private $nome;

    /**
     * @var string $uf
     *
     * @ORM\Column(name="uf", type="string", length=2)
     */
    private $uf;

    /**
     * Código do munício segundo a tabela do IBGE.
     *
     * @var string $codigoIbge
     *
     * @ORM\Column(name="codigo_ibge", type="string", length=10)
     */
    private $codigoIbge;

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
     * Set nome
     *
     * @param string $nome
     * @return Cidade
     */
    public function setNome($nome)
    {
        $this->nome = $nome;
        return $this;
    }

    /**
     * Get nome
     *
     * @return string 
     */
    public function getNome()
    {
        return $this->nome;
    }

    /**
     * Set uf
     *
     * @param string $uf
     * @return Cidade
     */
    public function setUf($uf)
    {
        $this->uf = $uf;
        return $this;
    }

    /**
     * Get uf
     *
     * @return string 
     */
    public function getUf()
    {
        return $this->uf;
    }

    /**
     * Set Código IBGE
     *
     * @param string $codigoIbge
     * @return Cidade
     */
    public function setCodigoIbge($codigoIbge)
    {
        $this->codigoIbge = $codigoIbge;
        return $this;
    }

    /**
     * Get Código IBGE
     *
     * @return string
     */
    public function getCodigoIbge()
    {
        return $this->codigoIbge;
    }

    function __toString()
    {
        return sprintf('%s-%s', $this->getNome(), $this->getUf());
    }


}