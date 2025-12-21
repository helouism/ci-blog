<?= $this->extend("admin/layout/app") ?>
<?= $this->section('adminContent') ?>

<h4 class="mb-4">Change Password</h4>


<form action="<?= url_to('admin_profile_update_password') ?>" method="POST" novalidate>
    <?= csrf_field() ?>

    <div class="mb-3">
        <label for="current_password" class="form-label">Current Password</label>
        <input type="password" class="form-control" id="current_password" name="current_password" required>
    </div>

    <div class="mb-3">
        <label for="password" class="form-label">New Password</label>
        <input type="password" class="form-control" id="password" name="password" minlength="8" required>
        <small class="text-muted">
            Minimum 8 characters. Use a strong password.
        </small>
    </div>

    <div class="mb-3">
        <label for="password_confirm" class="form-label">Confirm New Password</label>
        <input type="password" class="form-control" id="password_confirm" name="password_confirm" required>
    </div>

    <button type="submit" class="btn btn-danger">
        Change Password
    </button>
</form>

<?= $this->endSection() ?>