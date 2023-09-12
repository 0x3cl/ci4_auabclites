<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

use App\Models\CustomModel;

class AuthAdminFilter implements FilterInterface {

    public function before(RequestInterface $request, $arguments = null) {
    
        $session_token = session()->get('session_token');
        
        $route = $request->uri->getPath();

        if ($route === '/auabclites/admin/login') {
            if(isset($session_token)) {
                return redirect()->to('/admin/dashboard');
            }
            return;
        }
        
        $privilege_position = [
            '1',
            '2',
            '3',
            '19',
            '20'
        ];
        
        $routes = [
            'basic_routes' => [
                '/auabclites/admin/dashboard',
                '/auabclites/admin/widgets',
                '/auabclites/admin/manage/page',
                '/auabclites/admin/manage/me',
                '/auabclites/admin/manage/logs',
                '/auabclites/admin/signout',
            ],
            'admin_routes' => [
                '/auabclites/admin/dashboard',
                '/auabclites/admin/widgets',
                '/auabclites/admin/manage/users',
                '/auabclites/admin/manage/page',
                '/auabclites/admin/manage/report',
                '/auabclites/admin/manage/me',
                '/auabclites/admin/manage/logs',
                '/auabclites/admin/signout',
            ]
        ];
        
        if (empty($session_token)) {
            return redirect()->to('/admin/login');
        } else {
            $user_position = $session_token["position"];
            $route_key = in_array($user_position, $privilege_position) ? 'admin_routes' : 'basic_routes';
        
            $isAllowed = false;
            foreach ($routes[$route_key] as $value) {
                if (strpos($route, $value) === 0) {
                    $isAllowed = true;
                    break;
                }
            }
        
            if (!$isAllowed && $route !== '/auabclites/admin/notify') {
                $flashdata = [
                    'route_visited' => $route,
                    'position' => $user_position,
                    'allowed' => $routes[$route_key]
                ];
                session()->setFlashData('notify', $flashdata);
                return redirect()->to('admin/notify?id=1');
            }
        }
        

    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null) {
        // Code to execute after the route has been accessed
    }
}
