<?php

declare(strict_types=1);

namespace Note\Src\Template\Twig;

use Twig\{Environment, Loader\FilesystemLoader};

/**
 * @deprecated
 * Esta clase prepara el objeto \Twig\Environment para el container IoC.
 */
class TwigFactory
{
    /**
     * @var FilesystemLoader
     */
    private $loader;

    /**
     * @var Environment
     */
    private $environment;

    /**
     * @var string
     */
    private $defaultPath = ROOT_PATH . '/resources/views';

    /**
     * @param string $templatesPath ruta donde se alojan los templates.
     */
    public function __construct(string $templatesPath = null)
    {
        $this->loader = new FilesystemLoader($templatesPath ?? $this->defaultPath);
        $this->environment = new Environment($this->loader);
        $this->register($this->environment);
    }

    /**
     * El objeto Twig\Environment almacena configuraciones y extensiones necesarias
     * para cargar un template.
     * @return Environment
     */
    public function environment(): Environment
    {
        return $this->environment;
    }

    /**
     * En el archivo 'twig_functions' se puede extender la funcionalidad del
     * motor de plantillas.
     * @param Environment $env
     * @return void
     */
    private function register(Environment $env): void
    {
        require __DIR__ . '/twig_functions.php';
    }
}
