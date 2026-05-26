<?php require __DIR__ . '/../partials/header.php'; ?>

<div class="max-w-2xl">
    <div class="mb-6">
        <a href="<?= url('rooms?date=' . urlencode($date)) ?>"
           class="inline-flex items-center gap-1 text-sm text-indigo-600 hover:underline mb-3">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Wróć do listy sal
        </a>
        <h1 class="text-2xl font-bold text-slate-800">Rezerwacja sali</h1>
        <p class="text-slate-500 text-sm mt-0.5">
            <strong><?= htmlspecialchars($room['name']) ?></strong>
            &bull; <?= htmlspecialchars($room['building']) ?>
            &bull; poj. <?= $room['capacity'] ?> os.
        </p>
    </div>

    <?php if (!empty($reservations)): ?>
        <div class="bg-amber-50 border border-amber-200 rounded-xl px-5 py-4 mb-6">
            <p class="text-sm font-semibold text-amber-800 mb-2">
                Zajęte terminy w dniu <?= date('j F Y', strtotime($date)) ?>:
            </p>
            <ul class="space-y-1">
                <?php foreach ($reservations as $r): ?>
                    <li class="text-sm text-amber-700">
                        <?= substr($r['start_time'], 0, 5) ?> – <?= substr($r['end_time'], 0, 5) ?>
                        <?php if ($r['purpose']): ?>
                            <span class="text-amber-500">(<?= htmlspecialchars($r['purpose']) ?>)</span>
                        <?php endif; ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php else: ?>
        <div class="bg-green-50 border border-green-200 text-green-700 rounded-xl px-5 py-3 text-sm mb-6">
            Sala jest wolna przez cały dzień <?= date('j F Y', strtotime($date)) ?>.
        </div>
    <?php endif; ?>

    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
        <h2 class="text-base font-semibold text-slate-700 mb-5">Dane rezerwacji</h2>

        <form method="POST" action="<?= url('rooms/reserve/' . $room['id']) ?>" class="space-y-5">
            <div>
                <label for="date" class="block text-sm font-medium text-slate-700 mb-1.5">
                    Data <span class="text-red-500">*</span>
                </label>
                <input type="date" id="date" name="date"
                       value="<?= htmlspecialchars($date) ?>"
                       min="<?= date('Y-m-d') ?>"
                       required
                       class="w-full border border-slate-300 rounded-xl px-3.5 py-2.5 text-sm
                              focus:outline-none focus:ring-2 focus:ring-indigo-400 transition">
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label for="start_time" class="block text-sm font-medium text-slate-700 mb-1.5">
                        Godzina od <span class="text-red-500">*</span>
                    </label>
                    <input type="time" id="start_time" name="start_time"
                           value="<?= htmlspecialchars($_POST['start_time'] ?? '08:00') ?>"
                           required
                           class="w-full border border-slate-300 rounded-xl px-3.5 py-2.5 text-sm
                                  focus:outline-none focus:ring-2 focus:ring-indigo-400 transition">
                </div>
                <div>
                    <label for="end_time" class="block text-sm font-medium text-slate-700 mb-1.5">
                        Godzina do <span class="text-red-500">*</span>
                    </label>
                    <input type="time" id="end_time" name="end_time"
                           value="<?= htmlspecialchars($_POST['end_time'] ?? '10:00') ?>"
                           required
                           class="w-full border border-slate-300 rounded-xl px-3.5 py-2.5 text-sm
                                  focus:outline-none focus:ring-2 focus:ring-indigo-400 transition">
                </div>
            </div>

            <div>
                <label for="purpose" class="block text-sm font-medium text-slate-700 mb-1.5">
                    Cel rezerwacji <span class="text-slate-400 font-normal">(opcjonalne)</span>
                </label>
                <input type="text" id="purpose" name="purpose"
                       value="<?= htmlspecialchars($_POST['purpose'] ?? '') ?>"
                       placeholder="np. Nauka do egzaminu, Praca grupowa…"
                       class="w-full border border-slate-300 rounded-xl px-3.5 py-2.5 text-sm
                              focus:outline-none focus:ring-2 focus:ring-indigo-400 transition">
            </div>

            <div class="flex gap-3 pt-1">
                <button type="submit"
                        class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-6 py-2.5 rounded-xl text-sm transition">
                    Zarezerwuj salę
                </button>
                <a href="<?= url('rooms?date=' . urlencode($date)) ?>"
                   class="border border-slate-300 hover:bg-slate-50 text-slate-700 px-5 py-2.5 rounded-xl text-sm transition">
                    Anuluj
                </a>
            </div>
        </form>
    </div>
</div>

<?php require __DIR__ . '/../partials/footer.php'; ?>
