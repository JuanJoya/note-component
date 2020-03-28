<?php

declare(strict_types=1);

namespace Note\Src\Session\SimpleFlash;

use Tamtamchik\SimpleFlash\{TemplateInterface, Templates\Bootstrap3Template};

/**
 * Uses default Bootstrap 4 markdown for flash messages.
 */
class DismissibleTemplate extends Bootstrap3Template implements TemplateInterface
{
    protected $prefix  = '';
    protected $postfix = '';
    protected $wrapper = '<div class="alert alert-%s alert-dismissible fade show" role="alert">%s<button type="button" 
    class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
}
