<?php $pageTitle = 'Strona główna'; require __DIR__ . '/partials/header.php'; ?>

<div class="text-center py-16">
    <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-indigo-100 mb-6">
        <svg class="w-10 h-10 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-2 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
        </svg>
    </div>

    <h1 class="text-3xl font-bold text-slate-800 mb-3">System rezerwacji sal do nauki</h1>
    <p class="text-slate-500 max-w-md mx-auto mb-8 text-base">
        Zaloguj się, aby przeglądać dostępne sale i składać rezerwacje online.
    </p>

    <div class="flex justify-center gap-4">
        <a href="<?= url('login') ?>"
           class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-6 py-3 rounded-xl transition text-sm">
            Zaloguj się
        </a>
        <a href="<?= url('register') ?>"
           class="border border-indigo-300 text-indigo-700 hover:bg-indigo-50 font-semibold px-6 py-3 rounded-xl transition text-sm">
            Zarejestruj się
        </a>
    </div>

    <div class="mt-16 grid grid-cols-1 md:grid-cols-3 gap-6 text-left max-w-3xl mx-auto">
        <div class="bg-white rounded-2xl border border-slate-200 p-5">
            <div class="w-10 h-10 rounded-xl bg-indigo-50 flex items-center justify-center mb-3">
                <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
            </div>
            <h3 class="font-semibold text-slate-800 mb-1">Przeglądaj sale</h3>
            <p class="text-sm text-slate-500">Sprawdź dostępność sal na wybrany dzień i godzinę.</p>
        </div>
        <div class="bg-white rounded-2xl border border-slate-200 p-5">
            <div class="w-10 h-10 rounded-xl bg-green-50 flex items-center justify-center mb-3">
                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
            </div>
            <h3 class="font-semibold text-slate-800 mb-1">Rezerwuj online</h3>
            <p class="text-sm text-slate-500">Złóż rezerwację w kilka kliknięć, bez kolejki.</p>
        </div>
        <div class="bg-white rounded-2xl border border-slate-200 p-5">
            <div class="w-10 h-10 rounded-xl bg-amber-50 flex items-center justify-center mb-3">
                <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
            </div>
            <h3 class="font-semibold text-slate-800 mb-1">Zarządzaj historią</h3>
            <p class="text-sm text-slate-500">Przeglądaj swoje rezerwacje i anuluj je w razie potrzeby.</p>
        </div>
    </div>
</div>

<?php require __DIR__ . '/partials/footer.php'; ?>
