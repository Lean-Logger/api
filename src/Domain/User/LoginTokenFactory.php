<?php

declare(strict_types=1);

namespace App\Domain\User;

final class LoginTokenFactory {

    public function createFromDatabaseRow(array $row): LoginToken
    {
        return (new LoginToken())
            ->setId((int) $row['id'])
            ->setUserId($row['user_id'])
            ->setToken($row['token'])
            ->setCreatedAt(new \DateTime($row['created_at']))
        ;
    }

}