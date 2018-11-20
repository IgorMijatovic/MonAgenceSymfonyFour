<?php
namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

class SearchProperty
{
    /**
     * @var int|null
     */
    private $maxPrice;


    /**
     * @var int|null
     * @Assert\Range(
     * min = 10,
     * max = 400,
     * minMessage = "Must be at least {{ limit }} tall to enter",
     * maxMessage = "Cannot be taller than {{ limit }} to enter"
     * )
     */
    private $minSurface;

    /**
     * @var ArrayCollection
     */
    private $tags;

    /**
     * @var float|null
     */
    private $lat;

    /**
     * @var float|null
     */
    private $lng;

    /**
     * @var integer|null
     */
    private $distance;

    /**
     * @var string|null
     */
    private $address;

    public function __construct()
    {
        $this->tags = new ArrayCollection();
    }

    /**
     * @return int|null
     */
    public function getMaxPrice(): ?int
    {
        return $this->maxPrice;
    }

    /**
     * @param int $maxPrice
     * @return SearchProperty
     */
    public function setMaxPrice(int $maxPrice): SearchProperty
    {
        $this->maxPrice = $maxPrice;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getMinSurface(): ?int
    {
        return $this->minSurface;
    }

    /**
     * @param int $minSurface
     * @return SearchProperty
     */
    public function setMinSurface(int $minSurface): SearchProperty
    {
        $this->minSurface = $minSurface;
        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getTags(): ArrayCollection
    {
        return $this->tags;
    }

    /**
     * @param ArrayCollection $tags
     */
    public function setTags(ArrayCollection $tags): void
    {
        $this->tags = $tags;
    }

    /**
     * @return float|null
     */
    public function getLat(): ?float
    {
        return $this->lat;
    }

    /**
     * @param float|null $lat
     * @return SearchProperty
     */
    public function setLat(?float $lat): SearchProperty
    {
        $this->lat = $lat;
        return $this;
    }

    /**
     * @return float|null
     */
    public function getLng(): ?float
    {
        return $this->lng;
    }

    /**
     * @param float|null $lng
     * @return SearchProperty
     */
    public function setLng(?float $lng): SearchProperty
    {
        $this->lng = $lng;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getDistance(): ?int
    {
        return $this->distance;
    }

    /**
     * @param int|null $distance
     * @return SearchProperty
     */
    public function setDistance(?int $distance): SearchProperty
    {
        $this->distance = $distance;
        return $this;
    }

    /**
     * @return null|string
     */
    public function getAddress(): ?string
    {
        return $this->address;
    }

    /**
     * @param null|string $address
     * @return SearchProperty
     */
    public function setAddress(?string $address): SearchProperty
    {
        $this->address = $address;
        return $this;
    }
    
}