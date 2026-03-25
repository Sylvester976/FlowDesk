<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo e(config('app.name', 'FlowDesk')); ?> &mdash; <?php echo $__env->yieldContent('title', 'Sign In'); ?></title>

    <link href="<?php echo e(asset('assets/img/cos.ico')); ?>" rel="icon">
    <link href="<?php echo e(asset('assets/img/apple-touch-icon.png')); ?>" rel="apple-touch-icon">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap"
          rel="stylesheet">

    <link href="<?php echo e(asset('assets/vendor/bootstrap/css/bootstrap.min.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('assets/vendor/bootstrap-icons/bootstrap-icons.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('assets/css/main.css')); ?>" rel="stylesheet">
    <style>
        .notie-container {
            width: 320px !important;
            right: 20px !important;
            left: auto !important;
            top: 20px !important;
            border-radius: 8px !important;
            box-shadow: 0 4px 20px rgba(0, 0, 0, .15) !important;
            font-size: .88rem !important;
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/notie/4.3.1/notie.min.css">

    <style>
        :root {
            --ke-navy: #1a3a6b;
            --ke-navy-dark: #122850;
            --ke-green: #006b3f;
            --ke-red: #bb0000;
            --ke-gold: #c8a951;
        }

        body {
            background: #f1f3f7;
        }

        .auth-brand {
            background: var(--ke-navy-dark);
            background-image: radial-gradient(ellipse at 20% 80%, rgba(0, 107, 63, 0.35) 0%, transparent 55%),
            radial-gradient(ellipse at 80% 10%, rgba(26, 58, 107, 0.6) 0%, transparent 50%);
            position: relative;
            overflow: hidden;
        }

        .auth-brand::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 5px;
            background: linear-gradient(to right,
            var(--ke-red) 0 33.3%,
            #1a1a1a 33.3% 66.6%,
            var(--ke-green) 66.6% 100%);
        }

        .auth-brand-logo span {
            color: #fff;
            font-weight: 700;
            font-size: 1.15rem;
        }

        .auth-brand-heading {
            color: #fff;
            font-weight: 700;
            font-size: 1.6rem;
            line-height: 1.3;
        }

        .auth-brand-desc {
            color: rgba(255, 255, 255, .7);
            font-size: .93rem;
        }

        .auth-brand-features li {
            color: rgba(255, 255, 255, .85);
            font-size: .9rem;
        }

        .auth-brand-features li i {
            color: var(--ke-gold);
        }

        .auth-brand-footer {
            color: rgba(255, 255, 255, .35);
            font-size: .75rem;
        }

        /* Card */
        .auth-card {
            border: none;
            border-radius: 14px;
            box-shadow: 0 4px 40px rgba(0, 0, 0, .10);
            overflow: hidden;
        }

        .auth-card-top-stripe {
            height: 4px;
            background: linear-gradient(to right,
            var(--ke-red) 0 33.3%,
            var(--ke-navy) 33.3% 66.6%,
            var(--ke-green) 66.6% 100%);
        }

        .auth-card-header {
            padding: 28px 32px 0;
        }

        .auth-title {
            color: var(--ke-navy);
            font-weight: 700;
            font-size: 1.4rem;
        }

        .auth-subtitle {
            color: #6c757d;
            font-size: .88rem;
            margin-top: 4px;
        }

        /* Form area padding */
        .auth-form {
            padding: 24px 32px 32px;
        }

        .auth-form .form-group {
            margin-bottom: 18px;
        }

        .auth-form .form-label {
            font-weight: 500;
            font-size: .88rem;
            color: #374151;
            margin-bottom: 6px;
        }

        .auth-form .form-control {
            border-radius: 8px;
            border: 1.5px solid #d1d5db;
            padding: 10px 14px;
            font-size: .93rem;
            transition: border-color .2s, box-shadow .2s;
        }

        .auth-form .form-control:focus {
            border-color: var(--ke-navy);
            box-shadow: 0 0 0 3px rgba(26, 58, 107, .12);
        }

        .auth-form .btn-primary,
        .auth-form .btn-block {
            background: var(--ke-navy);
            border-color: var(--ke-navy);
            font-weight: 600;
            padding: 11px;
            border-radius: 8px;
            font-size: .95rem;
            letter-spacing: .01em;
            transition: background .2s, transform .1s, box-shadow .2s;
            width: 100%;
            margin-top: 4px;
        }

        .auth-form .btn-primary:hover {
            background: var(--ke-navy-dark);
            border-color: var(--ke-navy-dark);
            transform: translateY(-1px);
            box-shadow: 0 4px 14px rgba(26, 58, 107, .3);
        }

        .auth-form .btn-primary:active {
            transform: translateY(0);
        }

        .auth-link {
            color: var(--ke-green) !important;
            font-weight: 500;
        }

        .auth-link:hover {
            color: var(--ke-navy) !important;
            text-decoration: underline !important;
        }

        .auth-footer-text {
            padding: 16px 32px 28px;
            text-align: center;
            font-size: .83rem;
            color: #6c757d;
            margin: 0;
            border-top: 1px solid #f0f0f0;
        }

        .auth-footer {
            margin-top: auto;
            padding: 16px;
        }

        .auth-footer-links {
            display: flex;
            gap: 16px;
            justify-content: center;
        }

        .auth-footer-links a {
            font-size: .78rem;
            color: #9ca3af;
            text-decoration: none;
        }

        .auth-footer-links a:hover {
            color: var(--ke-navy);
        }
    </style>

    <?php echo \Livewire\Mechanisms\FrontendAssets\FrontendAssets::styles(); ?>

</head>
<body>

<div class="auth-layout">

    
    <div class="auth-brand">
        <div class="auth-brand-inner">

            <a href="<?php echo e(route('login')); ?>" class="d-block mb-4">
                <img src="<?php echo e(asset('assets/img/logo.png')); ?>" alt="FlowDesk" style="max-width:500px; height:auto;">
            </a>

            <div class="auth-brand-content">
                <h2 class="auth-brand-heading">Travel Information Management System</h2>
                <p class="auth-brand-desc">
                    Manage, track, and streamline official and private travel across your organisation with full
                    accountability.
                </p>
                <ul class="auth-brand-features">
                    <li><i class="bi bi-check-circle-fill"></i> Foreign &amp; local travel clearance</li>
                    <li><i class="bi bi-check-circle-fill"></i> Supervisor concurrence workflow</li>
                    <li><i class="bi bi-check-circle-fill"></i> Full audit trail on every action</li>
                    <li><i class="bi bi-check-circle-fill"></i> Days docket tracking per staff</li>
                </ul>
            </div>

            <div class="auth-brand-footer">
                &copy; <?php echo e(date('Y')); ?> State Department For ICT and Digital Economy. All rights reserved.
            </div>

        </div>
    </div>

    
    <div class="auth-main">
        <div class="auth-container">
            <div class="auth-card">
                <div class="auth-card-top-stripe"></div>
                <?php echo e($slot); ?>

            </div>
        </div>
        <footer class="auth-footer">
            <div class="auth-footer-links">
                <a href="#">Privacy Policy</a>
                <a href="#">Terms of Service</a>
                <a href="#">Help</a>
            </div>
        </footer>
    </div>

</div>

<script src="<?php echo e(asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js')); ?>"></script>
<script src="<?php echo e(asset('assets/js/theme.js')); ?>"></script>
<script src="<?php echo e(asset('assets/js/main.js')); ?>"></script>
<?php echo \Livewire\Mechanisms\FrontendAssets\FrontendAssets::scripts(); ?>

<script src="<?php echo e(asset('assets/vendor/notie/notie.min.js')); ?>"></script>
<script>
    window.addEventListener('notify', e => {
        const map = {success: 1, warning: 2, error: 3, info: 4};
        notie.alert({type: map[e.detail.type] ?? 4, text: e.detail.message, stay: false, time: 4});
    });
    <?php if(session('notify_type')): ?>
    document.addEventListener('DOMContentLoaded', () => {
        const map = {success: 1, warning: 2, error: 3, info: 4};
        notie.alert({
            type: map['<?php echo e(session('notify_type')); ?>'] ?? 4,
            text: '<?php echo e(session('notify_message')); ?>',
            stay: false,
            time: 4
        });
    });
    <?php endif; ?>
</script>
</body>
</html>
<?php /**PATH D:\Myprojects\FlowDesk\resources\views/components/layouts/auth.blade.php ENDPATH**/ ?>