<?php $pageTitle = 'Nie znaleziono'; require __DIR__ . '/../partials/header.php'; ?>

<div class="min-h-[60vh] flex items-center justify-center">
    <div class="text-center">
        <p class="text-6xl font-bold text-indigo-200 mb-4">404</p>
        <h1 class="text-2xl font-bold text-slate-800 mb-2">Strona nie istnieje</h1>
        <p class="text-slate-500 mb-6">Żądany zasób nie został znaleziony.</p>
        <a href="<?= url() ?>" class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2.5 rounded-xl text-sm font-medium transition">
            Wróć do strony głównej
        </a>
    </div>
</div>

<?php require __DIR__ . '/../partials/footer.php'; ?>
