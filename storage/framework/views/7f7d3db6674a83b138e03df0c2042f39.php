<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Pesanan | BI-KANTIN</title>

    <style>
        * {
            box-sizing: border-box;
        }

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

        header h1 {
            margin: 0;
            font-size: 24px;
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

        .back-link {
            color: #0f766e;
            font-weight: bold;
            text-decoration: none;
        }

        .table-wrapper {
            overflow-x: auto;
        }

        table {
            width: 100%;
            min-width: 750px;
            border-collapse: collapse;
        }

        th, td {
            padding: 13px;
            text-align: left;
            border-bottom: 1px solid #e2e8f0;
        }

        th {
            background: #f8fafc;
        }

        .empty {
            text-align: center;
            color: #64748b;
            padding: 24px;
        }

        @media (max-width: 600px) {
            header h1 {
                font-size: 20px;
            }

            .section {
                padding: 16px;
            }
        }
    </style>
</head>

<body>
    <header>
        <div>
            <h1>BI-KANTIN</h1>
            <div>Riwayat Pesanan Siswa</div>
        </div>
    </header>

    <main>
        <section class="section">
            <h2>Riwayat Pesanan</h2>

            <p>
                Berikut daftar pesanan yang pernah kamu buat.
            </p>

            <a class="back-link"
               href="<?php echo e(route('siswa.dashboard')); ?>">
                ← Kembali ke Dashboard
            </a>
        </section>

        <section class="section">
            <div class="table-wrapper">
                <table>
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Menu</th>
                            <th>Jumlah</th>
                            <th>Total Harga</th>
                            <th>Status Pesanan</th>
                            <th>Status Pembayaran</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $pesanans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pesanan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td><?php echo e($loop->iteration); ?></td>

                                <td>
                                    <?php echo e($pesanan->menu->nama_menu ?? 'Menu tidak tersedia'); ?>

                                </td>

                                <td><?php echo e($pesanan->jumlah); ?></td>

                                <td>
                                    Rp <?php echo e(number_format($pesanan->total_harga, 0, ',', '.')); ?>

                                </td>

                                <td><?php echo e($pesanan->status); ?></td>

                                <td>
                                    <?php echo e($pesanan->status_pembayaran ?? 'Belum Dibayar'); ?>

                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="6" class="empty">
                                    Kamu belum memiliki riwayat pesanan.
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
<?php /**PATH C:\Users\Akhdan Luthfi B\Documents\bi-kantin-web\resources\views/siswa/riwayat.blade.php ENDPATH**/ ?>