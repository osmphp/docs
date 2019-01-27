<?php

namespace Manadev\Docs\Docs\Views;

use Manadev\Docs\Docs\File;
use Manadev\Framework\Views\View;

/**
 * @property File $file @required
 */
class DocPage extends View
{
    public $template = 'Manadev_Docs_Docs.doc_page';
}