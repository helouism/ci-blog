<?= $this->extend("admin/layout/app") ?>
<?= $this->section('adminContent') ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-0">Pages</h4>
        <small class="text-muted">Create/edit custom pages like About, Privacy Policy, Terms, etc.</small>
    </div>
    <a href="<?= url_to('admin_pages_create') ?>" class="btn btn-primary">
        <i class="bi bi-plus-lg"></i> New Page
    </a>
</div>

<div class="card shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0 align-middle">
                <thead class="table-light">
                    <tr>
                        <th style="width: 60px;">#</th>
                        <th>Title</th>
                        <th>Slug</th>
                        <th style="width: 120px;">Status</th>
                        <th style="width: 180px;">Updated</th>
                        <th style="width: 160px;" class="text-end">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($pages)): ?>
                        <tr>
                            <td colspan="6" class="text-center text-muted p-4">
                                No pages yet.
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($pages as $i => $page): ?>
                            <tr>
                                <td><?= $i + 1 ?></td>
                                <td class="fw-semibold"><?= esc($page['title']) ?></td>
                                <td>
                                    <code>/page/<?= esc($page['slug']) ?></code>
                                </td>
                                <td>
                                    <?php if (($page['status'] ?? 'published') === 'published'): ?>
                                        <span class="badge bg-success">Published</span>
                                    <?php else: ?>
                                        <span class="badge bg-secondary">Draft</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-muted small">
                                    <?= esc($page['updated_at'] ?? $page['created_at'] ?? '-') ?>
                                </td>
                                <td class="text-end">
                                    <a href="<?= url_to('admin_pages_edit', $page['id']) ?>"
                                        class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-pencil"></i> Edit
                                    </a>

                                    <form action="<?= url_to('admin_pages_delete', $page['id']) ?>" method="post"
                                        class="d-inline" onsubmit="return confirm('Delete this page?');">
                                        <?= csrf_field() ?>
                                        <button type="submit" class="btn btn-sm btn-outline-danger">
                                            <i class="bi bi-trash"></i> Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection() ?>