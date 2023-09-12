<?php

namespace App\Middleware;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

use App\Models\CustomModel;
use ipinfo\ipinfo\IPinfo;

class VisitorMiddleware implements FilterInterface {

    public function before(RequestInterface $request, $arguments = null) {
    
        $route = $request->uri->getPath();

        if(strpos($route, 'admin') !== true) {

            $visitor_logging = env('enable_visitor_logging');
            $referrer_logging = env('enable_referrer_logging');

            // IF VISITOR LOGGING IS ENABLED
            if($visitor_logging) {
                $model = new CustomModel();
                $token = env('api_token_ip_geolocation');
                $ip = $request->getIPAddress();
                if(filter_var($ip, FILTER_VALIDATE_IP)) {
                    $curl = \Config\Services::curlrequest();
                    $response = $curl->request('GET', 'https://ipinfo.io/'.$ip.'?token='.$token);
                    $responseBody = json_decode($response->getBody(), true);
                    $data = [
                        'ip' => $responseBody['ip'],
                        'hostname' => $responseBody['hostname'],
                        'city' => $responseBody['city'],
                        'region' => $responseBody['region'],
                        'country' => $responseBody['country'],
                        'loc' => $responseBody['loc'],
                        'org' => $responseBody['org'],
                        'postal' => $responseBody['postal'],
                        'timezone' => $responseBody['timezone'],
                    ];
                    try {
                        $model->insertData('lites_site_visitors', $data);
                    } catch (\Exception $e) {
                        print_r($e->getMessage());
                    }    
                }

            }

            // IF RERFERRER LOGGING IS ENABLED
            if($referrer_logging) {
                $model = new CustomModel;
                $referrer = $request->getHeaderLine('Referer');
                $baseUrl = base_url();

                if (!empty($referrer) && strpos($referrer, $baseUrl) === false) {
                    $data = [
                        'referrer' => $referrer
                    ];

                    try {
                        $model->insertData('lites_site_referrers', $data);
                    } catch (\Exception $e) {
                        print_r($e->getMessage());
                    }
                }


            }
        }

    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null) {
        // Code to execute after the route has been accessed
    }
}
