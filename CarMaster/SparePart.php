<?php

declare(strict_types=1);

namespace CarMaster;

class SparePart
{
    protected string $namePart;
    protected string $modelPart;
    protected float $pricePart;

    public function __construct(string $namePart, string $modelPart, float $pricePart)
    {
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
}