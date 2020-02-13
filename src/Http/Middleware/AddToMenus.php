<?php
namespace ProcessMaker\Package\BusinessRules\Http\Middleware;

use Closure;
use Lavary\Menu\Facade as Menu;


class AddToMenus
{

    public function handle($request, Closure $next)
    {

        // Add a menu option to the top to point to our page

        $menu = Menu::get('topnav');
        $menu->add(__('Business Rules'), ['route' => 'business.rules.tab.index']);
        $menu->add(__('Reports'), ['route' => 'reports.tab.index']);

        return $next($request);
    }

}
