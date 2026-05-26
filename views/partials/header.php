<!doctype html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= htmlspecialchars($pageTitle ?? 'Strona') ?> — <?= htmlspecialchars($_ENV['APP_NAME']) ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-50 min-h-screen">

<nav class="bg-indigo-700 text-white shadow-lg">
    <div class="max-w-6xl mx-auto px-4 py-3 flex items-center justify-between">
        <a href="<?= url() ?>" class="text-lg font-bold tracking-tight flex items-center gap-2">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-2 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
            </svg>
            <?= htmlspecialchars($_ENV['APP_NAME']) ?>
        </a>

        <div class="flex items-center gap-1 text-sm">
            <?php if (\App\Auth::check()): ?>
                <a href="<?= url('rooms') ?>"
                   class="px-3 py-2 rounded-lg hover:bg-indigo-600 transition">Sale</a>
                <a href="<?= url('my-reservations') ?>"
                   class="px-3 py-2 rounded-lg hover:bg-indigo-600 transition">Moje rezerwacje</a>

                <?php if (\App\Auth::isPracownik()): ?>
                    <span class="w-px h-5 bg-indigo-500 mx-1"></span>
                    <a href="<?= url('admin/rooms') ?>"
                       class="px-3 py-2 rounded-lg hover:bg-indigo-600 transition">Sale (admin)</a>
                    <a href="<?= url('admin/reservations') ?>"
                       class="px-3 py-2 rounded-lg hover:bg-indigo-600 transition">Rezerwacje</a>
                    <a href="<?= url('admin/users') ?>"
                       class="px-3 py-2 rounded-lg hover:bg-indigo-600 transition">Użytkownicy</a>
                <?php endif; ?>

                <span class="w-px h-5 bg-indigo-500 mx-1"></span>
                <span class="text-indigo-200 text-xs px-2">
                    <?= htmlspecialchars(\App\Auth::user()['first_name'] . ' ' . \App\Auth::user()['last_name']) ?>
                    <span class="opacity-60">(<?= \App\Auth::role() ?>)</span>
                </span>
                <a href="<?= url('logout') ?>"
                   class="ml-1 bg-white/15 hover:bg-white/25 px-3 py-1.5 rounded-lg text-xs transition">
                    Wyloguj
                </a>
            <?php else: ?>
                <a href="<?= url('login') ?>"
                   class="px-3 py-2 rounded-lg hover:bg-indigo-600 transition">Zaloguj się</a>
                <a href="<?= url('register') ?>"
                   class="bg-white text-indigo-700 hover:bg-indigo-50 px-4 py-1.5 rounded-lg text-xs font-semibold transition ml-1">
                    Zarejestruj się
                </a>
            <?php endif; ?>
        </div>
    </div>
</nav>

<div class="max-w-6xl mx-auto px-4 py-8">

<?php if (!empty($_SESSION['success'])): ?>
    <div class="mb-5 rounded-xl bg-green-50 border border-green-200 text-green-800 px-4 py-3 text-sm flex items-center gap-2">
        <svg class="w-4 h-4 text-green-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
        </svg>
        <?= htmlspecialchars($_SESSION['success']) ?>
    </div>
    <?php unset($_SESSION['success']); ?>
<?php endif; ?>

<?php if (!empty($_SESSION['error'])): ?>
    <div class="mb-5 rounded-xl bg-red-50 border border-red-200 text-red-800 px-4 py-3 text-sm flex items-center gap-2">
        <svg class="w-4 h-4 text-red-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
        </svg>
        <?= htmlspecialchars($_SESSION['error']) ?>
    </div>
    <?php unset($_SESSION['error']); ?>
<?php endif; ?>
