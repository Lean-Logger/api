<?php

declare(strict_types=1);

namespace App\Domain\Exercise;

final class ExerciseFactory {

    public function createFromDatabaseRow(array $row): Exercise
    {
        return (new Exercise())
            ->setId((int) $row['id'])
            ->setUserId($row['user_id'])
            ->setName($row['name'])
            ->setDescription($row['description'])
            ->setType($row['type'])
            ->setCreatedAt(new \DateTime($row['created_at']))
            ->setUpdatedAt(new \DateTime($row['updated_at']))
            ;
    }

}