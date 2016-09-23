<?php

namespace Note\Domain;
use Note\Infrastructure\BaseRepository;

abstract class Service
{
    /**
     * @var BaseRepository instancia de algún repositorio {Note,Author,User}
     */
    protected $entity;

    /**
     * @param $entity
     */
    public function __construct($entity)
    {
        if(! $entity instanceof BaseRepository) {
            throw new \OutOfBoundsException();
        }
        $this->entity = $entity;
    }

    /**
     * @param string $id
     * @return mixed Entity Object
     */
    public function find($id)
    {
        return $this->entity->find($id);
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function all()
    {
        return $this->entity->all();
    }

    /**
     * @param string $id id de una Entity
     */
    public function delete($id)
    {
        $this->entity->delete($id);
    }
}
