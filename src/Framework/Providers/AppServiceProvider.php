<?php

namespace App\Framework\Providers;

use App\Domain\Exercise\ExerciseRepositoryInterface;
use App\Domain\Food\FoodLogRepositoryInterface;
use App\Domain\Food\FoodRepositoryInterface;
use App\Domain\User\LoginTokenRepositoryInterface;
use App\Domain\User\PasswordResetRequestRepositoryInterface;
use App\Domain\User\UserRepositoryInterface;
use App\Infrastructure\Persistence\MySql\MysqlExerciseRepository;
use App\Infrastructure\Persistence\MySql\MysqlFoodLogRepository;
use App\Infrastructure\Persistence\MySql\MysqlFoodRepository;
use App\Infrastructure\Persistence\MySql\MySqlLoginTokenRepository;
use App\Infrastructure\Persistence\MySql\MySqlPasswordRequestRepositoryRepository;
use App\Infrastructure\Persistence\MySql\MySqlUserRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->loadMigrationsFrom(base_path('database'));
        $this->registerRepositories();
    }

    private function registerRepositories()
    {
        $this->app->bind(
            UserRepositoryInterface::class,
            MySqlUserRepository::class
        );

        $this->app->bind(
            LoginTokenRepositoryInterface::class,
            MySqlLoginTokenRepository::class
        );

        $this->app->bind(
            PasswordResetRequestRepositoryInterface::class,
            MySqlPasswordRequestRepositoryRepository::class
        );

        $this->app->bind(
            ExerciseRepositoryInterface::class,
            MysqlExerciseRepository::class
        );

        $this->app->bind(
            FoodRepositoryInterface::class,
            MysqlFoodRepository::class
        );

        $this->app->bind(
            FoodLogRepositoryInterface::class,
            MysqlFoodLogRepository::class
        );
    }
}
