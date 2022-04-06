<?php

namespace MovehqApp\Http\Controllers\AdminApi;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as Controller;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ApiBaseController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct()
    {
    }

    public function json(\Closure $f)
    {
        try {
            $default['status'] = 'success';
            $return = $f();
            $return = array_merge($default, (array) $return);
            return response()->json($return);
        } catch (\Exception $e) {
            $return['status'] = 'fail';
            $return['error'] = $e->getMessage();

            \Log::error($e->__toString());
            return response()->json($return, 500);
        }
    }

    protected function log($s)
    {
        if (is_string($s)) {
            \Log::info($this->name . '->' . $s);
        } else {
            \Log::info($s);
        }
    }
}
