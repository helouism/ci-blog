<?= $this->section("adminStyles") ?>
<link href="https://cdn.jsdelivr.net/npm/@yaireo/tagify/dist/tagify.css" rel="stylesheet" type="text/css" />

<?= $this->endSection() ?><?= $this->extend("admin/layout/app") ?>
<?= $this->section("adminContent") ?>

<?php if (isset($validation)): ?>
    <div class="alert alert-danger">
        <?= $validation->listErrors() ?>
    </div>
<?php endif; ?>

<form action="<?= url_to("admin_posts_store") ?>" accept-charset="utf-8" method="post">
    <?= csrf_field() ?>
    <div class="mb-3">
        <label for="title" class="form-label">Title</label>
        <input type="text" class="form-control" id="title" name="title" value="<?= set_value('title') ?>" required>
    </div>
    <div class="mb-3">
        <label for="slug" class="form-label">Slug</label>
        <input type="text" class="form-control" id="slug" name="slug" value="<?= set_value('slug') ?>" required>
    </div>
    <div class="mb-3">
        <label for="meta_description" class="form-label">Meta Description</label>
        <input type="text" class="form-control" id="meta_description" name="meta_description"
            value="<?= set_value('meta_description') ?>" required>
    </div>
    <div class="mb-3">
        <label for="content" class="form-label">Content</label>
        <textarea class="form-control" id="content" name="content" required><?= set_value('content') ?></textarea>
    </div>
    <div class="mb-3">
        <label for="tags" class="form-label">Tags</label>
        <input type="text" class="form-control" id="tags" name="tags" value="<?= set_value('tags') ?>"
            placeholder="Separate tags with commas">
    </div>

    <div class="mb-3">
        <label class="form-label">Featured Image (Thumbnail)</label>

        <input type="file" class="filepond" name="featured_image" accept="image/png,image/jpeg,image/jpg,image/webp" />

        <input type="hidden" name="featured_image_token" id="featured_image_token" value="">
        <small class="text-muted d-block mt-1">
            This image will show as thumbnail on homepage and full size in the post.
        </small>
    </div>

    <button type="submit" class="btn btn-primary">Create Post</button>
</form>

<?= $this->endSection() ?>
<?= $this->section("adminScripts") ?>

<link href="https://unpkg.com/filepond/dist/filepond.min.css" rel="stylesheet" />

<link href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css" rel="stylesheet" />

<script src="https://unpkg.com/filepond/dist/filepond.min.js"></script>
<script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@yaireo/tagify"></script>
<script src="https://cdn.jsdelivr.net/npm/@yaireo/tagify/dist/tagify.polyfills.min.js"></script>
<script>
    $(document).ready(function () {
        $('#content').summernote();

        const csrfName = "<?= csrf_token() ?>";
        let csrfHash = "<?= csrf_hash() ?>";

        // Initialize Tagify
        const tagsInput = document.getElementById('tags');
        const tagify = new Tagify(tagsInput, {
            delimiters: ",",
            maxTags: 50,
            placeholder: "Add tags separated by commas",
            dropdown: {
                maxItems: 20,
                classname: 'tagify__dropdown',
                enabled: 0,
                closeOnSelect: false
            },
            enforceWhitelist: false,
            keepInvalidTags: false,
            transformTag: function (tagData) {
                tagData.value = tagData.value.trim();
            }
        });

        // Convert tags back to comma-separated string before form submission
        $('form').on('submit', function () {
            const tags = tagify.value.map(t => t.value).join(',');
            tagsInput.value = tags;
        });

        FilePond.registerPlugin(FilePondPluginImagePreview);

        const input = document.querySelector('input.filepond');

        const pond = FilePond.create(input, {
            credits: false,
            allowMultiple: false,
            instantUpload: true,

            server: {
                process: {
                    url: "<?= url_to('admin_posts_image_process') ?>",
                    method: "POST",

                    // IMPORTANT: put CSRF in the POST body (CI4 expects it there)
                    ondata: (formData) => {
                        formData.append(csrfName, csrfHash);
                        return formData;
                    },

                    onload: (serverId) => {
                        document.getElementById('featured_image_token').value = serverId;
                        return serverId;
                    }
                },

                // IMPORTANT: revert needs CSRF too, so implement custom revert using POST form data
                revert: (uniqueFileId, load, error) => {
                    $.ajax({
                        url: "<?= url_to('admin_posts_image_revert') ?>",
                        method: "POST",
                        data: {
                            [csrfName]: csrfHash,
                            token: uniqueFileId
                        },
                        success: function () {
                            document.getElementById('featured_image_token').value = '';
                            load();
                        },
                        error: function () {
                            error('Failed to revert');
                        }
                    });
                }
            }
        });

    });
</script>

<?= $this->endSection() ?>