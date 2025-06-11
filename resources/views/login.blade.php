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
    @csrf

    <div class="flex items-center justify-center min-h-screen">
        <div class="login-container">
            <h3 class="heading">Login ke Akun Anda</h3>
            <p class="paragraph">Silakan masukkan detail Anda untuk masuk.</p>
            <form action="#" method="POST" class="login-form">
                <div class="input-group">
                    <label class="hidden" for="username">Username</label>
                    <input type="text" id="username" placeholder="Username">
                </div>
                <div class="input-group">
                    <label class="hidden" for="password">Password</label>
                    <input type="password" id="password" placeholder="Password">
                </div>
                <button type="submit">Login</button>
            </form>
        </div>
    </div>
</body>
</html>
