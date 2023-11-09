<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register (Request $request)
    {

    }

    /**
     * @OA\Post(
     *  path="/api/login",
     *  summary="Авторизация пользователя",
     *  @OA\Parameter(
     *      name="email",
     *      description="Электронная почта",
     *      in="query",
     *      required=true,
     *      @OA\Schema(type="string"),
     *      @OA\Examples(example="guest", value="maxcan2work@gmail.com", summary="Обычный пользователь"),
     *      @OA\Examples(example="admin", value="admin@se.com", summary="Администратор"),
     *  ),
     *  @OA\Parameter(
     *      name="password",
     *      description="Пароль",
     *      in="query",
     *      required=true,
     *      @OA\Schema(type="string"),
     *      @OA\Examples(example="pass", value="pass", summary="Пароль"),
     *   ),
     *  @OA\Response(
     *   response=200,
     *   description="Авторизация прошла успешно и вернула токен."
     *  ),
     *  @OA\Response(
     *    response=401,
     *    description="Неверно введён пароль."
     *   ),
     *  @OA\Response(
     *    response=404,
     *    description="Пользователь с такой электронной почтой не найден."
     *   ),
     *   @OA\Response(
     *     response=422,
     *     description="Не все поля заполнены или заполнены неверно."
     *   ),
     * )
     */
    public function login (Request $request)
    {
        $validData = $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        // Return response if validate failed.
        if (isset($validData['errors']) && count($validData['errors']) > 0)
        {
            return response($validData, 422);
        }

        // Get user with same email from request.
        $user = User::all()->where('email', '=', $validData['email'])->first();
        if ($user)
        {
            // Password check.
            if (!Hash::check($validData['password'], $user->password))
                return response(['message' => 'Password is incorrect'], 401);

            // Create token and return response 200.
            $token = $user->createToken('Todos Password Grant Client')->accessToken;
            return response(['token' => $token], 200);
        }

        // Can't find a user with the email.
        return response(['message' => 'User does not exist'], 404);
    }

    /**
     * @OA\Post(
     *  path="/api/logout",
     *  summary="Выход из учётной записи пользователя.",
     *  security={
     *     {"bearerAuth": {}}
     *  },
     *  @OA\Response(
     *   response=200,
     *   description="Авторизация прошла успешно и вернула токен."
     *  ),
     *  @OA\Response(
     *     response=401,
     *     description="Необходимо авторизироваться."
     *    ),
     * )
     */
    public function logout (Request $request)
    {
        $token = $request->user()->token();
        $token->revoke();
        return response(['message' => 'You have been successfully logged out'], 200);
    }

    public function handleAccess (Request $request)
    {
        return response(['message' => 'You have authorize first'], 401);
    }
}
