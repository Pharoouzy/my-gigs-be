<?php

namespace App\Http\Controllers\V1;

use App\Models\Country;
use Illuminate\Http\Request;
use App\Helpers\RequestHelper;

/**
 * Class CountryController
 * @package App\Http\Controllers\V1
 */
class CountryController extends Controller
{
    use RequestHelper;

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function index() {
        $countries = Country::orderBy('name', 'asc')->with(['states'])->get();

        return $this->response('success', $countries);
    }
}
