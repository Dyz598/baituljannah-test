<?php

declare(strict_types=1);

namespace App\Relation;

/**
 * @author  Aldi Arief <aldiarief598@gmail.com>
 */
class BelongsToManyMeta
{
    public function __construct(
        public ?string $table = null,
        public ?string $foreignPivotKey = null,
        public ?string $relatedPivotKey = null,
        public ?string $parentKey = null,
        public ?string $relatedKey = null,
        public ?string $relation = null,
    ) {}

    public function toArray(): array
    {
        return [
            'table'           => $this->table,
            'foreignPivotKey' => $this->foreignPivotKey,
            'relatedPivotKey' => $this->relatedPivotKey,
            'parentKey'       => $this->parentKey,
            'relatedKey'      => $this->relatedKey,
            'relation'        => $this->relation,
        ];
    }
}
