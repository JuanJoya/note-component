<?php

namespace Note\Domain;
use Note\Infrastructure\BaseRepository;

abstract class Service
{
    /**
     * @var BaseRepository
     */
    protected $entity;

    /**
     * @param $entity
     */
    public function __construct($entity)
    {
        if(! $entity instanceof BaseRepository)
        {
            throw new \OutOfBoundsException();
        }
        $this->entity = $entity;
    }

    /**
     * @param $id string
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
     * @param $id string
     */
    public function delete($id)
    {
        return $this->entity->delete($id);
    }
}
