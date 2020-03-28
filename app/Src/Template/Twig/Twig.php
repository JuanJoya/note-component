<?php

declare(strict_types=1);

namespace Note\Src\Template\Twig;

use Note\Src\Template\TemplateEngine;
use Twig\Environment;

/**
 * Esta clase es un Adapter de la clase \Twig\Environment solo tiene
 * la definición del método render para cumplir con la interface.
 */
class Twig implements TemplateEngine
{
    /**
     * @var Environment
     */
    private $engine;

    /**
     * @param Environment $engine
     */
    public function __construct(Environment $engine)
    {
        $this->engine = $engine;
    }

    /**
     * {@inheritdoc}
     * @param string $template nombre del template.
     * @param array $data variables que necesita el template.
     * @return string html procesado por Twig.
     */
    public function render(string $template, array $data = []): string
    {
        return $this->engine->render(normalizeName($template, 'twig'), $data);
    }
}
