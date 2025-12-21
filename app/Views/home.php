<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title) ?></title>
    <meta name="description" content="<?= esc($description) ?>">
    <meta name="robots" content="index, follow, max-snippet:-1, max-image-preview:large, max-video-preview:-1">
    <meta property="og:title" content="<?= esc($title) ?>">
    <meta property="og:description" content="<?= esc($description) ?>">
    <meta property="og:type" content="website">
    <meta property="og:url" content="<?= current_url() ?>">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="<?= esc($title) ?>">
    <meta name="twitter:description" content="<?= esc($description) ?>">

    <!-- Canonical URL -->
    <link rel="canonical" href="<?= current_url() ?>">

    <!-- Structured Data -->
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "WebSite",
        "name": "TheGoodOne",
        "description": "<?= esc($description) ?>",
        "url": "<?= base_url() ?>",
        "potentialAction": {
            "@type": "SearchAction",
            "target": "<?= base_url() ?>?s={search_term_string}",
            "query-input": "required name=search_term_string"
        }
    }
    </script>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.13.1/font/bootstrap-icons.min.css">
    <style>
        :root {
            --primary-color: #2563eb;
            --primary-dark: #1d4ed8;
            --secondary-color: #667eea;
            --text-color: #1f2937;
            --light-bg: #f9fafb;
            --border-color: #e5e7eb;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            color: var(--text-color);
            line-height: 1.6;
        }

        /* Hero Section */
        .hero {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 5rem 0;
            margin-bottom: 3rem;
        }

        .hero h1 {
            font-size: 3rem;
            font-weight: 700;
            margin-bottom: 1.5rem;
            line-height: 1.2;
        }

        .hero p {
            font-size: 1.2rem;
            opacity: 0.95;
            margin-bottom: 2rem;
            max-width: 600px;
        }

        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            padding: 0.75rem 1.75rem;
            font-weight: 600;
        }

        .btn-primary:hover {
            background-color: var(--primary-dark);
            border-color: var(--primary-dark);
        }

        .btn-outline-light:hover {
            background-color: white;
            color: #667eea;
        }

        /* Featured Posts */
        .featured-posts {
            padding: 3rem 0;
        }

        .section-title {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            color: var(--text-color);
        }

        .section-subtitle {
            color: #6b7280;
            margin-bottom: 2rem;
        }

        .post-card {
            background: white;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            overflow: hidden;
            transition: all 0.3s ease;
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        .post-card:hover {
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            transform: translateY(-4px);
            border-color: var(--primary-color);
        }

        .post-card-header {
            position: relative;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            height: 200px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 700;
            font-size: 1.1rem;
            text-align: center;
            padding: 1rem;

            /* for featured image thumbnails */
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }

        .post-card-header.has-image::before {
            content: "";
            position: absolute;
            inset: 0;
            background: linear-gradient(180deg, rgba(0, 0, 0, 0.05), rgba(0, 0, 0, 0.35));
        }

        .post-card-header .post-card-header-text {
            position: relative;
            z-index: 1;
        }

        .post-card-body {
            padding: 1.5rem;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
        }

        .post-card-title {
            font-size: 1.15rem;
            font-weight: 600;
            color: var(--text-color);
            margin-bottom: 0.75rem;
            line-height: 1.4;
        }

        .post-card-title a {
            color: var(--text-color);
            text-decoration: none;
        }

        .post-card-title a:hover {
            color: var(--primary-color);
        }

        .post-meta {
            font-size: 0.85rem;
            color: #9ca3af;
            margin-bottom: 0.75rem;
        }

        .post-description {
            color: #6b7280;
            font-size: 0.95rem;
            margin-bottom: 1rem;
            flex-grow: 1;
        }

        .post-tags {
            display: flex;
            gap: 0.5rem;
            flex-wrap: wrap;
        }

        .post-tag {
            font-size: 0.75rem;
            background-color: var(--light-bg);
            color: var(--primary-color);
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
        }

        /* Ad Spaces */
        .ad-space {
            background-color: var(--light-bg);
            border: 1px dashed var(--border-color);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #9ca3af;
            font-size: 0.9rem;
            margin: 2rem 0;
            padding: 2rem;
        }


        /* CTA Section */
        .cta-section {
            background-color: var(--light-bg);
            padding: 3rem 0;
            margin-top: 3rem;
            border-top: 1px solid var(--border-color);
        }

        .cta-box {
            text-align: center;
            padding: 2rem;
        }

        .cta-box h3 {
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
        }

        .cta-box p {
            color: #6b7280;
            margin-bottom: 1.5rem;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .hero h1 {
                font-size: 2rem;
            }

            .hero p {
                font-size: 1rem;
            }

            .section-title {
                font-size: 1.5rem;
            }

            .post-card-header {
                height: 150px;
            }
        }

        /* Loading Animation */
        .loading {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 3px solid #f3f3f3;
            border-top: 3px solid var(--primary-color);
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }
    </style>
</head>

<body>
    <!-- Navbar -->
    <?= view('partials/navbar') ?>

    <!-- Hero Section -->
    <section class="hero">
        <div class="container-lg">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <h1>Welcome to TheGoodOne</h1>
                    <p>Discover high-quality articles, tips, and resources for your personal and professional growth.
                        Explore our comprehensive blog today.</p>
                    <div class="d-flex gap-3 flex-wrap">
                        <a href="#blog" class="btn btn-light btn-lg fw-600">Read Our Blog</a>
                        <a href="<?= url_to('about_page') ?>" class="btn btn-outline-light btn-lg fw-600">Learn More</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Ad Space (Top) -->
    <div class="container-lg">
        <div class="ad-space" id="ad-top">
            <!-- Google AdSense code here -->
        </div>
    </div>

    <!-- Featured Posts Section -->
    <section class="featured-posts">
        <div class="container-lg">
            <div class="mb-4">
                <h2 class="section-title" id="blog">Latest Articles</h2>
                <p class="section-subtitle">Discover our most recent insights and in-depth guides</p>
            </div>

            <?php if (!empty($posts)): ?>
                <div class="row g-4 mb-5">
                    <?php foreach ($posts as $post): ?>
                        <div class="col-lg-4 col-md-6">
                            <div class="post-card">
                                <?php
                                $thumbUrl = !empty($post['featured_image']) ? base_url($post['featured_image']) : null;
                                ?>
                                <div class="post-card-header <?= $thumbUrl ? 'has-image' : '' ?>" <?= $thumbUrl ? 'style="background-image: url(\'' . esc($thumbUrl, 'attr') . '\')"' : '' ?>>
                                    <?php if (!$thumbUrl): ?>
                                        <span class="post-card-header-text">
                                            <?= esc(strtoupper(substr($post['title'], 0, 3))) ?>
                                        </span>
                                    <?php else: ?>
                                        <span class="visually-hidden"><?= esc($post['title']) ?></span>
                                    <?php endif; ?>
                                </div>

                                <div class="post-card-body">
                                    <h3 class="post-card-title">
                                        <a href="<?= url_to('blog_view', $post['slug']) ?>">
                                            <?= esc(substr($post['title'], 0, 60) . (strlen($post['title']) > 60 ? '...' : '')) ?>
                                        </a>
                                    </h3>
                                    <div class="post-meta">
                                        📅 <?= date('M d, Y', strtotime($post['created_at'])) ?> • ✏️
                                        <?= esc($post['username']) ?>
                                    </div>
                                    <p class="post-description">
                                        <?= esc($post['meta_description']) ?>
                                    </p>
                                    <div class="post-tags">
                                        <span class="post-tag">+ Read More</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="alert alert-info" role="alert">
                    <strong>No posts yet.</strong> Check back soon for our latest articles!
                </div>
            <?php endif; ?>

            <!-- Ad Space (Middle) -->
            <div class="ad-space" id="ad-middle">
                <!-- Google AdSense code here -->
            </div>
        </div>
    </section>



    <!-- CTA Section -->
    <section class="cta-section">
        <div class="container-lg">
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="cta-box">
                        <h3>📚 Knowledge</h3>
                        <p>Access curated content covering various topics and industries</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="cta-box">
                        <h3>💡 Insights</h3>
                        <p>Get actionable insights and practical tips from industry experts</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="cta-box">
                        <h3>🚀 Growth</h3>
                        <p>Accelerate your personal and professional growth with quality content</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Ad Space (Bottom) -->
    <div class="container-lg my-5">
        <div class="ad-space" id="ad-bottom">
            <!-- Google AdSense code here -->
        </div>
    </div>

    <!-- Footer -->
    <?= view('partials/footer') ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Smooth scroll for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({ behavior: 'smooth' });
                }
            });
        });
    </script>
</body>

</html>