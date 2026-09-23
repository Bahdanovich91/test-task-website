<?php

declare(strict_types=1);

namespace App\Core\View;

use Smarty\Smarty;

final class SmartyView extends Smarty
{
    public function __construct()
    {
        parent::__construct();

        $this->setTemplateDir(__DIR__ . '/../../../templates');
        $this->setCompileDir('/tmp/smarty');

        $this->setEscapeHtml(true);
    }

    public function notFound(string $template = '404.tpl'): void
    {
        http_response_code(404);
        $this->display($template);
    }
}
