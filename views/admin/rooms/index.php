<?php require __DIR__ . '/../../partials/header.php'; ?>

<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-2xl font-bold text-slate-800">Zarządzanie salami</h1>
        <p class="text-sm text-slate-500 mt-0.5">Wszystkie sale w systemie</p>
    </div>
    <a href="<?= url('admin/rooms/create') ?>"
       class="bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium px-4 py-2 rounded-xl transition">
        + Dodaj salę
    </a>
</div>

<?php if (empty($rooms)): ?>
    <div class="bg-blue-50 border border-blue-200 text-blue-700 rounded-xl px-5 py-4 text-sm">
        Brak sal w systemie.
        <a href="<?= url('admin/rooms/create') ?>" class="underline font-medium">Dodaj pierwszą</a>.
    </div>
<?php else: ?>
    <div class="overflow-x-auto rounded-2xl shadow-sm border border-slate-200">
        <table class="min-w-full bg-white text-sm">
            <thead class="bg-slate-50 border-b border-slate-200">
                <tr>
                    <th class="px-5 py-3.5 text-left text-xs font-semibold text-slate-500 uppercase tracking-wide">#</th>
                    <th class="px-5 py-3.5 text-left text-xs font-semibold text-slate-500 uppercase tracking-wide">Nazwa</th>
                    <th class="px-5 py-3.5 text-left text-xs font-semibold text-slate-500 uppercase tracking-wide">Budynek / Piętro</th>
                    <th class="px-5 py-3.5 text-left text-xs font-semibold text-slate-500 uppercase tracking-wide">Pojemność</th>
                    <th class="px-5 py-3.5 text-left text-xs font-semibold text-slate-500 uppercase tracking-wide">Status</th>
                    <th class="px-5 py-3.5 text-right text-xs font-semibold text-slate-500 uppercase tracking-wide">Akcje</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
            <?php foreach ($rooms as $room): ?>
                <tr class="hover:bg-slate-50/60 transition">
                    <td class="px-5 py-3.5 text-slate-400"><?= $room['id'] ?></td>
                    <td class="px-5 py-3.5">
                        <span class="font-medium text-slate-800"><?= htmlspecialchars($room['name']) ?></span>
                        <?php if ($room['description']): ?>
                            <p class="text-xs text-slate-400 truncate max-w-xs"><?= htmlspecialchars($room['description']) ?></p>
                        <?php endif; ?>
                    </td>
                    <td class="px-5 py-3.5 text-slate-600">
                        <?= htmlspecialchars($room['building']) ?>
                        / <?= $room['floor'] == 0 ? 'Parter' : $room['floor'] . 'p.' ?>
                    </td>
                    <td class="px-5 py-3.5 text-slate-600"><?= $room['capacity'] ?> os.</td>
                    <td class="px-5 py-3.5">
                        <?php if ($room['is_active']): ?>
                            <span class="inline-flex items-center gap-1 bg-green-100 text-green-700 text-xs font-medium px-2.5 py-1 rounded-full">
                                <span class="w-1.5 h-1.5 bg-green-500 rounded-full"></span>Aktywna
                            </span>
                        <?php else: ?>
                            <span class="inline-flex items-center gap-1 bg-slate-100 text-slate-500 text-xs font-medium px-2.5 py-1 rounded-full">
                                <span class="w-1.5 h-1.5 bg-slate-400 rounded-full"></span>Nieaktywna
                            </span>
                        <?php endif; ?>
                    </td>
                    <td class="px-5 py-3.5 text-right flex justify-end gap-2">
                        <a href="<?= url('admin/rooms/edit/' . $room['id']) ?>"
                           class="border border-amber-300 text-amber-600 hover:bg-amber-50 text-xs px-3 py-1.5 rounded-lg transition">
                            Edytuj
                        </a>
                        <form method="POST"
                              action="<?= url('admin/rooms/delete/' . $room['id']) ?>"
                              onsubmit="return confirm('Usunąć salę <?= htmlspecialchars(addslashes($room['name'])) ?>? Wszystkie rezerwacje zostaną usunięte.')">
                            <button class="border border-red-300 text-red-600 hover:bg-red-50 text-xs px-3 py-1.5 rounded-lg transition">
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

<?php require __DIR__ . '/../../partials/footer.php'; ?>
