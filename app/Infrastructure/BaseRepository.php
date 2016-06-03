<?php
namespace Note\Infrastructure;
use Illuminate\Support\Collection;

abstract class BaseRepository extends Database
{
    abstract protected function table();
    abstract protected function mapEntity(array $result);

    public function all()
    {
        $this->query = "SELECT * FROM ".$this->table();
        $this->getResultsFromQuery();

        return $this->mapToEntity($this->rows);
    }

    protected function mapToEntity(array $results)
    {
        $collection = new Collection();

        foreach ($results as $result) {
            $entity = $this->mapEntity($result);
            $collection->push($entity);
        }

        return $collection;
    }

    public function find($id)
    {
        $this->query = "SELECT * FROM '.$this->table().' WHERE id = :id";
        $this->bindParams = [':id' => $id];
        $this->getResultsFromQuery();

        return $this->mapEntity(array_shift($this->rows));
    }
}