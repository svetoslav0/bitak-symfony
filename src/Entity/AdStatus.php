<?php

namespace App\Entity;

use App\Repository\AdStatusRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AdStatusRepository::class)
 */
class AdStatus
{

    const STATUS_WAITING = 'STATUS_WAITING';
    const STATUS_APPROVED = 'STATUS_APPROVED';
    const STATUS_REJECTED = 'STATUS_REJECTED';
    const STATUS_ARCHIVED = 'STATUS_ARCHIVED';

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @var ArrayCollection|Ad[]
     *
     * @ORM\OneToMany(targetEntity="App\Entity\Ad", mappedBy="status")
     */
    private $ads;

    public function __construct()
    {
        $this->ads = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Ad[]|ArrayCollection
     */
    public function getAds()
    {
        return $this->ads;
    }

    /**
     * @param Ad[]|ArrayCollection $ads
     */
    public function setAds($ads): void
    {
        $this->ads = $ads;
    }
}
