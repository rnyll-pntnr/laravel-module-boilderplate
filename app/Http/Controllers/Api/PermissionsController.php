<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class PermissionsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Permission::where(function($q) {
            if(request()->has('search')) {
                $q->where('name', 'like', '%' . request('search')['value'] . '%');
            }
        });

        if (request()->has('order')) {
            $columnName = request('columns.' . request('order')[0]['column'] . '.data');
            $data->orderBy($columnName, request('order')[0]['dir']);
        }

        $recordsTotal = $data->count();
        $start = request('start', 0);
        $length = request('length', 10);
        return [
            'recordsTotal' => $recordsTotal,
            'recordsFiltered' => $recordsTotal,
            'data'=> $data->offset($start)
                ->limit($length)
                ->get(),
            'pagination' => [
                'total' => $recordsTotal,
                'perPage' => $length,
                'currentPage' => $start / $length + 1,
                'lastPage' => ceil($recordsTotal / $length),
                'nextPageUrl' => '?page=' . ($start / $length + 2),
                'prevPageUrl' => '?page=' . ($start / $length),
            ]
        ];
    }
}
