<?php
namespace App\Entity;

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
}