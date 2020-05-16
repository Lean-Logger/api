<?php

declare(strict_types=1);

namespace App\UseCases\EditExercise;

/**
 * @OA\Schema(
 *     schema="EditExerciseRequest",
 *     title="Edit an existing exercise",
 *     required={"name", "type"},
 *     properties={
 *          @OA\Property(property="name", type="string", example="Bicep Curl Machine"),
 *          @OA\Property(property="description", type="string", example="The machine near the AC unit"),
 *          @OA\Property(property="type", type="string", enum={"weighted_reps", "non_weighted_reps", "duration"}),
 *     }
 * )
 */
final class EditExerciseRequest
{
    private $exerciseId;

    private $userId;

    private $name;

    private $description;

    private $type;

    public function __construct($exerciseId, $userId, $name, $description, $type)
    {
        $this->exerciseId = $exerciseId;
        $this->userId = $userId;
        $this->name = $name;
        $this->description = $description;
        $this->type = $type;
    }

    public function getExerciseId()
    {
        return $this->exerciseId;
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