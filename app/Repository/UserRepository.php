<?php

declare(strict_types=1);

namespace App\Repository;

/**
 * @author  Aldi Arief <aldiarief598@gmail.com>
 */
class UserRepository extends Repository
{
    public function lockForUpdateById(int $id): void
    {
        $query = $this->createQueryBuilder();

        $query->where('id', $id)
            ->lockForUpdate();
    }

    public function findOneByEmail(string $email)
    {
        $query = $this->createQueryBuilder();

        return $query
            ->where('email', $email)
            ->first();
    }
}
