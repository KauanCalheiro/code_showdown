<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\Request;

class UserController
{
    public function index(Request $request)
    {
        $query = User::query();

        if ($request->has('term')) {
            $term = $request->input('term');
            $query->whereRaw("foods::jsonb @> '\"$term\"'");
        }

        $users = $query->get();
        $response = [
            'cookies' => $users,
            'rows' => $users->count()
        ];

        return response()->json($response);
    }

    public function store(StoreUserRequest $request)
    {
        try{
            $validated = $request->validated();

            if (User::where('user', $validated['user'])->exists()) {
                throw new \Exception('User already exists');
            }

            if (preg_match('/\s/', $validated['user']) || preg_match('/[^\x20-\x7E]/', $validated['user'])) {
                throw new \Exception('User name cannot contain spaces or special characters');
            }

            $birthDate = \DateTime::createFromFormat('d/m/Y', $validated['birth']);
            $today = new \DateTime();
            $age = $today->diff($birthDate)->y;

            if ($age < 18) {
                throw new \Exception('User must be at least 18 years old');
            }

            $user = User::create($validated);
            return response()->json($user, 201);
        } catch (\Exception $e) {
            var_dump($e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
