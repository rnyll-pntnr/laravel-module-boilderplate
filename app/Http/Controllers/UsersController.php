<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\User\CreateUserRequest;
use Inertia\Inertia;
use App\Models\User;
use Laravel\Socialite\Socialite;

class UsersController extends Controller
{
    public function index() {
        $users = User::all();
        return Inertia::render('users/Index');
    }

    public function create() {
        return Inertia::render('users/Create');
    }

    /**
     * @OA\Post(
     *      path="/api/user/store",
     *      summary="Create a new user",
     *      tags={"Users"},
     *      security={},
     *      description="Create a new user account.",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              required={"name", "email", "password"},
     *              @OA\Property(property="name", type="string", example="John Doe"),
     *              @OA\Property(property="email", type="string", format="email", example="user@example.com"),
     *              @OA\Property(property="password", type="string", format="password", example="password123")
     *          )
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="User account created successfully",
     *          @OA\JsonContent(
     *              @OA\Property(property="success", type="boolean", example=true),
     *              @OA\Property(property="message", type="string", example="Account created successfully!"),
     *              @OA\Property(property="user", ref="#/components/schemas/User")
     *          )
     *      )
     * )
     */
    public function store(CreateUserRequest $request) {
        $user = User::create($request->validated());
        
        return redirect()->route('users.index')->with('message', 'User created successfully!');
    }

    public function edit($id) {
        $user = User::findOrFail($id);
        return Inertia::render('users/Show', [
            'user' => $user
        ]);
    }

    public function update($id) {
        $user = User::findOrFail($id);
        $user->update([
            'name' => request('name'),
            'email' => request('email'),
        ]);

        return redirect()->route('users.index')->with('message', 'User updated successfully!');
    }

    public function destroy($id) {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('users.index')->with('message', 'User deleted successfully!');
    }

    public function googleAuthProvider() {
        $user = Socialite::driver('google')->stateless()->user();
        $newUser = User::updateOrCreate([
            'email' => $user->email,
        ], [
            'name' => $user->name,
            'email' => $user->email,
            'provider_id' => $user->id,
            'password' => bcrypt($user->id),
        ]);

        \Auth::login($newUser);

        return redirect()->route('dashboard');
    }
}
