<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Create</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

        <!-- Styles -->
        <style> 
        #comma{
                color:red;
                background-color: black;

        }
        </style>
    </head>
    <body>
    <a href="{{route('users.index')}}">List of all users</a>

        <h1>Create new user </h1>

    <form action="{{ route('users.store') }}" method="post">
    @csrf
    <p>    <label for="name">Name:</label>
            <input type="text" name="name" id="name" required>
    </p>

    <p>     <label for="email">Email:</label>
            <input type="email" name="email" id="email" required>
    </p>
   
    <p>
        <label for="password">Password:</label>
        <input type="password" name="password" id="password" required>
    </p>



    <p>
        <label for="password_confirmation">Confirm Password:</label>
        <input type="password" name="password_confirmation" id="password_confirmation" required>
    </p>
    
    <p> <label>Skills:</label>
        @foreach($skills as $skill)
            <div>
                <input type="checkbox" name="skills[]" value="{{ $skill->id }}">
                <label>{{ $skill->name }}</label>
            </div>
        @endforeach
    </p>

    <p>
        <p style="color:green">NOTE: If you have additionally skills,
         If the skills are different, please put a comma <b id="comma">","</b> between all the different skills</p>
        <label for="another_skills">Another Skills:</label>
        <input type="text" id="another_skills" name="another_skills" placeholder="Enter your additionally skills"/>
    </p>

    <button type="submit">Create</button>
</form>
        
    </body>
</html>