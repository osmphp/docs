<?php

namespace Osm\Docs\Docs;

use Osm\Core\App;
use Osm\Core\Modules\BaseModule;
use Osm\Framework\Gulp\Commands\ConfigGulp;
use Osm\Framework\Http\Advices\DetectArea;
use Osm\Framework\Http\Advices\DetectRoute;

/**
 * @property Tags|Tag[] $tags @required
 * @property Book $book @required
 * @property Page $page @required
 * @property string $image @required
 */
class Module extends BaseModule
{
    public $hard_dependencies = [
        'Osm_Ui_Aba',
    ];

    public $traits = [
        DetectArea::class => Traits\DetectAreaTrait::class,
        DetectRoute::class => Traits\DetectRouteTrait::class,
        ConfigGulp::class => Traits\ConfigGulpTrait::class,
    ];

    protected function default($property) {
        global $osm_app; /* @var App $osm_app */

        switch ($property) {
            case 'tags': return $osm_app->cache->remember('doc_tags', function($data) {
                return Tags::new($data);
            });
        }
        return parent::default($property);
    }
}