<?php

namespace App\Console\Commands;

use App\Models\Article;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

class UpdateNewArticles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'articles:check';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check new articles and delete new label';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $articles = Article::query()->where('created_at', '<',  Carbon::now()->subDays(3))->where('new', 1)->update(['new' => 0]);

        $this->info('Updated '. $articles. ' articles');
        return Command::SUCCESS;
    }
}
