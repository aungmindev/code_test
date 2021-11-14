<?php

namespace App\Menu;

use Sebastienheyd\Boilerplate\Menu\Builder;

class Clients
{
    public function make(Builder $menu)
    {
        $menu->add('Clients', [
            'route' => 'boilerplate.client.index',
            'active' => 'boilerplate.client.index',
            // 'permission' => 'backend',
            'icon' => 'users',
            'order' => 100,
        ]);
    }
}
