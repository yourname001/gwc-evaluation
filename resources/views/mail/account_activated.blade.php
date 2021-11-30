<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    {{-- <title>Document</title> --}}
</head>
<body>
    <p>
        This is to confirm that your account has been activated.                                      
        You may now <a href="{{ config('app.url') }}">login</a> to Online Faculty Evaluation Management of Golden West Colleges using the information below:
    </p>
    <p>
        <ul style="list-style: none">
            <li>
                <b>Username:</b>
                {{ $user->username }}
            </li>
            <li>
                <b>Password:</b>
                {{ $user->temp_password }}
            </li>
        </ul>
    </p>
    <p>
        PLEASE PROTECT YOUR ACCOUNT INFORMATION. You assume full responsibility for maintaining the confidentiality of your Username and Password.
    </p>
    <br>
    <p>
        - GOLDEN WEST COLLEGES
    </p>
    <p>
        <i>This is a system-generated email. Please do not reply.</i>
    </p>
</body>
</html>