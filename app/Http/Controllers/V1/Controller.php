<?php

namespace App\Http\Controllers\V1;

use App\Models\Schedule;
use App\Models\Transaction;
use App\Models\TransactionRequest;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

/**
 * Class Controller
 * @package App\Http\Controllers\V1
 */
class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * @param $model
     * @return bool|string
     */
    public function generateId($model){
        $id = substr(md5(substr(hexdec(uniqid()), -6)), -24);

        if($model->where('id', $id)->exists()){
            return $this->generateId($model);
        }

        return $id;
    }
}
