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
     * @return Collection de Entity Objects
     */
    public function all()
    {
        $this->query = "SELECT * FROM ".$this->table();
        $this->getResultsFromQuery();

        return $this->mapToEntity($this->rows);
    }

    /**
     * @param array $results
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

    /**
     * @param string $id
     * @return mixed Entity Object
     */
    public function find($id)
    {
        $this->query = "SELECT * FROM ".$this->table()." WHERE id = :id";
        $this->bindParams = [':id' => $id];
        $this->getResultsFromQuery();

        return $this->mapEntity(array_shift($this->rows));
    }

    /**
     * @param string $id
     */
    public function delete($id)
    {
        $this->query = "DELETE FROM ".$this->table()." WHERE id = :id";
        $this->bindParams = [':id' => $id];
        $this->executeSingleQuery();
    }
}