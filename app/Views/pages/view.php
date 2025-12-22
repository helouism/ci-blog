<?= $this->extend('layout/app') ?>
<?= $this->section('structuredData') ?>
<script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "WebPage",
        "name": "<?= esc($page['title']) ?>",
        "description": "<?= esc($page['meta_description']) ?>",
        "url": "<?= current_url() ?>"
    }   
</script>
<?= $this->endSection() ?>
<?= $this->section('pageStyles') ?>
<?= $this->endSection() ?>

<?= $this->section('pageContent') ?>
<header class="py-4">
    <div class="container-lg">
        <h1 class="h2"><?= esc($page['title']) ?></h1>
        <?php if (!empty($page['meta_description'])): ?>
            <p class="mb-0 mt-2 text-muted"><?= esc($page['meta_description']) ?></p>
        <?php endif; ?>
    </div>
</header>

<main class="py-4">
    <div class="container-lg">
        <div class="card shadow-sm">
            <div class="card-body fs-5">
                <?= $page['content'] ?>
            </div>
        </div>
    </div>
</main>
<?= $this->endSection() ?>