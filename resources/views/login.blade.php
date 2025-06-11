<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    @vite('resources/css/app.css')
</head>
<body>
    <x-navbar/>

    <div class="flex items-center justify-center min-h-screen">
        <div class="login-container">
            <h3 class="heading">Login</h3>
            <form action="/login" method="POST" class="login-form">
                @csrf
                <div class="input-group">
                    <label class="hidden" for="username">Username</label>
                    <input type="text" id="username" placeholder="Username" name="username">
                </div>
                <div class="input-group">
                    <label class="hidden" for="password">Password</label>
                    <input type="password" id="password" placeholder="Password" name="password">
                </div>
                <button type="submit">Login</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
