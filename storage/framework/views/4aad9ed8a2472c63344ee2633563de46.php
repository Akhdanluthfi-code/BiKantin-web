
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | BI-KANTIN</title>
    <style>
        * { box-sizing: border-box; }
        body {
            margin: 0;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
            font-family: Arial, sans-serif;
            background: #f1f5f9;
            color: #1e293b;
        }
        .container {
            width: 100%;
            max-width: 400px;
            padding: 32px;
            background: white;
            border-radius: 16px;
            box-shadow: 0 10px 35px rgba(15, 23, 42, .08);
        }
        h1 { margin: 0 0 8px; color: #0f766e; }
        .subtitle { margin: 0 0 24px; color: #64748b; }
        label { display: block; margin: 16px 0 7px; font-weight: bold; }
        input {
            width: 100%;
            padding: 12px;
            border: 1px solid #cbd5e1;
            border-radius: 8px;
            font-size: 15px;
        }
        button {
            width: 100%;
            margin-top: 24px;
            padding: 12px;
            border: 0;
            border-radius: 8px;
            background: #0f766e;
            color: white;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
        }
        button:hover { background: #115e59; }
        .message { margin: 12px 0; color: #b91c1c; font-size: 14px; }
        .footer { margin-top: 20px; text-align: center; font-size: 14px; }
        a { color: #0f766e; }
    </style>
</head>
<body>
    <main class="container">
        <h1>BI-KANTIN</h1>
        <p class="subtitle">Silakan masuk ke akun kamu.</p>

        <?php if(session('error')): ?>
            <p class="message"><?php echo e(session('error')); ?></p>
        <?php endif; ?>

        <?php if($errors->any()): ?>
            <div class="message">
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <p><?php echo e($error); ?></p>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        <?php endif; ?>

        <form action="<?php echo e(route('login.process')); ?>" method="POST">
            <?php echo csrf_field(); ?>

            <label for="username">Username</label>
            <input
                type="text"
                id="username"
                name="username"
                value="<?php echo e(old('username')); ?>"
                required
                autocomplete="username"
            >

            <label for="password">Password</label>
            <input
                type="password"
                id="password"
                name="password"
                required
                autocomplete="current-password"
            >

            <button type="submit">Login</button>
        </form>

        <div class="footer">
            Belum punya akun?
            <a href="<?php echo e(route('register')); ?>">Daftar di sini</a>
        </div>
    </main>
</body>
</html>
<?php /**PATH C:\Users\Akhdan Luthfi B\Documents\bi-kantin-web\resources\views/login.blade.php ENDPATH**/ ?>