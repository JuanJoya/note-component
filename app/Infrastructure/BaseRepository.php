<?php

declare(strict_types=1);

namespace Note\Infrastructure;

use Illuminate\Support\Collection;
use Note\Src\Database\SimpleQuery;

abstract class BaseRepository extends SimpleQuery
{
    /**
     * @param string $query
     * @return Collection
     */
    public function all(string $query = null): Collection
    {
        return $this->mapToEntity(
            $this->getResultsFromQuery($query ?? "SELECT * FROM {$this->table()}")
        );
    }

    /**
     * @param int|string $param
     * @param string $type
     * @param string $query
     * @return Collection|object|null
     */
    public function find($param, string $type = 'id', string $query = null)
    {
        $this->bindParams = [":{$type}" => $param];
        $result = $this->getResultsFromQuery($query ?? "SELECT * FROM {$this->table()} WHERE {$type} = :{$type}");

        if (!empty($result)) {
            return (count($result) > 1)
            ? $this->mapToEntity($result)
            : $this->mapEntity(array_shift($result));
        }
    }

    /**
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        $this->bindParams = [':id' => $id];
        return $this->executeSingleQuery("DELETE FROM {$this->table()} WHERE id = :id") ? true : false;
    }

    /**
     * @param int $id
     * @return bool
     */
    public function inDatabase(int $id): bool
    {
        return !is_null($this->find($id));
    }

    /**
     * @param array $results ResultSet de la base de datos.
     * @return Collection
     */
    protected function mapToEntity(array $results): Collection
    {
        $collection = Collection::make();
        foreach ($results as $result) {
            $collection->push(
                $this->mapEntity($result)
            );
        }
        return $collection;
    }

    /**
     * @param array $attributes
     * @return void
     */
    abstract public function save(array $attributes): void;

    /**
     * @param array $attributes
     * @return void
     */
    abstract public function update(array $attributes): void;

    /**
     * @return string nombre de la tabla en la base de datos.
     */
    abstract protected function table(): string;

    /**
     * @param array $result ResultSet de la base de datos.
     * @return object
     */
    abstract protected function mapEntity(array $result): object;
}
