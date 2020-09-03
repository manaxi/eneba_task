<?php

namespace App\Entity;

use App\Repository\ExpressionRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ExpressionRepository::class)
 */
class Expression
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     */
    private $text;

    /**
     * @ORM\Column(type="text")
     */
    private $userAddr;

    // Getters & Setters
    public function getId(): ?int
    {
        return $this->id;
    }
    public function setText($text)
    {
        $this->text = $text;
    }
    public function getText()
    {
        return $this->text;
    }
    public function setUserAddr($userAddr)
    {
        $this->userAddr = $userAddr;
    }
    public function getUserAddr()
    {
        return $this->userAddr;
    }
}
