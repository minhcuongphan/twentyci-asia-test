<?php

namespace App\Console\Commands;

use App\Models\Post;
use Carbon\Carbon;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class schedulePostPublishingCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:posts-status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'publish posts created today at 23.59';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * publish the status of posts created today
     *
     * @return int
     */
    public function handle()
    {
        try {
            Post::whereDate('created_at', Carbon::today())->update(['status' => Post::APPROVED_POST_STATUS]);
            Log::info('The status of posts created today has been successfully published');
        } catch (Exception $e) {
            Log::info('There was an error while publishing the status of posts, please check the error messages:' . $e->getMessage());
        }
    }
}
