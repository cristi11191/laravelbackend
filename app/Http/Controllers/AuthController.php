<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        try {
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'Invalid credentials'], 401);
            }
        } catch (JWTException $e) {

            return response()->json(['error' => 'Could not create token', 'message' => $e->getMessage()], 500);
        }

        return response()->json(compact('token'));
    }

    public function register(Request $request)
    {
        // Validate incoming request data
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'role_id' => 'required|exists:roles,id', // Ensure role exists in the roles table
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 400);
        }

        // Retrieve the validated input data
        $data = $validator->validated();

        // Create new user
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']), // Use Hash facade for password hashing
            'role_id' => $data['role_id'], // Ensure role_id is passed correctly
        ]);

        // Generate JWT token
        $token = JWTAuth::fromUser($user);

        // Return the response with the token
        return response()->json([
            'status' => 'success',
            'data' => [
                'user' => $user,
                'token' => $token
            ]
        ]);
    }

    public function refresh()
    {
        $token = JWTAuth::getToken();
        $newToken = JWTAuth::refresh($token);

        return response()->json(compact('newToken'));
    }

    // Add this method
    public function getCurrentUser()
    {
        try {
            // Authenticate the user
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['error' => 'User not found'], 404);
            }

            // Load the user's role
            $user->load('role'); // Eager-load role

            // Convert the user to an array, including the role and permissions
            $userArray = $user->toArray();

            // Debug: Check the structure of role
            \Log::info('User Role:', [$userArray['role']]);

            // Build the response array
            $response = [
                'user' => [
                    'id' => $userArray['id'], // Include user ID
                    'name' => $userArray['name'], // Include other user attributes as needed
                    'email' => $userArray['email'], // Example of including email
                    'role' => [
                        'name' => $userArray['role']['name']
                    ],
                    'status' => $userArray['status']
                ]
            ];

        } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
            return response()->json(['error' => 'Token expired'], $e->getStatusCode());
        } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
            return response()->json(['error' => 'Token invalid'], $e->getStatusCode());
        } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {
            return response()->json(['error' => 'Token absent'], $e->getStatusCode());
        } catch (\Exception $e) {
            \Log::error('An error occurred:', [$e->getMessage()]);
            return response()->json(['error' => 'An internal error occurred'], 500);
        }

        // Return the user with the role and permissions information
        return response()->json($response);
    }






}
