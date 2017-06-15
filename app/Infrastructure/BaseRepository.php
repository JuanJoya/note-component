<?php

namespace Note\Infrastructure;

use Illuminate\Support\Collection;

abstract class BaseRepository extends Database
{
    /**
     * @return string
     */
    abstract protected function table();

    /**
     * @param array $result
     * @return mixed Entity Object
     */
    abstract protected function mapEntity(array $result);

    /**
     * Only for database test's
     */
    public function truncate()
    {
        $this->query = "
            DELETE FROM users;
            DELETE FROM authors;
            DELETE FROM notes;";
        $this->executeSingleQuery();
    }

    /**
     * @return Collection de Entity Objects
     */
    public function all()
    {
        $this->query = "SELECT * FROM {$this->table()}";
        $this->getResultsFromQuery();

        return $this->mapToEntity($this->rows);
    }

    /**
     * @param string $param
     * @param string $type
     * @return null|mixed Entity Object
     */
    public function find($param, $type = 'id')
    {
        $this->query = "SELECT * FROM {$this->table()} WHERE {$type} = :{$type}";
        $this->bindParams = [":{$type}" => $param];
        $this->getResultsFromQuery();

        if (!empty($this->rows)) {
            return $this->mapEntity(array_shift($this->rows));
        }
    }

    /**
     * @param string $id
     */
    public function delete($id)
    {
        $this->query = "DELETE FROM {$this->table()} WHERE id = :id";
        $this->bindParams = [':id' => $id];
        $this->executeSingleQuery();
    }

    /**
     * @param string $id
     * @return bool
     */
    public function inDatabase($id)
    {
        return !is_null($this->find($id));
    }

    /**
     * @param string $id
     * @param string $dbField nombre del campo en la db
     * @param string $ownerId
     * @return bool
     */
    public function belongsTo($id, $dbField, $ownerId)
    {
        $this->query = "SELECT * FROM {$this->table()} WHERE id = :id AND {$dbField} = :ownerId";
        $this->bindParams = [
            ':id'      => $id,
            ':ownerId' => $ownerId
        ];
        $this->getResultsFromQuery();

        if (empty($this->rows)) {
            return false;
        }

        return true;
    }

    /**
     * @param array $results datos de la db
     * @return Collection
     */
    protected function mapToEntity(array $results)
    {
        $collection = new Collection();
        foreach ($results as $result) {
            $entity = $this->mapEntity($result);
            $collection->push($entity);
        }

        return $collection;
    }
}
