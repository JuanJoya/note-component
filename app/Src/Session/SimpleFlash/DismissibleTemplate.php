<?php

declare(strict_types=1);

namespace Note\Src\Session\SimpleFlash;

use Tamtamchik\SimpleFlash\{TemplateInterface, Templates\BootstrapTemplate};

class DismissibleTemplate extends BootstrapTemplate implements TemplateInterface
{
    protected $prefix  = '';
    protected $postfix = '';
    protected $wrapper = '<div class="alert alert-%s alert-dismissible fade show" role="alert">%s<button type="button" 
    class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
}
