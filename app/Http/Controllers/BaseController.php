<?php

declare(strict_types=1);

namespace Note\Http\Controllers;

use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

abstract class BaseController
{
    /**
     * @param array|Collection $items elementos a paginar.
     * @param int $perPage numero de elementos por pagina.
     * @return LengthAwarePaginator objeto con elementos de la pagina actual.
     */
    protected function paginate($items, $perPage = 5): LengthAwarePaginator
    {
        //Se obtiene el parámetro 'page' del query string.
        $currentPage = (int)($_GET['page'] ?? 1);

        //El path que utilizan los links de la paginación.
        $options = [
            'path' => strtok($_SERVER['REQUEST_URI'], '?')
        ];

        //Se valida que la pagina actual no sea un numero negativo.
        $currentPage = ($currentPage <= 0) ? 1 : $currentPage;

        /*
         * El método slice permite extraer de la colección|array un numero de elementos n($perPage)
         * desde la posición x($offset).
         */
        if ($items instanceof Collection) {
            $currentPageItems = $items->slice(($currentPage - 1) * $perPage, $perPage);
        } elseif (is_array($items)) {
            $offset = ($currentPage - 1) * $perPage;
            $currentPageItems = array_slice($items, $offset, $perPage);
        } else {
            throw new \InvalidArgumentException("It's not possible to paginate the given items");
        }

        //Este objeto encapsula los elementos que se han de mostrar en la pagina actual.
        return new LengthAwarePaginator($currentPageItems, count($items), $perPage, $currentPage, $options);
    }
}
