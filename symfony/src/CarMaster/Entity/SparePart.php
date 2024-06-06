<?php

declare(strict_types=1);

namespace App\CarMaster\Entity;

use App\Repository\SparePartRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping\{Column, Entity, GeneratedValue, Id, ManyToMany, Table};

#[Entity(repositoryClass: SparePartRepository::class)]
#[Table(name: 'spare_part')]
class SparePart
{
    protected Validator $validator;
    #[Id]
    #[GeneratedValue]
    #[Column(name: 'spare_part_id', type: Types::INTEGER)]
    protected ?int $partId;

    #[Column(name: 'name_part', length: 60)]
    protected string $namePart;

    #[Column(name: 'model_part', length: 60)]
    protected string $modelPart;

    #[Column(name: 'price_part', type: Types::FLOAT)]
    protected float $pricePart;

    #[ManyToMany(targetEntity: Vehicle::class, mappedBy: 'spareParts')]
    private Collection $vehicles;

    public function __construct(
        string $namePart,
        string $modelPart,
        float $pricePart,
        Validator $validator
    ) {
        $this->validator = $validator;
        $this->vehicles = new ArrayCollection();
        $this->setNamePart($namePart);
        $this->setModelPart($modelPart);
        $this->setPricePart($pricePart);
    }

    public function getPartInfo(): array
    {
        return [
            'Name Part' => $this->getNamePart(),
            'Model Part' => $this->getModelPart(),
            'Price Part' => $this->getPricePart()
        ];
    }


    public function addVehicle(Vehicle $vehicle): void
    {
        if (!$this->vehicles->contains($vehicle)) {
            $this->vehicles[] = $vehicle;
            $vehicle->addSpareParts($this);
        }
    }

    public function getModelPart(): string
    {
        return $this->modelPart;
    }

    public function setModelPart(string $modelPart): void
    {
        $this->modelPart = $modelPart;
        $this->validator->verifyInputFields($modelPart);
    }

    public function getNamePart(): string
    {
        return $this->namePart;
    }

    public function setNamePart(string $namePart): void
    {
        $this->namePart = $namePart;
        $this->validator->verifyInputFields($namePart);
    }

    public function getPricePart(): float
    {
        return $this->pricePart;
    }

    /**
     * @param float $pricePart
     */
    public function setPricePart(float $pricePart): void
    {
        $this->pricePart = $pricePart;
        $this->validator->checkMinimumValue($pricePart);
    }

}