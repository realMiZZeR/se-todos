<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Todo</title>
</head>
<body>
    <h1>{{ $todo->title  }}</h1>
    <p>{{ $todo->description }}</p>
</body>
