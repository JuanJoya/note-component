<?php

namespace Note\Http\Responses;

use Illuminate\Http\Response;

class View
{
    /**
     * @var string nombre del template
     */
    private $template;
    /**
     * @var array parámetros a enviar al template
     */
    private $params;
    /**
     * @var bool
     */
    private $withLayout;

    /**
     * @param string $template
     * @param array $params
     * @param bool $withLayout
     */
    public function __construct($template, array $params = [], $withLayout = true)
    {
        $this->template   = $template;
        $this->params     = $params;
        $this->withLayout = $withLayout;
    }

    /**
     * @return Response
     */
    public function render()
    {
        $content  = $this->loadContent();
        $response = new Response($content);

        return $response;
    }

    /**
     * @return string html
     */
    private function loadContent()
    {
        $path = dirname(dirname(dirname(__DIR__))) . '/resources/views';
        $layout = "$path/layout.php";

        if (!file_exists($layout)) {
            throw new \RuntimeException("Layout file is missing.");
        }

        return $this->loadTemplate($path, $layout);
    }

    /**
     * @param string $path
     * @param string $layout
     * @return string html
     */
    private function loadTemplate($path, $layout)
    {
        $templatePath = "$path/{$this->template}.php";

        if (!file_exists($templatePath)) {
            throw new \RuntimeException("Template file for: [{$this->template}] is missing.");
        }

        return $this->includeTemplateFromFile($templatePath, $layout);
    }

    /**
     * @param string $template
     * @param string $layout
     * @return string html
     */
    private function includeTemplateFromFile($template, $layout)
    {
        extract($this->params);
        ob_start();

        if ($this->withLayout) {
            require $template;
            $template_content = ob_get_contents();
            ob_clean();
            require $layout;
        } else {
            require $template;
        }

        return ob_get_clean();
    }
}
