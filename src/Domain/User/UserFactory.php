<?php

declare(strict_types=1);

namespace App\Domain\User;

final class UserFactory {

    public function createFromDatabaseRow(array $row): User
    {
        return (new User())
            ->setId((int) $row['id'])
            ->setEmail($row['email'])
            ->setOptIn((bool) $row['opt_in'])
            ->setPassword($row['password'])
            ->setCreatedAt(new \DateTime($row['created_at']))
        ;
    }

}