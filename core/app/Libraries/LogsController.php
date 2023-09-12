<?php

namespace App\Libraries;

use App\Controllers\BaseController;
use App\Models\CustomModel;

class LogsController extends BaseController {

    public function init($activity) {
        $data = [
            'user_id' => session()->get('session_token')['id'] ?? '',
            'activity' => $activity,
            'ip_address' => request()->getIPAddress()
        ];

        $this->saveLogs($data);
    }

    public function saveLogs($data) {
        $model = new CustomModel();
        try {
            $model->insertData('lites_logs', $data);
        } catch (\Exception $e) {
            print_r($e);
        }
    }

}