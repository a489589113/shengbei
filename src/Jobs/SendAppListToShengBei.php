<?php
/**
 * Created by PhpStorm.
 * User: haoqi
 * Date: 2018/8/9
 * Time: 10:22
 */

namespace Crius\Smy\Jobs;

use Crius\Smy\Manager\SmyManager;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SendAppListToShengBei implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $postFields;
    private $manager;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(array $postFields, SmyManager $manager)
    {
        $this->postFields = $postFields;
        $this->manager = $manager;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->manager->sendApplist($this->postFields);
    }
}
