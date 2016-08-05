<?php
namespace App\Http\Controllers\ApiTest;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\GenericResponse;
use Illuminate\Foundation\Bus\DispatchesJobs;
use App\Jobs\ProcessTest;
use App\Http\Controllers\ApiTest\NodeApiController;
use Log;

class ApiTestController extends Controller
{
    use DispatchesJobs;

    /**
     * Set message
     * @param \Illuminate\Http\Request  $request
     * @return mixed
     */
    public function setMessage(Request $request)
    {
        $obj = new \stdClass();
        $obj->message = $request->input('msg');
        $obj->wait = $request->input('wait');

        /* set queues*/
        $this->dispatch(new ProcessTest($obj));

        Log::info('mensaje desde node.js --> recibido y encolado');
        return response()->json(new GenericResponse('recibido y encolado'),202);
    }

    /**
     * Send message to node.js api
     * @param \stdClass $objMessage
     * @return mixed
     */
    public function sendMessage(\stdClass $objMessage)
    {

        $apiNode = new NodeApiController();
        $endpoint = 'showMsg';
        Log::info('enviando mensaje a node.js API');
        $apiNode->sendDataToNodeApi($endpoint, $objMessage);

    }

}
