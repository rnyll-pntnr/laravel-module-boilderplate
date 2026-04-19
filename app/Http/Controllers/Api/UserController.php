<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Symfony\Component\HttpFoundation\Response;
use Dedoc\Scramble\Attributes\{
    QueryParameter,
    Group
};

class UserController extends Controller
{
    /**
     * Get Users
     * 
     * Get all users in paginated list
     */
    #[QueryParameter('search', description: 'Search by name of email.', type: 'string', default: 'name', example: 'Customer Name')]
    #[QueryParameter('page', description: 'Current page.', type: 'int', default: 1, example: '1')]
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
     * Create New User
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
        ]);

        return response()->json($user, 201);
    }

    /**
     * Authenticate User
     * 
     * This is description
     * @unauthenticated
     * @requestMediaType application/json
     * 
     * @param email
     * 
     */
    #[Group('Authentication', weight: 0)]
    public function authenticate(Request $request)
    {
        $credentials = $request->only(
            'email',
            'password'
        );

        $request->validate([
            'email' => 'required|email|exists:users,email',
            'password' => 'required|string',
        ]);

        if (!auth()->attempt($credentials)) {
            return response()->json([
                'message' => 'Invalid credentials',
            ], Response::HTTP_UNAUTHORIZED);
        }

        /**
         * @var User $user
         */
        $user = auth()->user();

        $token = $user->createToken($request->token_name ?? 'PLAIN_TOKEN');

        return response()->json([
            'token' => $token->plainTextToken,
        ]);
    }
}
