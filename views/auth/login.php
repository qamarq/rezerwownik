<?php require __DIR__ . '/../partials/header.php'; ?>

<div class="min-h-[60vh] flex items-center justify-center">
    <div class="w-full max-w-md">
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-14 h-14 rounded-full bg-indigo-100 mb-4">
                <svg class="w-7 h-7 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                </svg>
            </div>
            <h1 class="text-2xl font-bold text-slate-800">Zaloguj się</h1>
            <p class="text-sm text-slate-500 mt-1">Dostęp do systemu rezerwacji sal</p>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-8">
            <form method="POST" action="<?= url('login/store') ?>" class="space-y-5">
                <div>
                    <label for="email" class="block text-sm font-medium text-slate-700 mb-1.5">
                        Adres e-mail
                    </label>
                    <input type="email" id="email" name="email"
                           value="<?= htmlspecialchars($_POST['email'] ?? '') ?>"
                           required autocomplete="email"
                           class="w-full border border-slate-300 rounded-xl px-3.5 py-2.5 text-sm
                                  focus:outline-none focus:ring-2 focus:ring-indigo-400 focus:border-transparent transition">
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-slate-700 mb-1.5">
                        Hasło
                    </label>
                    <input type="password" id="password" name="password"
                           required autocomplete="current-password"
                           class="w-full border border-slate-300 rounded-xl px-3.5 py-2.5 text-sm
                                  focus:outline-none focus:ring-2 focus:ring-indigo-400 focus:border-transparent transition">
                </div>

                <button type="submit"
                        class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2.5 rounded-xl text-sm transition">
                    Zaloguj się
                </button>
            </form>

            <p class="text-center text-sm text-slate-500 mt-5">
                Nie masz konta?
                <a href="<?= url('register') ?>" class="text-indigo-600 hover:underline font-medium">Zarejestruj się</a>
            </p>
        </div>

        <p class="text-center text-xs text-slate-400 mt-4">
            Konta testowe (hasło: <code class="bg-slate-100 px-1 rounded">password</code>):<br>
            pracownik@uczelnia.pl &bull; jan.kowalski@student.pl
        </p>
    </div>
</div>

<?php require __DIR__ . '/../partials/footer.php'; ?>
