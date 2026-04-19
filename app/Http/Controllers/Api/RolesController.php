<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Dedoc\Scramble\Attributes\ExcludeAllRoutesFromDocs;

/**
 * @OA\Schema(
 *     schema="Role",
 *     @OA\Property(property="id", type="integer"),
 *     @OA\Property(property="name", type="string"),
 *     @OA\Property(property="guard_name", type="string"),
 *     @OA\Property(property="created_at", type="string", format="date-time"),
 *     @OA\Property(property="updated_at", type="string", format="date-time")
 * )
 */
#[ExcludeAllRoutesFromDocs]
class RolesController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/roles",
     *     summary="List roles",
     *     tags={"Roles"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="search",
     *         in="query",
     *         description="Search by role name",
     *         required=false,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="value", type="string")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="List of roles",
     *         @OA\JsonContent(
     *             @OA\Property(property="recordsTotal", type="integer"),
     *             @OA\Property(property="recordsFiltered", type="integer"),
     *             @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/Role"))
     *         )
     *     )
     * )
     */
    public function index()
    {
        $data = Role::where(function($q) {
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
