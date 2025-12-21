<?= $this->extend("admin/layout/app") ?>
<?= $this->section('adminContent') ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-0">Edit Page</h4>
        <small class="text-muted">Editing: <code>/page/<?= esc($page['slug']) ?></code></small>
    </div>
    <a href="<?= url_to('admin_pages_index') ?>" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left"></i> Back
    </a>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        <?php if (isset($validation) && $validation->getErrors()): ?>
            <div class="alert alert-danger">
                <ul class="mb-0">
                    <?php foreach ($validation->getErrors() as $e): ?>
                        <li><?= esc($e) ?></li>
                    <?php endforeach ?>
                </ul>
            </div>
        <?php endif; ?>

        <form action="<?= url_to('admin_pages_update', $page['id']) ?>" method="post">
            <?= csrf_field() ?>

            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Title</label>
                    <input type="text" name="title" class="form-control" value="<?= old('title', $page['title']) ?>"
                        required maxlength="255">
                </div>

                <div class="col-md-6">
                    <label class="form-label">Slug</label>
                    <input type="text" name="slug" class="form-control" value="<?= old('slug', $page['slug']) ?>"
                        required maxlength="255">
                </div>

                <div class="col-12">
                    <label class="form-label">Meta Description</label>
                    <input type="text" name="meta_description" class="form-control"
                        value="<?= old('meta_description', $page['meta_description'] ?? '') ?>" maxlength="255">
                </div>

                <div class="col-md-3">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select" required>
                        <?php $status = old('status', $page['status'] ?? 'published'); ?>
                        <option value="published" <?= $status === 'published' ? 'selected' : '' ?>>Published</option>
                        <option value="draft" <?= $status === 'draft' ? 'selected' : '' ?>>Draft</option>
                    </select>
                </div>

                <div class="col-12">
                    <label class="form-label">Content</label>
                    <textarea id="content" name="content" class="form-control" rows="10"
                        required><?= old('content', $page['content']) ?></textarea>
                </div>
            </div>

            <div class="mt-4 d-flex justify-content-end gap-2">
                <a class="btn btn-outline-secondary" href="<?= base_url('page/' . $page['slug']) ?>" target="_blank"
                    rel="noopener">
                    <i class="bi bi-box-arrow-up-right"></i> Preview
                </a>

                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save"></i> Update
                </button>
            </div>
        </form>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('adminScripts') ?>
<script>
    $(function () {
        $('#content').summernote({
            height: 300
        });
    });
</script>
<?= $this->endSection() ?>