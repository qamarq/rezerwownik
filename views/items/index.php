<?php $pageTitle = 'Lista rekordów'; require __DIR__ . '/../partials/header.php'; ?>

<div class="flex items-center justify-between mb-6">
    <h2 class="text-2xl font-semibold text-gray-800">Lista rekordów</h2>
    <a href="/projekt/items/create"
       class="bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium px-4 py-2 rounded-lg transition">
        + Dodaj nowy
    </a>
</div>

<?php if (empty($items)): ?>
    <div class="bg-blue-50 border border-blue-200 text-blue-700 rounded-lg px-4 py-3 text-sm">
        Brak rekordów. <a href="/projekt/items/create" class="underline">Dodaj pierwszy</a>.
    </div>
<?php else: ?>
    <div class="overflow-x-auto rounded-xl shadow">
        <table class="min-w-full bg-white text-sm">
            <thead class="bg-indigo-600 text-white">
                <tr>
                    <th class="px-4 py-3 text-left font-medium w-12">#</th>
                    <th class="px-4 py-3 text-left font-medium">Nazwa</th>
                    <th class="px-4 py-3 text-left font-medium">Opis</th>
                    <th class="px-4 py-3 text-right font-medium">Akcje</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
            <?php foreach ($items as $item): ?>
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-4 py-3 text-gray-500"><?= $item['id'] ?></td>
                    <td class="px-4 py-3 font-medium text-gray-800"><?= htmlspecialchars($item['name']) ?></td>
                    <td class="px-4 py-3 text-gray-600"><?= htmlspecialchars($item['description'] ?? '') ?></td>
                    <td class="px-4 py-3 text-right flex justify-end gap-2">
                        <a href="/projekt/items/edit/<?= $item['id'] ?>"
                           class="border border-yellow-400 text-yellow-600 hover:bg-yellow-50 text-xs px-3 py-1.5 rounded-lg transition">
                            Edytuj
                        </a>
                        <form method="POST" action="/projekt/items/delete/<?= $item['id'] ?>"
                              onsubmit="return confirm('Na pewno usunąć?')">
                            <button class="border border-red-400 text-red-600 hover:bg-red-50 text-xs px-3 py-1.5 rounded-lg transition">
                                Usuń
                            </button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php endif; ?>

<?php require __DIR__ . '/../partials/footer.php'; ?>
