<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Search extends BaseController
{
    protected $postModel;
    public function __construct()
    {
        $this->postModel = new \App\Models\PostModel();
    }
    // Search posts by keyword
    public function index(): ResponseInterface|string
    {
        $keyword = $this->request->getGet('query');

        $posts = $this->postModel->searchPosts($keyword);
        // Add username to each post
        foreach ($posts as &$post) {
            $post['username'] = $this->postModel->getPostAuthorUsername($post['id']);
        }
        $data = [
            'title' => 'Search results for "' . esc($keyword) . '" - TheGoodOne',
            'metaDescription' => 'Search results for "' . esc($keyword) . '" on TheGoodOne. Find quality content and resources.',
            'posts' => $posts,
            'keyword' => $keyword,
        ];
        return view('search/results', $data);
    }
}
