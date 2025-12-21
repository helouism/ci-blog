<?= $this->extend("admin/layout/app") ?>
<?= $this->section("adminContent") ?>
<form action="<?= url_to("admin_profile_update_email") ?>" method="POST" accept-charset="utf-8">
    <?= csrf_field() ?>

    <div class="mb-3">
        <label for="email" class="form-label">New Email</label>
        <input type="email" class="form-control" id="email" name="email" value="<?= old('email') ?>" maxlength="255"
            required>
    </div>

    <div class="mb-3">
        <label for="password" class="form-label">Confirm Password</label>
        <input type="password" class="form-control" id="password" name="password" required>
    </div>

    <button type="submit" class="btn btn-primary">Send Verification Link</button>
</form>
<?= $this->endSection() ?>