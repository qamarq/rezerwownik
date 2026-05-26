<?php require __DIR__ . '/../../partials/header.php'; ?>

<div class="mb-6">
    <h1 class="text-2xl font-bold text-slate-800">Zarządzanie użytkownikami</h1>
    <p class="text-sm text-slate-500 mt-0.5">Studenci i pracownicy zarejestrowani w systemie</p>
</div>

<div class="overflow-x-auto rounded-2xl shadow-sm border border-slate-200">
    <table class="min-w-full bg-white text-sm">
        <thead class="bg-slate-50 border-b border-slate-200">
            <tr>
                <th class="px-5 py-3.5 text-left text-xs font-semibold text-slate-500 uppercase tracking-wide">#</th>
                <th class="px-5 py-3.5 text-left text-xs font-semibold text-slate-500 uppercase tracking-wide">Imię i nazwisko</th>
                <th class="px-5 py-3.5 text-left text-xs font-semibold text-slate-500 uppercase tracking-wide">E-mail</th>
                <th class="px-5 py-3.5 text-left text-xs font-semibold text-slate-500 uppercase tracking-wide">Rola</th>
                <th class="px-5 py-3.5 text-left text-xs font-semibold text-slate-500 uppercase tracking-wide">Status</th>
                <th class="px-5 py-3.5 text-left text-xs font-semibold text-slate-500 uppercase tracking-wide">Data rejestracji</th>
                <th class="px-5 py-3.5 text-right text-xs font-semibold text-slate-500 uppercase tracking-wide">Akcje</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-100">
        <?php foreach ($users as $user): ?>
            <tr class="hover:bg-slate-50/60 transition">
                <td class="px-5 py-3.5 text-slate-400"><?= $user['id'] ?></td>
                <td class="px-5 py-3.5 font-medium text-slate-800">
                    <?= htmlspecialchars($user['first_name'] . ' ' . $user['last_name']) ?>
                    <?php if ((int)$user['id'] === \App\Auth::id()): ?>
                        <span class="ml-1 text-xs bg-indigo-100 text-indigo-600 px-1.5 py-0.5 rounded">Ty</span>
                    <?php endif; ?>
                </td>
                <td class="px-5 py-3.5 text-slate-500"><?= htmlspecialchars($user['email']) ?></td>
                <td class="px-5 py-3.5">
                    <?php if ($user['role'] === 'pracownik'): ?>
                        <span class="bg-purple-100 text-purple-700 text-xs font-medium px-2.5 py-1 rounded-full">Pracownik</span>
                    <?php else: ?>
                        <span class="bg-blue-100 text-blue-700 text-xs font-medium px-2.5 py-1 rounded-full">Student</span>
                    <?php endif; ?>
                </td>
                <td class="px-5 py-3.5">
                    <?php if ($user['is_active']): ?>
                        <span class="inline-flex items-center gap-1 bg-green-100 text-green-700 text-xs font-medium px-2.5 py-1 rounded-full">
                            <span class="w-1.5 h-1.5 bg-green-500 rounded-full"></span>Aktywne
                        </span>
                    <?php else: ?>
                        <span class="inline-flex items-center gap-1 bg-red-100 text-red-600 text-xs font-medium px-2.5 py-1 rounded-full">
                            <span class="w-1.5 h-1.5 bg-red-500 rounded-full"></span>Zablokowane
                        </span>
                    <?php endif; ?>
                </td>
                <td class="px-5 py-3.5 text-slate-400 text-xs">
                    <?= date('j M Y', strtotime($user['created_at'])) ?>
                </td>
                <td class="px-5 py-3.5 text-right">
                    <?php if ((int)$user['id'] !== \App\Auth::id()): ?>
                        <div class="flex justify-end gap-2">
                            <form method="POST"
                                  action="<?= url('admin/users/toggle/' . $user['id']) ?>"
                                  onsubmit="return confirm('Zmienić status konta?')">
                                <button class="border border-amber-300 text-amber-600 hover:bg-amber-50 text-xs px-3 py-1.5 rounded-lg transition">
                                    <?= $user['is_active'] ? 'Zablokuj' : 'Odblokuj' ?>
                                </button>
                            </form>
                            <form method="POST"
                                  action="<?= url('admin/users/delete/' . $user['id']) ?>"
                                  onsubmit="return confirm('Usunąć konto <?= htmlspecialchars(addslashes($user['first_name'] . ' ' . $user['last_name'])) ?>? Tej operacji nie można cofnąć.')">
                                <button class="border border-red-300 text-red-600 hover:bg-red-50 text-xs px-3 py-1.5 rounded-lg transition">
                                    Usuń
                                </button>
                            </form>
                        </div>
                    <?php else: ?>
                        <span class="text-slate-300 text-xs">—</span>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php require __DIR__ . '/../../partials/footer.php'; ?>
