<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\MySql;

use Illuminate\Database\DatabaseManager;

abstract class MySqlAbstractRepository
{
    protected $queryBuilder;

    public function __construct(DatabaseManager $queryBuilder)
    {
        $this->queryBuilder = $queryBuilder;
    }
}