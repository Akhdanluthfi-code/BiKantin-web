
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Siswa | BI-KANTIN</title>

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

        .welcome { color: #64748b; }

        .menu-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 18px;
        }

        .menu-card {
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 18px;
        }

        .menu-photo {
    width: 100%;
    height: 160px;
    object-fit: cover;
    border-radius: 8px;
    margin-bottom: 12px;
    display: block;
}

.menu-description {
    color: #64748b;
    font-size: 14px;
    line-height: 1.6;
    margin-bottom: 16px;
}

        .category {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 20px;
            background: #ccfbf1;
            color: #115e59;
            font-size: 12px;
            font-weight: bold;
        }

        .price {
            font-size: 20px;
            font-weight: bold;
            color: #0f766e;
        }

        label {
            display: block;
            margin: 14px 0 7px;
            font-weight: bold;
            font-size: 14px;
        }

        input {
            width: 100%;
            padding: 11px;
            border: 1px solid #cbd5e1;
            border-radius: 7px;
        }

        button, .button {
            display: inline-block;
            border: none;
            border-radius: 7px;
            padding: 11px 14px;
            cursor: pointer;
            font-weight: bold;
            text-decoration: none;
        }

        .primary {
            background: #0f766e;
            color: white;
        }

        .primary:hover { background: #115e59; }

        .history-link {
            display: inline-block;
            margin-bottom: 16px;
            color: #0f766e;
            font-weight: bold;
        }

        .table-wrapper { overflow-x: auto; }

        table {
            width: 100%;
            min-width: 600px;
            border-collapse: collapse;
        }

        th, td {
            padding: 13px;
            text-align: left;
            border-bottom: 1px solid #e2e8f0;
        }

        th { background: #f8fafc; }

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

        .muted { color: #64748b; }

        @media (max-width: 600px) {
            header h1 { font-size: 20px; }
            .section { padding: 16px; }
        }
    </style>
</head>

<body>
    <header>
        <div>
            <h1>BI-KANTIN</h1>
            <div>Dashboard Siswa</div>
        </div>

        <form class="logout" action="<?php echo e(route('logout')); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <button type="submit">Logout</button>
        </form>
    </header>

    <main>
        <section class="section">
            <h2>Halo, <?php echo e(session('username')); ?>!</h2>
            <p class="welcome">
                Selamat datang di BI-KANTIN. Pilih menu yang ingin kamu pesan.
            </p>
            <a class="history-link" href="<?php echo e(route('siswa.riwayat')); ?>">
                Lihat riwayat pesanan →
            </a>
        </section>

        <?php if(session('success')): ?>
            <div class="message"><?php echo e(session('success')); ?></div>
        <?php endif; ?>

        <?php if(session('error')): ?>
            <div class="message error"><?php echo e(session('error')); ?></div>
        <?php endif; ?>

        <?php if($errors->any()): ?>
            <div class="message error">
                <strong>Periksa kembali pesanan kamu:</strong>
                <ul>
                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li><?php echo e($error); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>
        <?php endif; ?>

        <section class="section">
            <h2>Katalog Menu</h2>

            <div class="menu-grid">
                <?php $__empty_1 = true; $__currentLoopData = $menus; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $menu): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <article class="menu-card">
    <?php if($menu->foto): ?>
        <img
            class="menu-photo"
            src="<?php echo e($menu->foto); ?>"
            alt="<?php echo e($menu->nama_menu); ?>"
            loading="lazy"
        >
    <?php else: ?>
        <div class="menu-photo" style="display: flex; align-items: center; justify-content: center; background: #e2e8f0; color: #64748b;">
            Foto belum tersedia
        </div>
    <?php endif; ?>

    <span class="category"><?php echo e($menu->kategori); ?></span>

    <h3><?php echo e($menu->nama_menu); ?></h3>

    <p class="menu-description">
        <?php echo e($menu->deskripsi ?: 'Belum ada deskripsi untuk menu ini.'); ?>

    </p>

                        <p class="price">
                            Rp <?php echo e(number_format($menu->harga, 0, ',', '.')); ?>

                        </p>

                        <form action="<?php echo e(route('siswa.pesanan.store')); ?>" method="POST">
    <?php echo csrf_field(); ?>

    <input type="hidden" name="menu_id" value="<?php echo e($menu->id); ?>">

    <label for="jumlah-<?php echo e($menu->id); ?>">Jumlah</label>
    <input
        id="jumlah-<?php echo e($menu->id); ?>"
        type="number"
        name="jumlah"
        min="1"
        max="100"
        value="1"
        required
    >

    <button type="submit">Pesan Sekarang</button>
</form>
                    </article>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <p>Belum ada menu yang tersedia.</p>
                <?php endif; ?>
            </div>
        </section>

        <section class="section">
            <h2>Status Pesanan Terbaru</h2>

            <div class="table-wrapper">
                <table>
                    <thead>
    <tr>
        <th>Menu</th>
        <th>Jumlah</th>
        <th>Total</th>
        <th>Status Pesanan</th>
        <th>Status Pembayaran</th>
    </tr>
</thead>

                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $pesanans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pesanan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td><?php echo e($pesanan->menu->nama_menu ?? 'Menu tidak tersedia'); ?></td>
                                <td><?php echo e($pesanan->jumlah); ?></td>
                                <td>
                                    Rp <?php echo e(number_format($pesanan->total_harga, 0, ',', '.')); ?>

                                </td>
                                <td><?php echo e($pesanan->status); ?></td>
<td><?php echo e($pesanan->status_pembayaran ?? 'Belum Dibayar'); ?></td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="5">
                                    Kamu belum memiliki pesanan.
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </section>
    </main>
</body>
</html>
<?php /**PATH C:\Users\Akhdan Luthfi B\Documents\bi-kantin-web\resources\views/siswa/dashboard.blade.php ENDPATH**/ ?>