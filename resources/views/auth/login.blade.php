<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Catera</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-brand-50 text-brand-900 min-h-screen flex items-center justify-center p-4">

<div class="w-full max-w-md bg-white border border-brand-200/60 rounded-3xl p-8 shadow-premium animate-fade-up">

    <div class="text-center mb-8">
        <span class="text-3xl">☕</span>
        <h1 class="text-2xl font-bold tracking-tight mt-2 text-brand-900">Catera.</h1>
        <p class="text-sm text-gray-500 mt-1">Catering lezat, praktis, & higienis</p>
    </div>

    @if(session('error'))
        <div class="mb-4 p-3 bg-red-50 border border-red-200 text-red-600 rounded-xl text-sm flex items-center gap-2">
            <span>⚠️</span>
            <span>{{ session('error') }}</span>
        </div>
    @endif

    @if(session('success'))
        <div class="mb-4 p-3 bg-accent-100 border border-accent-500/20 text-accent-600 rounded-xl text-sm flex items-center gap-2">
            <span>✨</span>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <form method="POST" action="/login" class="space-y-4">
        @csrf

        <div>
            <label class="block text-xs font-semibold uppercase tracking-wider text-gray-500 mb-1.5">Email</label>
            <input type="email" name="email" required placeholder="nama@email.com"
                class="w-full p-3.5 rounded-2xl bg-brand-50 border border-brand-200 focus:border-brand-500 focus:ring-1 focus:ring-brand-500 outline-none transition text-sm">
        </div>

        <div>
            <label class="block text-xs font-semibold uppercase tracking-wider text-gray-500 mb-1.5">Password</label>
            <input type="password" name="password" required placeholder="••••••••"
                class="w-full p-3.5 rounded-2xl bg-brand-50 border border-brand-200 focus:border-brand-500 focus:ring-1 focus:ring-brand-500 outline-none transition text-sm">
        </div>

        <button class="w-full mt-2 bg-brand-500 hover:bg-brand-600 active:scale-[0.98] text-white py-3.5 rounded-2xl font-semibold tracking-wide shadow-lg shadow-brand-500/10 hover:shadow-brand-500/25 transition duration-200 cursor-pointer">
            Masuk Sekarang
        </button>
    </form>

    <div class="mt-6 pt-6 border-t border-brand-100 text-center">
        <p class="text-sm text-gray-600">
            Belum punya akun? 
            <a href="/register" class="text-brand-500 font-semibold hover:underline">Daftar gratis</a>
        </p>
    </div>

</div>

</body>
</html>