<?php

namespace App\Jobs;

use App\Jobs\Job;
use Illuminate\Contracts\Mail\Mailer;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Http\Controllers\ApiTest;
use App\Http\Controllers\ApiTest\ApiTestController;
use Log;

class ProcessTest extends Job implements SelfHandling, ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    protected $objMessage;

    /**
     * Create a new job instance.
     *
     * @param  \stdClass  $objMessage
     * @return void
     */
    public function __construct(\stdClass $objMessage)
    {
        $this->objMessage = $objMessage;
    }

    /**
     * Execute the job.
     *
     * @param  Mailer  $mailer
     * @return void
     */
    public function handle()
    {
        //do someting
        Log::info('setting up message in QUEUE API PHP');

        $obj = $this->objMessage;
        sleep($obj->wait);

        /*send the response*/
        $obj->message = $obj->message.' :::: Processed in queue in API PHP';

        Log::info('sending to API php for sending to node.js API');

        /*send response*/
        $apiTest = new ApiTestController();
        $apiTest->sendMessage($obj);

    }
}
