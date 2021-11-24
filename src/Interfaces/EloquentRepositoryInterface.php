<?php

namespace Maarsson\Repository\Interfaces;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * This interface describes an eloquent repository interface.
 */
interface EloquentRepositoryInterface
{
    /**
     * Creates a new model instance
     *
     * @return Model
     */
    public function model(): Model;

    /**
     * Return with column filter array
     *
     * @return array
     */
    public function columns(array $columns = []): array;

    /**
     * Gets all entity.
     * Returned columns can be filtered
     *
     * @param string... $columns
     *
     * @return Illuminate\Database\Eloquent\Model
     */
    public function all(string ...$columns): Collection;

    /**
     * Creates a new entity.
     *
     * @param array $attributes
     *
     * @return Illuminate\Database\Eloquent\Model
     */
    public function create(array $attributes): Model;

    /**
     * Finds an entity by its ID.
     * Returned columns can be filtered
     *
     * @param mixed $id
     * @param string... $columns
     *
     * @return Illuminate\Database\Eloquent\Model
     */
    public function find($id, string ...$columns): ?Model;

    /**
     * Finds an entity by custom column.
     * Returned columns can be filtered
     *
     * @param mixed $id
     * @param string... $columns
     *
     * @return Illuminate\Database\Eloquent\Model|Illuminate\Support\Collection
     */
    public function findBy(string $column, $value = null, string ...$columns): ?Collection;
}
