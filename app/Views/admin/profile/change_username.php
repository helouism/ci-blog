<?= $this->extend("admin/layout/app") ?>
<?= $this->section("adminContent") ?>
<form action="<?= url_to("admin_profile_update_username") ?>" method="POST" accept-charset="utf-8">
    <?= csrf_field() ?>
    <div class="mb-3">
        <label for="username" class="form-label">New Username</label>
        <input type="text" class="form-control" id="username" name="username"
            value="<?= old('username', esc($user->username)) ?>" maxlength="30" required>

    </div>
    <button type="submit" class="btn btn-primary">Update Username</button>
</form>
<?= $this->endSection() ?>