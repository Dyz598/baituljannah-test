<?php

declare(strict_types=1);

namespace App\Enum;

/**
 * @author  Aldi Arief <aldiarief598@gmail.com>
 */
trait EnumBehaviourTrait
{
    public function is($enumerator): bool
    {
        return $this === $enumerator || $this->value === $enumerator;
    }

    public function getValue(): string|int
    {
        return $this->value;
    }

    public static function getValues(): array
    {
        return collect(self::cases())->map(function ($item) {
            return $item->value;
        })->toArray();
    }
}
