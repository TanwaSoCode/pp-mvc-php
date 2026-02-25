<?php

declare(strict_types=1);

function renderView(string $template, array $data = []): void
{
     // make provided data available as variables inside templates
     if (!empty($data)) {
         extract($data, EXTR_SKIP);
     }

     include TEMPLATES_DIR . '/header.php';
     include TEMPLATES_DIR . '/' . $template . '.php';
     include TEMPLATES_DIR . '/footer.php';
}
