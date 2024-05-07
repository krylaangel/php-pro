<?php

declare(strict_types=1);

namespace CarMaster\Repository;

use App\CarMaster\Entity\SparePart;
use PDO;
use App\CarMaster\Entity\Validator;

readonly class SparePartRepository
{
    public function __construct(private PDO $pdo)
    {
    }

    public function add(SparePart $sparePart): void
    {
        $statement = $this->pdo->prepare(
            'INSERT INTO spare_part (name_part, model_part, price_part) 
                VALUES (:namePart, :modelPart, :pricePart)'
        );
        $statement->execute([
            ':namePart' => $sparePart->getNamePart(),
            ':modelPart' => $sparePart->getModelPart(),
            ':pricePart' => $sparePart->getPricePart()
        ]);
    }

    public function delete($sparePartId): void
    {
        $statement = $this->pdo->prepare('DELETE FROM spare_part WHERE :spare_part_id');
        $statement->execute(['sparePartId' => $sparePartId]);
    }

    public function update(SparePart $sparePart): void
    {
        $statement = $this->pdo->prepare(
            'UPDATE spare_part SET name_part=:namePart, model_part=:modelPart, price_part=:pricePart WHERE spare_part_id=:spare_part_id'
        );

        $statement->execute([
            ':spare_part_id' => $sparePart->getPartId(),
            ':namePart' => $sparePart->getNamePart(),
            ':modelPart' => $sparePart->getModelPart(),
            ':pricePart' => $sparePart->getPricePart(),

        ]);
    }

    public function findByModel(string $model): ?SparePart
    {
        $statement = $this->pdo
            ->prepare('SELECT name_part, price_part, spare_part_id FROM spare_part WHERE model_part = ?');
        $statement->execute([$model]);

        $foundModel = $statement->fetchObject();

        if (!$foundModel) {
            return null;
        }
        return new SparePart(
            $foundModel->spare_part_id,
            $foundModel->name_part,
            $model,
            $foundModel->price_part,
            $validator=new Validator()
        );
    }
}


