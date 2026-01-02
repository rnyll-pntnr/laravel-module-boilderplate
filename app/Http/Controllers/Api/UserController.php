<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = User::where(function($q) {
            if(request()->has('search')) {
                $q->where('name', 'like', '%' . request('search')['value'] . '%')
                    ->orWhere('email', 'like', '%' . request('search')['value'] . '%');
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

    /**
     * @OA\PathItem(path="/api/authenticate")
     */

    /**
     * @OA\Post(
     *      path="/api/authenticate",
     *      summary="Authenticate a user",
     *      tags={"Authentication"},
     *      security={},
     *      description="Authenticate a user and return a token.",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              required={"email", "password"},
     *              @OA\Property(property="email", type="string", format="email", example="user@example.com"),
     *              @OA\Property(property="password", type="string", format="password", example="password123")
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="A token for the authenticated user",
     *          @OA\JsonContent(
     *              @OA\Property(property="token", type="string", example="1234567890abcdef1234567890abcdef")
     *          )
     *      )
     *
     * )
     */
    public function authenticate(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (!auth()->attempt($credentials)) {
            return response()->json([
                'message' => 'Invalid credentials',
            ], Response::HTTP_UNAUTHORIZED);
        }

        /**
         * @var User $user
         */
        $user = auth()->user();

        /**
         * @var \Illuminate\Auth\SessionGuard $auth
         */
        $auth = auth();

        $token = $user->createToken($request->token_name ?? 'PLAIN_TOKEN');

        return response()->json([
            'token' => $token->plainTextToken,
        ]);
    }
}
