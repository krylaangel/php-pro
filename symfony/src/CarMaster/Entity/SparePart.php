<?php

declare(strict_types=1);

namespace App\CarMaster\Entity;

use App\Repository\SparePartRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping\{Column, Entity, GeneratedValue, Id, ManyToMany, OneToMany, Table};
use JsonSerializable;
use Symfony\Component\Validator\Constraints as Assert;

#[Entity(repositoryClass: SparePartRepository::class)]
#[Table(name: 'spare_part')]
class SparePart implements JsonSerializable
{
    #[Id]
    #[GeneratedValue]
    #[Column(name: 'spare_part_id', type: Types::INTEGER)]
    protected int $partId;

    #[Column(name: 'name_part', length: 60)]
    #[Assert\Length(min: 5, minMessage: 'Name part must be at least {{ limit }} characters long'
    )]
    protected string $namePart;

    #[Column(name: 'model_part', length: 60)]
    #[Assert\Length(min: 4, minMessage: 'Model part must be at least {{ limit }} characters long')]
    protected string $modelPart;

    #[Column(name: 'price_part', type: Types::FLOAT)]
    #[Assert\GreaterThan(value: 0)]
    protected float $pricePart;

    #[ManyToMany(targetEntity: Vehicle::class, mappedBy: 'spareParts')]
    private Collection $vehicles;

    #[OneToMany(targetEntity: OrderItem::class, mappedBy: 'spare_part', cascade: ["persist"])]
    protected Collection $orderItems;

    public function __construct(
//        string $namePart,
//        string $modelPart,
//        float $pricePart
    ) {
        $this->vehicles = new ArrayCollection();
        $this->orderItems = new ArrayCollection();
//        $this->setNamePart($namePart);
//        $this->setModelPart($modelPart);
//        $this->setPricePart($pricePart);
    }

    /*
     * получаем инфо о запчасти
     */
    public function getPartInfo(): array
    {
        return [
            'Name Part' => $this->getNamePart(),
            'Model Part' => $this->getModelPart(),
            'Price Part' => $this->getPricePart()
        ];
    }

    /*
     * взаимная связка с транспортными средствами
     */
    public function addVehicle(Vehicle $vehicle): void
    {
        if (!$this->vehicles->contains($vehicle)) {
            $this->vehicles[] = $vehicle;
            $vehicle->addSpareParts($this);
        }
    }

    public function getVehicles(): Collection
    {
        return $this->vehicles;
    }
    public function removeVehicle(Vehicle $vehicle): void
    {
        $this->vehicles->removeElement($vehicle);
        $vehicle->removeSparePart($this);
    }
    /*
     * взаимная связка с таблицей OrderItem
     */
    public function addOrderItem(OrderItem $orderItem): void
    {
        if (!$this->orderItems->contains($orderItem)) {
            $this->orderItems[] = $orderItem;
            $orderItem->addSpareParts($this);
        }
    }

    public function getOrderItem(): Collection
    {
        return $this->orderItems;
    }

    public function getModelPart(): string
    {
        return $this->modelPart;
    }

    public function setModelPart(string $modelPart): void
    {
        $this->modelPart = $modelPart;
    }

    public function getNamePart(): string
    {
        return $this->namePart;
    }

    public function setNamePart(string $namePart): void
    {
        $this->namePart = $namePart;
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
    }

    /**
     * @return int
     */
    public function getPartId(): int
    {
        return $this->partId;
    }

    public function jsonSerialize(): array
    {
        return $this->getPartInfo();
    }
}