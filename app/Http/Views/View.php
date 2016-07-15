<?php
namespace Note\Http\Views;

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
     * @param string $template
     * @param array $params
     */
    public function __construct($template, array $params = [])
    {
        $this->template = $template;
        $this->params = $params;
    }

    /**
     * @return Response utilizado por el Router en Request::capture()
     */
    public function render()
    {
        $content = $this->loadTemplate();
        $response = new Response($content);
        return $response;
    }

    /**
     * @return string contenido html
     */
    private function loadTemplate()
    {
        $path = dirname(dirname(dirname(__DIR__))) .
            '/resources/views';

        $templatePath = "$path/{$this->template}.php";

        return $this->includeTemplateFromFile(
            $templatePath,
            $this->params
        );
    }

    /**
     * @param string $path
     * @param array $params
     * @return string contenido html
     */
    private function includeTemplateFromFile($path, $params)
    {
        if (file_exists($path)) {
            extract($params);

            ob_start();

            require $path;

            return ob_get_clean();
        }
    }
}