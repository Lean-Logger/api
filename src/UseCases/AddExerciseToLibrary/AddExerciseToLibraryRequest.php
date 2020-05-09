<?php

declare(strict_types=1);

namespace App\UseCases\AddExerciseToLibrary;

/**
 * @OA\Schema(
 *     schema="AddExerciseToLibraryRequest",
 *     title="Add exercise to library request",
 *     required={"user_id","name", "type"},
 *     properties={
 *          @OA\Property(property="user_id", type="number"),
 *          @OA\Property(property="name", type="string", example="Bicep Curl Machine"),
 *          @OA\Property(property="description", type="string", example="The machine near the AC unit"),
 *          @OA\Property(property="type", type="string", enum={"weighted_reps", "non_weighted_reps", "duration"}),
 *     }
 * )
 */
final class AddExerciseToLibraryRequest
{
    private $userId;

    private $name;

    private $description;

    private $type;

    public function __construct($userId, $name, $description, $type)
    {
        $this->userId = $userId;
        $this->name = $name;
        $this->description = $description;
        $this->type = $type;
    }

    public function getUserId()
    {
        return $this->userId;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function getType()
    {
        return $this->type;
    }

    public function toArray()
    {
        return [
            'user_id' => $this->getUserId(),
            'name' => $this->getName(),
            'description' => $this->getDescription(),
            'type' => $this->getType(),
        ];
    }
}