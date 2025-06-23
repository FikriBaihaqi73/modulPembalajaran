<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    @vite('resources/css/app.css')
</head>
<body>
    <x-navbar/>

    <div class="flex items-center justify-center min-h-screen">
        <div class="login-container">
            <h3 class="heading">Login</h3>

            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <strong class="font-bold">Login Gagal!</strong>
                    <span class="block sm:inline">{{ $errors->first('username') }}</span>
                </div>
            @endif

            <form action="/login" method="POST" class="login-form">
                @csrf
                <div class="input-group">
                    <label class="hidden" for="username">Username</label>
                    <input type="text" id="username" placeholder="Username" name="username" value="{{ old('username') }}">
                </div>
                <div class="input-group relative" x-data="{ show: false }">
                    <label class="hidden" for="password">Password</label>
                    <input :type="show ? 'text' : 'password'" id="password" placeholder="Password" name="password" class="pr-10">
                    <i class="absolute inset-y-0 right-0 pr-3 flex items-center cursor-pointer text-gray-500" @click="show = !show" :class="{ 'fa fa-eye': !show, 'fa fa-eye-slash': show }"></i>
                </div>
                <button type="submit" class="login-button">Login</button>
            </form>
        </div>
    </div>
    <script defer src="https://unpkg.com/alpinejs@3.14.9/dist/cdn.min.js"></script>
</body>
</html>
