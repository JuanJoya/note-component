<?php

namespace Note\Domain;

use Note\Infrastructure\BaseRepository;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

abstract class Service
{
    /**
     * @var BaseRepository instancia de algún repositorio {Note,Author,User}
     */
    protected $entity;

    /**
     * @param string $id
     * @return null|mixed Entity Object
     */
    public function find($id)
    {
        if (empty($id)) {
            throw new \InvalidArgumentException("empty id argument");
        }

        return $this->entity->find($id);
    }

    public function findOrFail($id)
    {
        $result = $this->find($id);
        if (is_null($result)) {
            throw new NotFoundHttpException();
        }

        return $result;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function all()
    {
        return $this->entity->all();
    }

    /**
     * @param string $id de una Entity
     */
    public function delete($id)
    {
        if (empty($id)) {
            throw new \InvalidArgumentException("empty id argument");
        }

        $this->entity->delete($id);
    }
}
