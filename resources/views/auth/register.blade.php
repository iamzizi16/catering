@vite('resources/css/app.css')

<body class="bg-gray-950 text-white flex items-center justify-center min-h-screen">

<div class="bg-white/10 backdrop-blur-lg p-8 rounded-2xl w-80 border border-white/10">

    <h1 class="text-2xl font-bold mb-6 text-center">Register ✨</h1>

    <form method="POST" action="/register" class="space-y-4">
    @csrf

    <input name="name" placeholder="Nama"
        class="w-full p-3 rounded bg-white/10 border border-white/10">

    <input name="email" placeholder="Email"
        class="w-full p-3 rounded bg-white/10 border border-white/10">

    <input type="password" name="password" placeholder="Password"
        class="w-full p-3 rounded bg-white/10 border border-white/10">

    <button class="w-full bg-gradient-to-r from-orange-500 to-red-500 py-2 rounded">
        Register
    </button>

    </form>

</div>

</body>