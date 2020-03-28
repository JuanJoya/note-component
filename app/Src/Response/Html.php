<?php

declare(strict_types=1);

namespace Note\Src\Response;

use Illuminate\Http\Response;

/**
 * Esta clase construye un Response a partir de un template html-php básico,
 * no hay protección contra ataques XSS Cross-site scripting.
 */
class Html
{
    /**
     * @var string
     */
    private $template;

    /**
     * @var array
     */
    private $params;

    /**
     * @var bool
     */
    private $withLayout;

    /**
     * @var string
     */
    private $layout = 'layout';

    /**
     * @var string
     */
    private $templateFolder = ROOT_PATH . '/resources/views/';

    /**
     * @param string $template nombre del template.
     * @param array $params parámetros a enviar al template.
     * @param bool $withLayout
     */
    public function __construct(string $template, array $params = [], bool $withLayout = true)
    {
        $this->template   = normalizeName($template);
        $this->params     = $params;
        $this->withLayout = $withLayout;
    }

    /**
     * Construye un Response a partir de un template.
     * @param int $status código de status http.
     * @return Response
     */
    public function render(int $status = 200): Response
    {
        return new Response($this->loadContent(), $status);
    }

    /**
     * @param string $layout nombre del layout.
     * @return void
     */
    public function setLayout(string $layout): void
    {
        $this->layout = $layout;
    }

    /**
     * @return string
     */
    private function getLayoutFileName(): string
    {
        return $this->templateFolder . $this->layout . '.php';
    }

    /**
     * @return string
     */
    private function getTemplateFileName(): string
    {
        return $this->templateFolder . $this->template . '.php';
    }

    /**
     * @return string contenido html.
     */
    private function loadContent(): string
    {
        if (($this->withLayout == true) && !file_exists($this->getLayoutFileName())) {
            throw new \RuntimeException("Layout file is missing.");
        } elseif (!file_exists($this->getTemplateFileName())) {
            throw new \RuntimeException("Template file for: [{$this->template}] is missing.");
        }

        return $this->includeTemplateFromFile();
    }

    /**
     * Se utiliza el output buffer para capturar el html "compilado" desde un template.
     * @return string contenido html.
     */
    private function includeTemplateFromFile(): string
    {
        extract($this->params);
        ob_start();

        if ($this->withLayout) {
            require $this->getTemplateFileName();
            $template_content = ob_get_contents();
            ob_clean();
            require $this->getLayoutFileName();
        } else {
            require $this->getTemplateFileName();
        }

        return ob_get_clean();
    }

    /**
     * Crea un Response con el template de error http.
     * @param int $status código de status http.
     * @param array $params parámetros a enviar al error template.
     * @return Response
     */
    public static function error(int $status = 404, array $params = []): Response
    {
        return (new self('errors/http', $params, false))->render($status);
    }
}
