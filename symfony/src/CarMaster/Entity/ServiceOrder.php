<?php

declare(strict_types=1);

namespace App\CarMaster\Entity;

use App\Repository\OrderRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\ORM\Mapping\Table;

#[Entity]
#[Table(name: 'service_order')]
class ServiceOrder
{
    #[Id]
    #[GeneratedValue]
    #[Column(name: 'id_order', type: Types::INTEGER)]
    protected int $idOrder;

    #[Column(type: Types::INTEGER)]
    private int $orderName;

    #[ManyToOne(targetEntity: Vehicle::class, inversedBy: 'orders')]
    #[JoinColumn(name: 'vehicle_id', referencedColumnName: 'vehicle_id')]
    private Vehicle $vehicle;

    #[OneToMany(targetEntity: OrderItem::class, mappedBy: 'serviceOrder', cascade: ["persist"])]
    protected Collection $orderItems;

    public function __construct(Vehicle $vehicle, int $orderName)
    {
        $this->vehicle = $vehicle;
        $this->setOrderName($orderName);
        $this->orderItems = new ArrayCollection();
    }

    /*
     * Возвращает транспортное средство, связанное с этим заказом
     */
    public function getVehicle(): Vehicle
    {
        return $this->vehicle;
    }
    /*
     *устанавливает транспортное средство, связанное с этим заказом
     */
    public function setVehicle(Vehicle $vehicle): void
    {
        $this->vehicle = $vehicle;
    }

    /*
     * установка взаимной связи с OrderItem
     */

    public function addOrderItem(OrderItem $orderItem): void
    {
        if (!$this->orderItems->contains($orderItem)) {
            $this->orderItems[] = $orderItem;
            $orderItem->addServiceOrder($this);
        }
    }

    /**
     * @return Collection
     */
    public function getOrderItems(): Collection
    {
        return $this->orderItems;
    }

    /**
     * @return string
     */
    public function getOrderName(): int
    {
        return $this->orderName;
    }

    /**
     * @param string $orderName
     */
    public function setOrderName(int $orderName): void
    {
        $this->orderName = $orderName;
    }
}