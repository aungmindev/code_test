<?php

namespace App\Menu;

use Sebastienheyd\Boilerplate\Menu\Builder;

class Billing
{
    public function make(Builder $menu)
    {
        $menu->add('Billing', [
            'route' => 'boilerplate.billing.index',
            'active' => 'boilerplate.billing.index',
            // 'permission' => 'backend',
            'icon' => 'money-bill-wave',
            'order' => 100,
        ]);
    }
}
