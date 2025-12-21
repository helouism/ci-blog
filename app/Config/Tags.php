<?php

namespace Config;

use Michalsn\CodeIgniterTags\Config\Tags as BaseTags;

class Tags extends BaseTags
{
    /**
     * Whether unused tags will be
     * removed automatically upon update.
     */
    public bool $cleanupUnusedTags = true;
}
