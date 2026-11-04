<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\MenuResource;
use App\Models\Menu;

class MenuController extends Controller
{
    public function show(string $location): MenuResource
    {
        $menu = Menu::query()
            ->active()
            ->where('location', $location)
            ->with(['items.children', 'items.linkable'])
            ->firstOrFail();

        return new MenuResource($menu);
    }
}
