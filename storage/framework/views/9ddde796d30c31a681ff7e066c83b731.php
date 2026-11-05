
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin | BI-KANTIN</title>

    <style>
        * { box-sizing: border-box; }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f1f5f9;
            color: #1e293b;
        }

        header {
            background: #0f766e;
            color: white;
            padding: 20px 5%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 16px;
        }

        header h1 { margin: 0; font-size: 24px; }

        .logout button {
            background: white;
            color: #0f766e;
            border: none;
            padding: 10px 16px;
            border-radius: 8px;
            cursor: pointer;
            font-weight: bold;
        }

        main {
            max-width: 1200px;
            margin: 30px auto;
            padding: 0 20px;
        }

        .section {
            background: white;
            padding: 24px;
            margin-bottom: 24px;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(15, 23, 42, .05);
        }

        h2 { margin-top: 0; }

        .form-grid {
    display: grid;
    grid-template-columns: repeat(3, minmax(0, 1fr));
    gap: 12px;
    align-items: end;
}

        label {
            display: block;
            margin-bottom: 7px;
            font-size: 14px;
            font-weight: bold;
        }

        input, select {
            width: 100%;
            padding: 11px;
            border: 1px solid #cbd5e1;
            border-radius: 7px;
            background: white;
        }

        button, .button {
            border: none;
            border-radius: 7px;
            padding: 10px 14px;
            cursor: pointer;
            font-weight: bold;
        }

        .primary { background: #0f766e; color: white; }
        .edit { background: #dbeafe; color: #1d4ed8; }
        .delete { background: #fee2e2; color: #b91c1c; }
        .status-button { background: #0f766e; color: white; }

        .table-wrapper { overflow-x: auto; }

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 650px;
        }

        th, td {
            text-align: left;
            padding: 13px;
            border-bottom: 1px solid #e2e8f0;
            vertical-align: top;
        }

        th { background: #f8fafc; }

        .actions {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
        }

        .message {
            padding: 12px 16px;
            margin-bottom: 16px;
            border-radius: 8px;
            background: #dcfce7;
            color: #166534;
        }

        .error {
            background: #fee2e2;
            color: #991b1b;
        }

        .status-form {
            display: flex;
            gap: 8px;
            min-width: 260px;
        }

        .status-form select { flex: 1; }

        .muted { color: #64748b; font-size: 14px; }

        @media (max-width: 800px) {
            .form-grid { grid-template-columns: 1fr; }
            header { align-items: flex-start; }
            header h1 { font-size: 20px; }
            .section { padding: 16px; }
        }
    </style>
</head>

<body>
    <header>
        <div>
            <h1>BI-KANTIN</h1>
            <div>Dashboard Admin</div>
        </div>

        <form class="logout" action="<?php echo e(route('logout')); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <button type="submit">Logout</button>
        </form>
    </header>

    <main>
        <?php if(session('success')): ?>
            <div class="message"><?php echo e(session('success')); ?></div>
        <?php endif; ?>

        <?php if(session('error')): ?>
            <div class="message error"><?php echo e(session('error')); ?></div>
        <?php endif; ?>

        <?php if($errors->any()): ?>
            <div class="message error">
                <strong>Periksa kembali data:</strong>
                <ul>
                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li><?php echo e($error); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>
        <?php endif; ?>

        <section class="section">
            <h2>Tambah Menu</h2>
            <p class="muted">
                Masukkan nama, harga, dan kategori makanan atau minuman.
            </p>

            <form action="<?php echo e(route('admin.menu.store')); ?>" method="POST">
                <?php echo csrf_field(); ?>

                <div class="form-grid">
                    <div>
                        <label for="nama_menu">Nama Menu</label>
                        <input
                            id="nama_menu"
                            type="text"
                            name="nama_menu"
                            maxlength="100"
                            required
                        >
                    </div>

                    <div>
                        <label for="harga">Harga (Rp)</label>
                        <input
                            id="harga"
                            type="number"
                            name="harga"
                            min="0"
                            required
                        >
                    </div>

                    <div>
                        <label for="kategori">Kategori</label>
                        <select id="kategori" name="kategori" required>
                            <option value="">Pilih kategori</option>
                            <option value="Makanan">Makanan</option>
                            <option value="Minuman">Minuman</option>
                        </select>
                    </div>

                    <div>
    <label for="deskripsi">Deskripsi Menu</label>
    <input
        id="deskripsi"
        type="text"
        name="deskripsi"
        maxlength="1000"
        placeholder="Contoh: Nasi goreng dengan telur"
    >
</div>

<div>
    <label for="foto">Foto Menu (URL)</label>
    <input
        id="foto"
        type="url"
        name="foto"
        maxlength="255"
        placeholder="https://contoh.com/foto.jpg"
    >
</div>

                    <button class="primary" type="submit">Tambah Menu</button>
                </div>
            </form>
        </section>

        <section class="section">
            <h2>Daftar Menu</h2>

            <div class="table-wrapper">
                <table>
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Nama Menu</th>
                            <th>Harga</th>
                            <th>Kategori</th>
                            <th>Aksi</th>
                            <th>Deskripsi</th>
                            <th>Foto</th>
                        </tr>
                    </thead>

                    
<tbody>
    <?php $__empty_1 = true; $__currentLoopData = $menus; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $menu): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <tr>
            <td><?php echo e($loop->iteration); ?></td>

            <td><?php echo e($menu->nama_menu); ?></td>

            <td>
                Rp <?php echo e(number_format($menu->harga, 0, ',', '.')); ?>

            </td>

            <td><?php echo e($menu->kategori); ?></td>

            <td>
                <div class="actions">
                    <button
                        type="button"
                        class="edit"
                        onclick="editMenu(
                            <?php echo e($menu->id); ?>,
                            <?php echo e(Illuminate\Support\Js::from($menu->nama_menu)); ?>,
                            <?php echo e($menu->harga); ?>,
                            <?php echo e(Illuminate\Support\Js::from($menu->kategori)); ?>,
                            <?php echo e(Illuminate\Support\Js::from($menu->deskripsi ?? '')); ?>,
                            <?php echo e(Illuminate\Support\Js::from($menu->foto ?? '')); ?>

                        )"
                    >
                        Edit
                    </button>

                    <form
                        action="<?php echo e(route('admin.menu.delete', $menu->id)); ?>"
                        method="POST"
                        onsubmit="return confirm('Yakin ingin menghapus menu ini?')"
                    >
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('DELETE'); ?>

                        <button class="delete" type="submit">
                            Hapus
                        </button>
                    </form>
                </div>
            </td>

            <td><?php echo e($menu->deskripsi ?? '-'); ?></td>

            <td>
                <?php if($menu->foto): ?>
                    <img
                        src="<?php echo e($menu->foto); ?>"
                        alt="<?php echo e($menu->nama_menu); ?>"
                        width="70"
                        style="height: 50px; object-fit: cover; border-radius: 6px;"
                    >
                <?php else: ?>
                    -
                <?php endif; ?>
            </td>
        </tr>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <tr>
            <td colspan="7">Belum ada menu.</td>
        </tr>
    <?php endif; ?>
</tbody>
                </table>
            </div>
        </section>

        <section class="section" id="edit-menu" hidden>
            <h2>Edit Menu</h2>

            <form id="edit-menu-form" method="POST">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>

                <div class="form-grid">
                    <div>
                        <label for="edit_nama_menu">Nama Menu</label>
                        <input
                            id="edit_nama_menu"
                            type="text"
                            name="nama_menu"
                            maxlength="100"
                            required
                        >
                    </div>

                    <div>
                        <label for="edit_harga">Harga (Rp)</label>
                        <input
                            id="edit_harga"
                            type="number"
                            name="harga"
                            min="0"
                            required
                        >
                    </div>

                    <div>
                        <label for="edit_kategori">Kategori</label>
                        <select id="edit_kategori" name="kategori" required>
                            <option value="Makanan">Makanan</option>
                            <option value="Minuman">Minuman</option>
                        </select>
                    </div>

                    <div>
    <label for="edit_deskripsi">Deskripsi Menu</label>
    <input
        id="edit_deskripsi"
        type="text"
        name="deskripsi"
        maxlength="1000"
        placeholder="Deskripsi menu"
    >
</div>

<div>
    <label for="edit_foto">Foto Menu (URL)</label>
    <input
        id="edit_foto"
        type="url"
        name="foto"
        maxlength="255"
        placeholder="https://contoh.com/foto.jpg"
    >
</div>

                    <div class="actions">
                        <button class="primary" type="submit">Simpan</button>
                        <button class="edit" type="button" onclick="cancelEdit()">
                            Batal
                        </button>
                    </div>
                </div>
            </form>
        </section>

        <section class="section">
            <h2>Daftar Pesanan</h2>

            <div class="table-wrapper">
                <table>
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Pemesan</th>
                            <th>Menu</th>
                            <th>Jumlah</th>
                            <th>Total Harga</th>
                            <th>Status</th>
                            <th>Ubah Status</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $pesanans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pesanan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td><?php echo e($loop->iteration); ?></td>
                                <td><?php echo e($pesanan->user->username ?? 'Akun tidak ditemukan'); ?></td>
                                <td><?php echo e($pesanan->menu->nama_menu ?? 'Menu tidak ditemukan'); ?></td>
                                <td><?php echo e($pesanan->jumlah); ?></td>
                                <td>Rp <?php echo e(number_format($pesanan->total_harga, 0, ',', '.')); ?></td>
                                <td><?php echo e($pesanan->status); ?></td>
                                <td>
                                    <form
                                        class="status-form"
                                        action="<?php echo e(route('admin.pesanan.status', $pesanan->id)); ?>"
                                        method="POST"
                                    >
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('PUT'); ?>

                                        <select name="status" required>
                                            <?php $__currentLoopData = [
                                                'Menunggu Konfirmasi',
                                                'Sedang Dimasak',
                                                'Siap Diambil',
                                                'Selesai'
                                            ]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option
                                                    value="<?php echo e($status); ?>"
                                                    <?php if($pesanan->status === $status): echo 'selected'; endif; ?>
                                                >
                                                    <?php echo e($status); ?>

                                                </option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>

                                        <button class="status-button" type="submit">
                                            Simpan
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="7">Belum ada pesanan.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </section>
    </main>

    <script>
        function editMenu(id, nama, harga, kategori, deskripsi, foto) {
    const section = document.getElementById('edit-menu');
    const form = document.getElementById('edit-menu-form');

    form.action = "<?php echo e(url('/admin/menu')); ?>/" + id;

    document.getElementById('edit_nama_menu').value = nama;
    document.getElementById('edit_harga').value = harga;
    document.getElementById('edit_kategori').value = kategori;
    document.getElementById('edit_deskripsi').value = deskripsi;
    document.getElementById('edit_foto').value = foto;

    section.hidden = false;
    section.scrollIntoView({ behavior: 'smooth' });
}

        function cancelEdit() {
            document.getElementById('edit-menu').hidden = true;
        }
    </script>
</body>
</html>
<?php /**PATH C:\Users\Akhdan Luthfi B\Documents\bi-kantin-web\resources\views/admin/dashboard.blade.php ENDPATH**/ ?>