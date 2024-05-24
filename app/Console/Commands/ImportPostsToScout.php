<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Post;
use Log;

class ImportPostsToScout extends Command
{
    protected $signature = 'scout:import-posts';
    protected $description = 'Import posts to Algolia using Laravel Scout with size check.';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        Post::chunk(100, function ($posts) {
            foreach ($posts as $post) {
                if (strlen(json_encode($post->toSearchableArray())) <= 10000) {
                    $post->searchable();
                } else {
                    Log::warning("A rekord túl nagy és nem lett indexelve: {$post->id}");
                }
            }
        });
        $this->info('Posts have been imported.');
    }
}
