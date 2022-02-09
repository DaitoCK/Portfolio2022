<?php

namespace App\Entity;

use App\Repository\CounterRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CounterRepository::class)
 */
class Counter
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $counter_of_clients;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $counter_of_sites;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $counter_of_years_work;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $counter_of_years;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $counter_of_win;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCounterOfClients(): ?int
    {
        return $this->counter_of_clients;
    }

    public function setCounterOfClients(?int $counter_of_clients): self
    {
        $this->counter_of_clients = $counter_of_clients;

        return $this;
    }

    public function getCounterOfSites(): ?int
    {
        return $this->counter_of_sites;
    }

    public function setCounterOfSites(?int $counter_of_sites): self
    {
        $this->counter_of_sites = $counter_of_sites;

        return $this;
    }

    public function getCounterOfYearsWork(): ?int
    {
        return $this->counter_of_years_work;
    }

    public function setCounterOfYearsWork(?int $counter_of_years_work): self
    {
        $this->counter_of_years_work = $counter_of_years_work;

        return $this;
    }

    public function getCounterOfYears(): ?int
    {
        return $this->counter_of_years;
    }

    public function setCounterOfYears(?int $counter_of_years): self
    {
        $this->counter_of_years = $counter_of_years;

        return $this;
    }

    public function getCounterOfWin(): ?int
    {
        return $this->counter_of_win;
    }

    public function setCounterOfWin(?int $counter_of_win): self
    {
        $this->counter_of_win = $counter_of_win;

        return $this;
    }
}
