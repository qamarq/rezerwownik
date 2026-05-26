<?php require __DIR__ . '/../../partials/header.php'; ?>

<div class="mb-6">
    <h1 class="text-2xl font-bold text-slate-800">Wszystkie rezerwacje</h1>
    <p class="text-sm text-slate-500 mt-0.5">Przegląd i zarządzanie rezerwacjami studentów</p>
</div>

<?php if (empty($reservations)): ?>
    <div class="bg-blue-50 border border-blue-200 text-blue-700 rounded-xl px-5 py-4 text-sm">
        Brak rezerwacji w systemie.
    </div>
<?php else: ?>
    <div class="overflow-x-auto rounded-2xl shadow-sm border border-slate-200">
        <table class="min-w-full bg-white text-sm">
            <thead class="bg-slate-50 border-b border-slate-200">
                <tr>
                    <th class="px-5 py-3.5 text-left text-xs font-semibold text-slate-500 uppercase tracking-wide">#</th>
                    <th class="px-5 py-3.5 text-left text-xs font-semibold text-slate-500 uppercase tracking-wide">Student</th>
                    <th class="px-5 py-3.5 text-left text-xs font-semibold text-slate-500 uppercase tracking-wide">Sala</th>
                    <th class="px-5 py-3.5 text-left text-xs font-semibold text-slate-500 uppercase tracking-wide">Data</th>
                    <th class="px-5 py-3.5 text-left text-xs font-semibold text-slate-500 uppercase tracking-wide">Godziny</th>
                    <th class="px-5 py-3.5 text-left text-xs font-semibold text-slate-500 uppercase tracking-wide">Cel</th>
                    <th class="px-5 py-3.5 text-left text-xs font-semibold text-slate-500 uppercase tracking-wide">Status</th>
                    <th class="px-5 py-3.5 text-right text-xs font-semibold text-slate-500 uppercase tracking-wide">Akcje</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
            <?php foreach ($reservations as $r): ?>
                <tr class="hover:bg-slate-50/60 transition">
                    <td class="px-5 py-3.5 text-slate-400"><?= $r['id'] ?></td>
                    <td class="px-5 py-3.5">
                        <span class="font-medium text-slate-800">
                            <?= htmlspecialchars($r['first_name'] . ' ' . $r['last_name']) ?>
                        </span><br>
                        <span class="text-xs text-slate-400"><?= htmlspecialchars($r['email']) ?></span>
                    </td>
                    <td class="px-5 py-3.5">
                        <span class="font-medium text-slate-700"><?= htmlspecialchars($r['room_name']) ?></span><br>
                        <span class="text-xs text-slate-400"><?= htmlspecialchars($r['building']) ?></span>
                    </td>
                    <td class="px-5 py-3.5 text-slate-700">
                        <?= date('j M Y', strtotime($r['reservation_date'])) ?>
                    </td>
                    <td class="px-5 py-3.5 text-slate-700 font-mono text-xs">
                        <?= substr($r['start_time'], 0, 5) ?> – <?= substr($r['end_time'], 0, 5) ?>
                    </td>
                    <td class="px-5 py-3.5 text-slate-500">
                        <?= $r['purpose'] ? htmlspecialchars($r['purpose']) : '—' ?>
                    </td>
                    <td class="px-5 py-3.5">
                        <?php if ($r['status'] === 'aktywna'): ?>
                            <span class="inline-flex items-center gap-1 bg-green-100 text-green-700 text-xs font-medium px-2.5 py-1 rounded-full">
                                <span class="w-1.5 h-1.5 bg-green-500 rounded-full"></span>Aktywna
                            </span>
                        <?php else: ?>
                            <span class="inline-flex items-center gap-1 bg-slate-100 text-slate-500 text-xs font-medium px-2.5 py-1 rounded-full">
                                <span class="w-1.5 h-1.5 bg-slate-400 rounded-full"></span>Anulowana
                            </span>
                        <?php endif; ?>
                    </td>
                    <td class="px-5 py-3.5 text-right">
                        <?php if ($r['status'] === 'aktywna'): ?>
                            <form method="POST"
                                  action="<?= url('my-reservations/cancel/' . $r['id']) ?>"
                                  onsubmit="return confirm('Anulować rezerwację #<?= $r['id'] ?>?')">
                                <button class="border border-red-300 text-red-600 hover:bg-red-50 text-xs px-3 py-1.5 rounded-lg transition">
                                    Anuluj
                                </button>
                            </form>
                        <?php else: ?>
                            <span class="text-slate-300 text-xs">—</span>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php endif; ?>

<?php require __DIR__ . '/../../partials/footer.php'; ?>
