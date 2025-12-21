<?php

namespace App\Controllers;

use App\Models\PostModel;
use App\Models\UserModel;
use App\Models\PageModel;
class Blog extends BaseController
{
    protected $postModel;
    protected $userModel;
    protected $pageModel;
    public function __construct()
    {
        $this->postModel = new PostModel();
        $this->userModel = new UserModel();
        $this->pageModel = new PageModel();
    }

    public function view($slug)
    {
        // Get post with tags
        $post = $this->postModel->where('slug', $slug)->withTags()->first();

        if (!$post) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException("Post not found");
        }

        $this->trackUniquePostView((int) $post['id']);
        $post['views'] = (int) ($post['views'] ?? 0) + 1;
        // Get post author username
        $post['username'] = $this->postModel->getPostAuthorUsername($post['id']);
        $authorBio = $this->userModel->getBioByUsername($post['username']);
        // Get recent posts for sidebar
        $recentPosts = $this->postModel->orderBy('created_at', 'DESC')->limit(5)->findAll();

        // Add username to recent posts
        foreach ($recentPosts as &$recentPost) {
            $recentPost['username'] = $this->postModel->getPostAuthorUsername($recentPost['id']);
        }




        $data = [
            'post' => $post,
            'recentPosts' => $recentPosts,
            'authorBio' => $authorBio,
            'metaTitle' => $post['title'] . ' - TheGoodOne Blog',
            'metaDescription' => $post['meta_description'],

        ];

        return view('blog/view', $data);
    }

    public function tag($tagSlug)
    {
        // Get tag with posts using the tags model
        $tagModel = model('Michalsn\CodeIgniterTags\Models\TagModel');
        $tag = $tagModel->where('slug', $tagSlug)->first();

        if (!$tag) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException("Tag not found");
        }

        // Get posts with this tag using the tag slug - paginated
        $posts = $this->postModel->withAnyTags([$tagSlug])->orderBy('created_at', 'DESC')->paginate(12, 'tag');

        // Add username to each post
        foreach ($posts as &$post) {
            $post['username'] = $this->postModel->getPostAuthorUsername($post['id']);
        }

        // Get recent posts for sidebar
        $recentPosts = $this->postModel->orderBy('created_at', 'DESC')->limit(5)->findAll();

        // Add username to recent posts
        foreach ($recentPosts as &$recentPost) {
            $recentPost['username'] = $this->postModel->getPostAuthorUsername($recentPost['id']);
        }

        $data = [
            'tag' => $tag,
            'posts' => $posts,
            'pager' => $this->postModel->pager,
            'recentPosts' => $recentPosts,
            'metaTitle' => 'Posts tagged with "' . $tag->name . '" - TheGoodOne Blog',
            'metaDescription' => 'Explore all posts tagged with ' . $tag->name . ' on TheGoodOne Blog.',
        ];

        return view('blog/tag', $data);
    }


    public function page(string $slug)
    {


        $page = $this->pageModel
            ->where('slug', $slug)
            ->where('status', 'published')
            ->first();

        if (!$page) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        return view('pages/view', ['page' => $page]);
    }

    private function trackUniquePostView(int $postId): void
    {
        // 12 hours cooldown (tweak as you like)
        $ttlSeconds = 12 * 60 * 60;

        $cookieName = 'pv_' . $postId;

        // If cookie exists, do nothing
        $existing = $this->request->getCookie($cookieName);
        if ($existing) {
            return;
        }

        $userAgent = strtolower((string) $this->request->getUserAgent());
        if ($this->request->getMethod() !== 'get') {
            return;
        }

        // crude bot filter (good enough for baseline)
        $bad = ['bot', 'spider', 'crawler', 'slurp', 'facebookexternalhit', 'preview'];
        foreach ($bad as $needle) {
            if (str_contains($userAgent, $needle)) {
                return;
            }
        }

        // Optional: avoid counting HEAD requests
        if ($this->request->getMethod() === 'head') {
            return;
        }


        // Increment atomically
        $this->postModel->incrementViews($postId);

        // Set cookie
        helper('cookie');
        set_cookie([
            'name' => $cookieName,
            'value' => '1',
            'expire' => $ttlSeconds,
            'path' => '/',
            'secure' => (bool) config('App')->forceGlobalSecureRequests,
            'httponly' => true,
            'samesite' => 'Lax',
        ]);
    }
}
