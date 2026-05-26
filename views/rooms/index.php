<?php require __DIR__ . '/../partials/header.php'; ?>

<div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
    <div>
        <h1 class="text-2xl font-bold text-slate-800">Dostępne sale</h1>
        <p class="text-sm text-slate-500 mt-0.5">Wybierz datę i zarezerwuj salę</p>
    </div>

    <form method="GET" action="<?= url('rooms') ?>" class="flex items-center gap-2">
        <label for="date" class="text-sm text-slate-600 font-medium">Data:</label>
        <input type="date" id="date" name="date"
               value="<?= htmlspecialchars($date) ?>"
               min="<?= date('Y-m-d') ?>"
               class="border border-slate-300 rounded-xl px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-400 transition">
        <button type="submit"
                class="bg-indigo-600 hover:bg-indigo-700 text-white text-sm px-4 py-2 rounded-xl transition">
            Pokaż
        </button>
    </form>
</div>

<p class="text-sm text-slate-500 mb-5">
    Wyniki dla: <strong class="text-slate-700"><?= date('j F Y', strtotime($date)) ?></strong>
</p>

<?php if (empty($rooms)): ?>
    <div class="bg-blue-50 border border-blue-200 text-blue-700 rounded-xl px-5 py-4 text-sm">
        Brak dostępnych sal w systemie.
    </div>
<?php else: ?>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
        <?php foreach ($rooms as $room): ?>
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm hover:shadow-md transition overflow-hidden flex flex-col">
                <div class="bg-gradient-to-br from-indigo-50 to-indigo-100 px-5 py-4 border-b border-slate-100">
                    <h2 class="font-bold text-slate-800 text-lg"><?= htmlspecialchars($room['name']) ?></h2>
                    <p class="text-sm text-slate-500">
                        <?= htmlspecialchars($room['building']) ?>
                        &bull; <?= $room['floor'] === 0 ? 'Parter' : $room['floor'] . '. piętro' ?>
                    </p>
                </div>

                <div class="px-5 py-4 flex-1">
                    <?php if ($room['description']): ?>
                        <p class="text-sm text-slate-600 mb-3"><?= htmlspecialchars($room['description']) ?></p>
                    <?php endif; ?>

                    <div class="flex items-center gap-4 text-xs text-slate-500">
                        <span class="flex items-center gap-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            Pojemność: <?= $room['capacity'] ?> os.
                        </span>
                        <span class="flex items-center gap-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            Rez. w ten dzień: <?= (int)$room['bookings_count'] ?>
                        </span>
                    </div>
                </div>

                <div class="px-5 pb-4">
                    <a href="<?= url('rooms/reserve/' . $room['id'] . '?date=' . urlencode($date)) ?>"
                       class="block w-full text-center bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium py-2.5 rounded-xl transition">
                        Zarezerwuj
                    </a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<?php require __DIR__ . '/../partials/footer.php'; ?>
