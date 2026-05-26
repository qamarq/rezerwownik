<?php require __DIR__ . '/../../partials/header.php'; ?>

<div class="max-w-xl">
    <div class="mb-6">
        <a href="<?= url('admin/rooms') ?>" class="inline-flex items-center gap-1 text-sm text-indigo-600 hover:underline mb-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Wróć do listy sal
        </a>
        <h1 class="text-2xl font-bold text-slate-800">Edytuj salę</h1>
    </div>

    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
        <form method="POST" action="<?= url('admin/rooms/update/' . $room['id']) ?>" class="space-y-5">
            <div>
                <label for="name" class="block text-sm font-medium text-slate-700 mb-1.5">
                    Nazwa sali <span class="text-red-500">*</span>
                </label>
                <input type="text" id="name" name="name"
                       value="<?= htmlspecialchars($_POST['name'] ?? $room['name']) ?>"
                       required
                       class="w-full border border-slate-300 rounded-xl px-3.5 py-2.5 text-sm
                              focus:outline-none focus:ring-2 focus:ring-indigo-400 transition">
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label for="building" class="block text-sm font-medium text-slate-700 mb-1.5">
                        Budynek <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="building" name="building"
                           value="<?= htmlspecialchars($_POST['building'] ?? $room['building']) ?>"
                           required
                           class="w-full border border-slate-300 rounded-xl px-3.5 py-2.5 text-sm
                                  focus:outline-none focus:ring-2 focus:ring-indigo-400 transition">
                </div>
                <div>
                    <label for="floor" class="block text-sm font-medium text-slate-700 mb-1.5">Piętro</label>
                    <input type="number" id="floor" name="floor"
                           value="<?= htmlspecialchars($_POST['floor'] ?? $room['floor']) ?>"
                           min="-1" max="30"
                           class="w-full border border-slate-300 rounded-xl px-3.5 py-2.5 text-sm
                                  focus:outline-none focus:ring-2 focus:ring-indigo-400 transition">
                </div>
            </div>

            <div>
                <label for="capacity" class="block text-sm font-medium text-slate-700 mb-1.5">
                    Pojemność (liczba osób) <span class="text-red-500">*</span>
                </label>
                <input type="number" id="capacity" name="capacity"
                       value="<?= htmlspecialchars($_POST['capacity'] ?? $room['capacity']) ?>"
                       required min="1" max="500"
                       class="w-full border border-slate-300 rounded-xl px-3.5 py-2.5 text-sm
                              focus:outline-none focus:ring-2 focus:ring-indigo-400 transition">
            </div>

            <div>
                <label for="description" class="block text-sm font-medium text-slate-700 mb-1.5">
                    Opis / wyposażenie
                </label>
                <textarea id="description" name="description" rows="3"
                          class="w-full border border-slate-300 rounded-xl px-3.5 py-2.5 text-sm
                                 focus:outline-none focus:ring-2 focus:ring-indigo-400 transition"><?= htmlspecialchars($_POST['description'] ?? $room['description'] ?? '') ?></textarea>
            </div>

            <div class="flex items-center gap-2">
                <input type="checkbox" id="is_active" name="is_active" value="1"
                       <?= (isset($_POST['is_active']) ? (bool)$_POST['is_active'] : (bool)$room['is_active']) ? 'checked' : '' ?>
                       class="w-4 h-4 accent-indigo-600">
                <label for="is_active" class="text-sm text-slate-700 font-medium">
                    Sala aktywna (dostępna do rezerwacji)
                </label>
            </div>

            <div class="flex gap-3 pt-1">
                <button type="submit"
                        class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-6 py-2.5 rounded-xl text-sm transition">
                    Zapisz zmiany
                </button>
                <a href="<?= url('admin/rooms') ?>"
                   class="border border-slate-300 hover:bg-slate-50 text-slate-700 px-5 py-2.5 rounded-xl text-sm transition">
                    Anuluj
                </a>
            </div>
        </form>
    </div>
</div>

<?php require __DIR__ . '/../../partials/footer.php'; ?>
