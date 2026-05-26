<?php require __DIR__ . '/../partials/header.php'; ?>

<div class="min-h-[60vh] flex items-center justify-center">
    <div class="w-full max-w-md">
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-14 h-14 rounded-full bg-indigo-100 mb-4">
                <svg class="w-7 h-7 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                </svg>
            </div>
            <h1 class="text-2xl font-bold text-slate-800">Rejestracja studenta</h1>
            <p class="text-sm text-slate-500 mt-1">Utwórz konto, aby rezerwować sale</p>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-8">
            <form method="POST" action="<?= url('register/store') ?>" class="space-y-4">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="first_name" class="block text-sm font-medium text-slate-700 mb-1.5">
                            Imię <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="first_name" name="first_name"
                               value="<?= htmlspecialchars($_POST['first_name'] ?? '') ?>"
                               required
                               class="w-full border border-slate-300 rounded-xl px-3.5 py-2.5 text-sm
                                      focus:outline-none focus:ring-2 focus:ring-indigo-400 transition">
                    </div>
                    <div>
                        <label for="last_name" class="block text-sm font-medium text-slate-700 mb-1.5">
                            Nazwisko <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="last_name" name="last_name"
                               value="<?= htmlspecialchars($_POST['last_name'] ?? '') ?>"
                               required
                               class="w-full border border-slate-300 rounded-xl px-3.5 py-2.5 text-sm
                                      focus:outline-none focus:ring-2 focus:ring-indigo-400 transition">
                    </div>
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-slate-700 mb-1.5">
                        Adres e-mail <span class="text-red-500">*</span>
                    </label>
                    <input type="email" id="email" name="email"
                           value="<?= htmlspecialchars($_POST['email'] ?? '') ?>"
                           required autocomplete="email"
                           class="w-full border border-slate-300 rounded-xl px-3.5 py-2.5 text-sm
                                  focus:outline-none focus:ring-2 focus:ring-indigo-400 transition">
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-slate-700 mb-1.5">
                        Hasło <span class="text-red-500">*</span>
                        <span class="text-slate-400 font-normal">(min. 6 znaków)</span>
                    </label>
                    <input type="password" id="password" name="password"
                           required minlength="6"
                           class="w-full border border-slate-300 rounded-xl px-3.5 py-2.5 text-sm
                                  focus:outline-none focus:ring-2 focus:ring-indigo-400 transition">
                </div>

                <div>
                    <label for="password2" class="block text-sm font-medium text-slate-700 mb-1.5">
                        Powtórz hasło <span class="text-red-500">*</span>
                    </label>
                    <input type="password" id="password2" name="password2"
                           required
                           class="w-full border border-slate-300 rounded-xl px-3.5 py-2.5 text-sm
                                  focus:outline-none focus:ring-2 focus:ring-indigo-400 transition">
                </div>

                <button type="submit"
                        class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2.5 rounded-xl text-sm transition mt-2">
                    Utwórz konto
                </button>
            </form>

            <p class="text-center text-sm text-slate-500 mt-5">
                Masz już konto?
                <a href="<?= url('login') ?>" class="text-indigo-600 hover:underline font-medium">Zaloguj się</a>
            </p>
        </div>
    </div>
</div>

<?php require __DIR__ . '/../partials/footer.php'; ?>
