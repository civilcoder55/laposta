<?php

namespace App\Console;

use App\Jobs\PublishPost;
use App\Models\Post;
use Carbon\Carbon;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{

    protected $commands = [
        //
    ];
    // 1620857400 1620857460 1:00 2:1
    protected function schedule(Schedule $schedule)
    {
        // command to run every minute to get every post between now and after minute then dispatch it to publish but delay with differance to make it run at exact time
        $schedule->call(function () {
            $date1 = Carbon::now()->timestamp + 1;
            $date2 = Carbon::now()->addMinute()->timestamp;
            $posts = Post::with(['accounts', 'media'])->where(['draft' => 0, 'locked' => 0])->whereBetween('schedule_date', [$date1, $date2])->get();
            foreach ($posts as $post) {
                foreach ($post->accounts as $account) {
                    PublishPost::dispatch($post, $account)->delay($post->schedule_date);
                }
            }
        })->everyMinute();

    }

    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
