<?php

namespace App\Http\Controllers;

use App\Mail\TodoMail;
use App\Models\Todo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class TodosController extends Controller
{
    /**
     * @OA\Post(
     *  path="/api/todos/create",
     *  summary="Создание заметки",
     *  security={
     *    {"bearerAuth": {}}
     *  },
     *  @OA\Parameter(
     *      name="title",
     *      description="Заголовок",
     *      in="query",
     *      required=true,
     *      @OA\Schema(type="string"),
     *  ),
     *  @OA\Parameter(
     *      name="description",
     *      description="Описание",
     *      in="query",
     *      required=true,
     *      @OA\Schema(type="string"),
     *   ),
     *  @OA\Response(
     *   response=200,
     *   description="Заметка создалась и было отправлено письмо на электронную почту."
     *  ),
     *   @OA\Response(
     *      response=401,
     *      description="Необходимо авторизироваться."
     *     ),
     *   @OA\Response(
     *     response=422,
     *     description="Не все поля заполнены или заполнены неверно."
     *   ),
     * )
     */
    public function create(Request $request)
    {
        $validData = $request->validate([
            'title' => 'required|string',
            'description' => 'string',
        ]);

        if (isset($validData['errors']) && count($validData['errors']) > 0)
        {
            return response($validData, 422);
        }

        $todo = new Todo;
        $todo->title = $request->get('title');
        $todo->description = $request->get('description');
        $todo->user_id = $request->user()['id'];
        $todo->save();


        // Fake send mail notification.
        Mail::fake()
            ->to($request->user())
            ->send(new TodoMail($todo));

//        Mail::to($request->user())
//            ->send(new TodoMail($todo));

        return response($todo, 200);
    }

    /**
     * @OA\Post(
     *  path="/api/todos",
     *  summary="Извлечение заметок из БД.",
     *  security={
     *      {"bearerAuth": {}}
     *  },
     *  @OA\Response(
     *   response=200,
     *   description="Метод отработал успешно и вернул хотя бы 1 заметку."
     *  ),
     *   @OA\Response(
     *    response=204,
     *    description="Метод отработал успешно, но ответ пустой."
     *   ),
     *   @OA\Response(
     *    response=401,
     *    description="Необходимо авторизироваться."
     *   ),
     * )
     */
    public function store(Request $request)
    {
        $user = $request->user();
        $roles = config('enums.user_roles');

        // If user is admin then return all todos.
        if (isset($user['role_id']) && $user['role_id'] === $roles['admin'])
        {
            $todos = Todo::all();
            $status = $todos->count() > 0 ? 200 : 204;
            return response($todos, $status);
        }

        // Other is guests.
        $todos = Todo::all()->where('user_id', '=', $user['id']);
        $status = $todos->count() > 0 ? 200 : 204;
        return response($todos, $status);
    }
}
