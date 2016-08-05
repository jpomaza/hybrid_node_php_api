<?php

namespace App\Http\Controllers\ApiTest;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use \Exception;
use GuzzleHttp;
use Log;

class NodeApiController extends Controller
{

    private $attemps;

    public function __construct()
    {

        $this->client = new GuzzleHttp\Client([
            'base_uri' => 'http://localhost:3000/api/test/'
        ]);
        $this->attemps = 1;
    }


    public function sendDataToNodeApi($endpoint, $objData)
    {
        try{
            $response = $this->client->request('PUT', $endpoint, [
                'headers' => [
                    'Accept'     => '*/*',
                    'Accept-language' => 'en-US,en;q=0.5',/*very important for locales*/
                    //'Authorization' => 'Bearer '.$token->access_token
                ],
                'json' => ['msg' => $objData->message, 'wait'=> $objData->wait]
            ]);

        } catch (GuzzleHttp\Exception\ClientException $e) {
            $response = $e->getResponse();
            Log::info('catch exception');
            Log::info($e);

            return null;
        }
        // Decode response.
        $data = json_decode($response->getBody());
        Log::info('===> response from node.js API ==>'.$data);

        if (!$data) {
            Log::info('Error decoding the results from nodeAPI.');
            Log::info($e);
            return null;
        }

        return $data;
    }
}

