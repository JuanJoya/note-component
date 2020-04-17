<?php

declare(strict_types=1);

namespace Note\Domain\Services;

use Illuminate\Support\Collection;
use Note\Src\Database\CanPaginate;
use Note\Infrastructure\BaseRepository;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

abstract class BaseService
{
    use CanPaginate;

    /**
     * @return Collection
     */
    public function all(): Collection
    {
        return $this->repository()->all();
    }

    /**
     * @param int|string $param
     * @param string $type
     * @param bool $throwOnFail
     * @return Collection|object|null
     */
    public function find($param, string $type = 'id', bool $throwOnFail = false)
    {
        if (empty($param)) {
            throw new \InvalidArgumentException("empty {$param} argument");
        }
        $result = $this->repository()->find($param, $type);
        return $throwOnFail ? $this->throwOnNull($result) : $result;
    }

    /**
     * @param int $id
     * @return object
     */
    public function findOrFail(int $id): object
    {
        return $this->throwOnNull(
            $this->repository()->find($id)
        );
    }

    /**
     * @return int
     */
    public function count(): int
    {
        return $this->repository()->count();
    }

    /**
     * @param int $perPage
     * @param array $appends
     * @return Collection
     */
    public function paginate(int $perPage = 10, array $appends = []): Collection
    {
        $pages = $this->getPaginator($perPage, $this->repository()->count());
        $items = $this->repository()->limit($pages->get_start(), $perPage);
        $items->macro('links', $this->getLinksMethod($pages, $appends));
        return $items;
    }

    /**
     * @param array $attributes
     * @return void
     */
    public function create(array $attributes)
    {
        $this->repository()->save($attributes);
    }

    /**
     * @param array $attributes
     * @return void
     */
    public function update(array $attributes): void
    {
        $this->repository()->update($attributes);
    }

    /**
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        return $this->repository()->delete($id);
    }

    /**
     * @param mixed $result
     * @return mixed
     */
    private function throwOnNull($result)
    {
        if (is_null($result)) {
            throw new NotFoundHttpException('Entity not found');
        }
        return $result;
    }

    /**
     * @return BaseRepository
     */
    abstract protected function repository(): BaseRepository;
}
