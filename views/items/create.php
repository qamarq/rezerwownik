<?php $pageTitle = 'Dodaj rekord'; require __DIR__ . '/../partials/header.php'; ?>

<div class="max-w-lg mx-auto bg-white rounded-xl shadow p-6">
    <h2 class="text-xl font-semibold text-gray-800 mb-6">Dodaj nowy rekord</h2>

    <form method="POST" action="/projekt/items/store" class="space-y-4">
        <div>
            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">
                Nazwa <span class="text-red-500">*</span>
            </label>
            <input type="text" id="name" name="name"
                   value="<?= htmlspecialchars($_POST['name'] ?? '') ?>"
                   required
                   class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-400">
        </div>

        <div>
            <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Opis</label>
            <textarea id="description" name="description" rows="4"
                      class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-400"><?= htmlspecialchars($_POST['description'] ?? '') ?></textarea>
        </div>

        <div class="flex gap-3 pt-2">
            <button type="submit"
                    class="bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium px-5 py-2 rounded-lg transition">
                Zapisz
            </button>
            <a href="/projekt/items"
               class="border border-gray-300 hover:bg-gray-50 text-gray-700 text-sm px-5 py-2 rounded-lg transition">
                Anuluj
            </a>
        </div>
    </form>
</div>

<?php require __DIR__ . '/../partials/footer.php'; ?>
