
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Kasir | BI-KANTIN</title>

    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: Arial, sans-serif;
            background: #f4f6f9;
            color: #263238;
        }

        header {
            background: #166534;
            color: white;
            padding: 22px 6%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 15px;
            flex-wrap: wrap;
        }

        header h1 {
            font-size: 24px;
        }

        header p {
            margin-top: 5px;
            color: #dcfce7;
        }

        .logout-form button {
            padding: 10px 16px;
            background: white;
            color: #166534;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-weight: bold;
        }

        main {
            max-width: 1200px;
            margin: 30px auto;
            padding: 0 20px;
        }

        .panel {
            background: white;
            padding: 24px;
            border-radius: 12px;
            box-shadow: 0 3px 12px rgba(0, 0, 0, 0.05);
            margin-bottom: 24px;
        }

        .panel h2 {
            margin-bottom: 10px;
        }

        .description {
            color: #64748b;
            margin-bottom: 20px;
            line-height: 1.6;
        }

        .alert {
            padding: 12px 16px;
            border-radius: 7px;
            margin-bottom: 18px;
        }

        .success {
            background: #dcfce7;
            color: #166534;
        }

        .error {
            background: #fee2e2;
            color: #991b1b;
        }

        .table-wrapper {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 850px;
        }

        th, td {
            padding: 14px 12px;
            text-align: left;
            border-bottom: 1px solid #e5e7eb;
            vertical-align: middle;
        }

        th {
            background: #f8fafc;
            color: #475569;
            font-size: 13px;
        }

        td {
            font-size: 14px;
        }

        .status {
            display: inline-block;
            padding: 6px 10px;
            border-radius: 20px;
            background: #fef3c7;
            color: #92400e;
            font-size: 12px;
            font-weight: bold;
        }

        .paid {
            background: #dcfce7;
            color: #166534;
        }

        .confirm-button {
            border: none;
            background: #166534;
            color: white;
            padding: 9px 12px;
            border-radius: 6px;
            cursor: pointer;
        }

        .confirm-button:hover {
            background: #14532d;
        }

        .empty {
            text-align: center;
            padding: 28px;
            color: #64748b;
        }

        footer {
            text-align: center;
            padding: 24px;
            color: #64748b;
            font-size: 13px;
        }

        @media (max-width: 600px) {
            header {
                padding: 20px;
            }

            header h1 {
                font-size: 21px;
            }

            main {
                padding: 0 12px;
                margin-top: 18px;
            }

            .panel {
                padding: 16px;
            }
        }
    </style>
</head>

<body>
    <header>
        <div>
            <h1>BI-KANTIN</h1>
            <p>Dashboard Kasir</p>
        </div>

        <form action="<?php echo e(route('logout')); ?>" method="POST" class="logout-form">
            <?php echo csrf_field(); ?>
            <button type="submit">Logout</button>
        </form>
    </header>

    <main>
        <section class="panel">
            <h2>Daftar Pembayaran</h2>
            <p class="description">
                Periksa pesanan siswa dan konfirmasikan pembayaran
                setelah pembayaran benar-benar diterima.
            </p>

            <?php if(session('success')): ?>
                <div class="alert success">
                    <?php echo e(session('success')); ?>

                </div>
            <?php endif; ?>

            <?php if(session('error')): ?>
                <div class="alert error">
                    <?php echo e(session('error')); ?>

                </div>
            <?php endif; ?>

            <?php if($errors->any()): ?>
                <div class="alert error">
                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div><?php echo e($error); ?></div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            <?php endif; ?>

            <div class="table-wrapper">
                <table>
                    <thead>
                        <tr>
                            <th>ID Pesanan</th>
                            <th>Nama Siswa</th>
                            <th>Menu</th>
                            <th>Jumlah</th>
                            <th>Total Harga</th>
                            <th>Status Pesanan</th>
                            <th>Pembayaran</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $pesanans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pesanan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td>#<?php echo e($pesanan->id); ?></td>

                                <td>
                                    <?php echo e($pesanan->user?->username ?? 'Pengguna tidak ditemukan'); ?>

                                </td>

                                <td>
                                    <?php echo e($pesanan->menu?->nama_menu ?? 'Menu tidak ditemukan'); ?>

                                </td>

                                <td><?php echo e($pesanan->jumlah); ?></td>

                                <td>
                                    Rp<?php echo e(number_format($pesanan->total_harga, 0, ',', '.')); ?>

                                </td>

                                <td><?php echo e($pesanan->status); ?></td>

                                <td>
                                    <?php if(($pesanan->status_pembayaran ?? 'Belum Dibayar') === 'Lunas'): ?>
    <span class="status paid">Lunas</span>
<?php else: ?>
    <span class="status">Belum Dibayar</span>
<?php endif; ?>
                                </td>

                                <td>
                                    <?php if($pesanan->status_pembayaran !== 'Lunas'): ?>
                                        <form
                                            action="<?php echo e(route('kasir.pembayaran.konfirmasi', $pesanan->id)); ?>"
                                            method="POST"
                                            onsubmit="return confirm('Konfirmasi bahwa pembayaran pesanan ini sudah diterima?')"
                                        >
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('PATCH'); ?>

                                            <button type="submit" class="confirm-button">
                                                Konfirmasi
                                            </button>
                                        </form>
                                    <?php else: ?>
                                        <span style="color: #166534; font-weight: bold;">
                                            Sudah dikonfirmasi
                                        </span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="8" class="empty">
                                    Belum ada pesanan yang masuk.
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </section>
    </main>

    <footer>
        &copy; <?php echo e(date('Y')); ?> BI-KANTIN — Sistem Informasi Kantin Sekolah
    </footer>
</body>
</html>
<?php /**PATH C:\Users\Akhdan Luthfi B\Documents\bi-kantin-web\resources\views/kasir/dashboard.blade.php ENDPATH**/ ?>