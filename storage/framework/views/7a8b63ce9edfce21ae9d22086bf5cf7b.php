<?php echo $__env->make('emails._header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<p style="color:#374151;font-size:15px;margin:0 0 12px;">Dear <?php echo e($user->first_name); ?> <?php echo e($user->last_name); ?>,</p>
<p style="color:#4a4a4a;font-size:14px;line-height:1.7;margin:0 0 16px;">
    Your FlowDesk account has been created. Use the details below to sign in for the first time.
</p>
<table width="100%" cellpadding="0" cellspacing="0" style="border-collapse:collapse;margin:16px 0;">
    <tr>
        <th style="background:#e9f2ff;padding:8px 12px;text-align:left;font-size:13px;color:#004085;">Field</th>
        <th style="background:#e9f2ff;padding:8px 12px;text-align:left;font-size:13px;color:#004085;">Details</th>
    </tr>
    <tr><td style="padding:10px 12px;border-bottom:1px solid #f0f0f0;font-size:14px;color:#374151;">Login URL</td><td style="padding:10px 12px;border-bottom:1px solid #f0f0f0;font-size:14px;"><a href="<?php echo e($loginUrl); ?>" style="color:#004085;"><?php echo e($loginUrl); ?></a></td></tr>
    <tr><td style="padding:10px 12px;border-bottom:1px solid #f0f0f0;font-size:14px;color:#374151;">Email</td><td style="padding:10px 12px;border-bottom:1px solid #f0f0f0;font-size:14px;color:#374151;"><?php echo e($user->email); ?></td></tr>
    <tr><td style="padding:10px 12px;font-size:14px;color:#374151;">Temporary Password</td><td style="padding:10px 12px;font-size:14px;"><strong><?php echo e($password); ?></strong></td></tr>
</table>
<div style="background:#fff8e1;border-left:4px solid #c8a951;border-radius:4px;padding:12px 16px;margin:20px 0;">
    <p style="color:#78620a;font-size:13px;margin:0;"><strong>Important:</strong> You will be required to set a new password when you first sign in. Do not share this temporary password.</p>
</div>
<p style="text-align:center;margin:20px 0;">
    <a href="<?php echo e($loginUrl); ?>" style="display:inline-block;background:#1a3a6b;color:#fff;padding:12px 28px;border-radius:6px;text-decoration:none;font-weight:600;font-size:14px;">Sign In to FlowDesk</a>
</p>
<p style="font-size:13px;color:#9ca3af;margin:0;">If you did not expect this email, please contact your system administrator immediately.</p>
<?php echo $__env->make('emails._footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php /**PATH D:\Myprojects\FlowDesk\resources\views/emails/welcome-staff.blade.php ENDPATH**/ ?>