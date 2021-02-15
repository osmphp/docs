<?php

namespace Osm\Docs\Docs\Traits;

use Osm\Core\App;
use Osm\Docs\Docs\Module;
use Osm\Framework\Http\Exceptions\NotFound;

trait DetectRouteTrait
{
    protected function around_findController(callable $proceed) {
        global $osm_app; /* @var App $osm_app */

        try {
            return $proceed();
        }
        catch (NotFound $e) {
            $module = $osm_app->modules['Osm_Docs_Docs']; /* @var Module $module */
            $request = $osm_app->request;

            if (!($book = $module->book ?? null)) {
                throw $e;
            }

            $filePath = $request->route;

            if (starts_with($filePath, '/.')) {
                throw $e;
            }

            if ($page = $book->getPage($filePath, false)) {
                $module->page = $page;
                return $osm_app->area_->controllers['GET /_books/page'];
            }

            if ($book->isImage($filePath)) {
                $module->image = $filePath;
                return $osm_app->area_->controllers['GET /_books/image'];
            }

            throw $e;
        }
    }
}