<?php

namespace Orojaso\PhpTechnicalTest\Domain\Entities;

interface UserRepositoryInterface
{
    public function save(User $user): void;
    public function findById(UserId $id): ?User;
    public function delete(UserId $id): void;

    public function findByEmail(Email $email): ?User;
}
