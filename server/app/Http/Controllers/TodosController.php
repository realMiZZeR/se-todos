<?php

namespace App\Http\Controllers;

use App\Mail\TodoMail;
use App\Models\Todo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class TodosController extends Controller
{
    public function create(Request $request)
    {
        $validData = $request->validate([
            'title' => 'required|string',
            'description' => 'string',
            'user_id' => 'required|integer',
        ]);

        if (isset($validData['errors']) && count($validData['errors']) > 0)
        {
            return response($validData, 400);
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

    public function store(Request $request)
    {
        $user = $request->user();

        if (!$user)
        {
            return response(['message' => 'Idk how you got it, maybe you have to authorize?'], 401);
        }

        $roles = config('enums.user_roles');

        // If user is admin then return all todos.
        if (isset($user['role_id']) && $user['role_id'] === $roles['admin'])
        {
            $todos = Todo::all();
            return response($todos, 200);
        }

        // Other is guests.
        $todos = Todo::all()->where('user_id', '=', $user['id']);
        return response($todos, 200);
    }
}
