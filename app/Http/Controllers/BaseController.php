<?php

declare(strict_types=1);

namespace Note\Http\Controllers;

use Illuminate\Support\Collection;
use Note\Src\Database\CanPaginate;

abstract class BaseController
{
    use CanPaginate;

    /**
    * Agrega propiedades de paginación (método links()) a un objeto Collection.
    * @param Collection $items
    * @param int $perPage numero de elementos por pagina.
    * @param array $appends agrega parámetros al QueryString.
    * @return Collection elementos de la pagina actual.
    */
    protected function paginate(Collection $items, int $perPage = 5, array $appends = []): Collection
    {
        $pages = $this->getPaginator($perPage, $items->count());
        $items->macro('links', $this->getLinksMethod($pages, $appends));
        return $items->slice($pages->get_start(), $perPage);
    }
}
