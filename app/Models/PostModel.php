<?php

namespace App\Models;

use CodeIgniter\Model;
use Michalsn\CodeIgniterTags\Traits\HasTags;
class PostModel extends Model
{
    use HasTags;
    protected $table = "posts";
    protected $primaryKey = "id";
    protected $useAutoIncrement = true;
    protected $returnType = "array";
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [
        "user_id",
        "slug",
        "title",
        "meta_description",
        "featured_image",
        "content",
        "tags",
        "views",
        "status",
    ];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat = "datetime";
    protected $createdField = "created_at";
    protected $updatedField = "updated_at";

    // Validation
    protected $validationRules = [];
    protected $validationMessages = [];
    protected $skipValidation = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert = [];
    protected $afterInsert = [];
    protected $beforeUpdate = [];
    protected $afterUpdate = [];
    protected $beforeFind = [];
    protected $afterFind = [];
    protected $beforeDelete = [];
    protected $afterDelete = [];

    protected function initialize()
    {
        $this->initTags();
    }

    public function getPostFromUserId($userId)
    {
        return $this->where('user_id', $userId)->orderBy('created_at', 'DESC');
    }

    public function getPostAuthorUsername($postId)
    {
        $post = $this->find($postId);
        if ($post) {
            $users = auth()->getProvider();
            $user = $users->find($post['user_id']);
            return $user ? $user->username : null;
        }
        return null;
    }

    public function incrementViews(int $postId): bool
    {
        $builder = $this->db->table($this->table);

        return (bool) $builder
            ->where('id', $postId)
            ->set('views', 'views + 1', false)
            ->update();
    }

    public function searchPosts(string $keyword)
    {
        return $this->like('title', $keyword)
            ->orLike('meta_description', $keyword)
            ->orLike('content', $keyword)
            ->orderBy('created_at', 'DESC')
            ->findAll();
    }

    



}
