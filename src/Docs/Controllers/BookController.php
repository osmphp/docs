<?php

namespace Osm\Docs\Docs\Controllers;

use Osm\Core\App;
use Osm\Docs\Docs\Book;
use Osm\Docs\Docs\Page;
use Osm\Docs\Docs\Module;
use Osm\Framework\Http\Controller;
use Osm\Framework\Http\Responses;

/**
 * @property Module $module @required
 * @property Page $page @required
 * @property Responses $responses @required
 * @property Book $book @required
 */
class BookController extends Controller
{
    protected function default($property) {
        global $osm_app; /* @var App $osm_app */

        switch ($property) {
            case 'module': return $osm_app->modules['Osm_Docs_Docs'];
            case 'page': return $this->module->page;
            case 'responses': return $osm_app[Responses::class];
            case 'book': return $this->module->book;
        }
        return parent::default($property);
    }

    public function bookPage() {
        if ($this->page->type == Page::REDIRECT) {
            return $this->responses->redirect($this->page->redirect_to_url);
        }

        return osm_layout('books_page', [
            '#page' => [
                'title' => $this->page->title,
                'model' => [
                    'book' => (object)$this->book->getJsConfig(),
                ],
            ],
            '#breadcrumbs' => ['page' => $this->page],
            '#html' => ['page' => $this->page],
        ]);
    }

    public function image() {
        return $this->responses->image($this->module->book->file_path . $this->module->image);
    }
}