<?php

namespace App\Repositories;

use App\Models\User;

interface UserRepositoryInterface
{
    public function create(array $data): User;
    public function findById(int $id): ?User;
}