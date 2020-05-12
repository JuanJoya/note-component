<?php

declare(strict_types=1);

namespace Note\Infrastructure;

use Illuminate\Support\Collection;
use Note\Src\Database\SimpleQuery;

abstract class BaseRepository extends SimpleQuery
{
    /**
     * @return Collection
     */
    public function all(): Collection
    {
        return $this->mapToEntity(
            $this->getResultsFromQuery($this->allQuery())
        );
    }

    /**
     * @param int|string $param
     * @param string $type
     * @return Collection|object|null
     */
    public function find($param, string $type = 'id')
    {
        $this->bindParams([":{$type}" => $param]);
        $result = $this->getResultsFromQuery($this->findQuery($type));
        if (!empty($result)) {
            return (count($result) > 1)
            ? $this->mapToEntity($result)
            : $this->mapEntity(array_shift($result));
        }
    }

    /**
     * @param int $skip
     * @param int $max
     * @return Collection
     */
    public function limit(int $skip, int $max): Collection
    {
        $this->bindParams(['skip' => $skip, 'max' => $max]);
        return $this->mapToEntity(
            $this->getResultsFromQuery($this->allQuery() . " LIMIT :skip, :max")
        );
    }

    /**
     * @return int
     */
    public function count(): int
    {
        $result = $this->getResultsFromQuery("SELECT COUNT(id) AS total FROM {$this->table()}");
        return array_shift($result)['total'];
    }

    /**
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        $this->bindParams([':id' => $id]);
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
     * Query genérica para traer todos los registros.
     * @return string
     */
    protected function allQuery(): string
    {
        return "SELECT * FROM {$this->table()} ORDER BY id DESC";
    }

    /**
     * Query genérica para traer registros específicos.
     * @param string $type
     * @return string
     */
    protected function findQuery(string $type): string
    {
        return "SELECT * FROM {$this->table()} WHERE {$type} = :{$type}";
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
