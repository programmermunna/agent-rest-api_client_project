<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EndPointController extends Controller
{
    public function jokerGaming(Request $request)
    {
        \Log::channel('endpoint')->info('======= Start -Joker Gaming EndPoint  =======');
        \Log::notice('======= Start -Joker Gaming EndPoint  =======');

        try {
            \Log::channel('endpoint')->info('======= Payload -Joker Gaming EndPoint  =======');
            \Log::channel('endpoint')->info(print_r($request->all(), true));

            \Log::notice('======= Payload -Joker Gaming EndPoint  =======');
            \Log::notice(print_r($request->all(), true));

            \Log::channel('endpoint')->info('======= End -Joker Gaming EndPoint  =======');
            \Log::notice('======= End -Joker Gaming EndPoint  =======');

            return 'Success Joker Gaming End Point';
        } catch (\Throwable $th) {
            \Log::channel('endpoint')->error("Caught Exception ('{$th->getMessage()}')\n{$th}\n");
            \Log::notice("Caught Exception ('{$th->getMessage()}')\n{$th}\n");

            \Log::channel('endpoint')->error('======= Error -Joker Gaming EndPoint  =======');
            \Log::notice('======= Error -Joker Gaming EndPoint  =======');

            \Log::channel('endpoint')->info('======= End -Joker Gaming EndPoint  =======');
            \Log::notice('======= End -Joker Gaming EndPoint  =======');

            return 'Failed Joker Gaming End Point';
        }
    }

    public function pragmatic(Request $request, $type)
    {
        $acceptType = ['authenticate', 'balance', 'bet', 'result', 'refund', 'jackportwin', 'bonuswin', 'promowin'];

        if (in_array($type, 'authenticate')) {
            \Log::channel('endpoint')->info('======= Start -Pragmatic Gaming EndPoint  =======');
            \Log::notice('======= Start -Pragmatic Gaming EndPoint  =======');

            try {
                \Log::channel('endpoint')->info('======= Payload -Pragmatic Gaming EndPoint  =======');
                \Log::channel('endpoint')->info(print_r($request->all(), true));

                \Log::notice('======= Payload -Pragmatic Gaming EndPoint  =======');
                \Log::notice(print_r($request->all(), true));

                \Log::channel('endpoint')->info('======= End -Pragmatic Gaming EndPoint  =======');
                \Log::notice('======= End -Pragmatic Gaming EndPoint  =======');
            } catch (\Throwable $th) {
                \Log::channel('endpoint')->error("Caught Exception ('{$th->getMessage()}')\n{$th}\n");
                \Log::notice("Caught Exception ('{$th->getMessage()}')\n{$th}\n");

                \Log::channel('endpoint')->error('======= Error -Pragmatic Gaming EndPoint  =======');
                \Log::notice('======= Error -Pragmatic Gaming EndPoint  =======');

                \Log::channel('endpoint')->info('======= End -Pragmatic Gaming EndPoint  =======');
                \Log::notice('======= End -Pragmatic Gaming EndPoint  =======');
            }
        }
    }

    public function spadeGaming(Request $request, $type)
    {
        $acceptType = ['agent', 'member'];
        if (in_array($type, $acceptType)) {
            \Log::channel('endpoint')->info('======= Start -Spade Gaming EndPoint  =======');
            \Log::notice('======= Start -Spade Gaming EndPoint  =======');

            try {
                \Log::channel('endpoint')->info('======= Payload -Spade Gaming EndPoint  =======');
                \Log::channel('endpoint')->info(print_r($request->all(), true));

                \Log::notice('======= Payload -Spade Gaming EndPoint  =======');
                \Log::notice(print_r($request->all(), true));

                \Log::channel('endpoint')->info('======= End -Spade Gaming EndPoint  =======');
                \Log::notice('======= End -Spade Gaming EndPoint  =======');
            } catch (\Throwable $th) {
                \Log::channel('endpoint')->error("Caught Exception ('{$th->getMessage()}')\n{$th}\n");
                \Log::notice("Caught Exception ('{$th->getMessage()}')\n{$th}\n");

                \Log::channel('endpoint')->error('======= Error -Spade Gaming EndPoint  =======');
                \Log::notice('======= Error -Spade Gaming EndPoint  =======');

                \Log::channel('endpoint')->info('======= End -Spade Gaming EndPoint  =======');
                \Log::notice('======= End -Spade Gaming EndPoint  =======');
            }
        }
    }

    public function playTech(Request $request)
    {
        \Log::channel('endpoint')->info('======= Start -PlayTech Gaming EndPoint  =======');
        \Log::notice('======= Start -PlayTech Gaming EndPoint  =======');

        try {
            \Log::channel('endpoint')->info('======= Payload -PlayTech Gaming EndPoint  =======');
            \Log::channel('endpoint')->info(print_r($request->all(), true));

            \Log::notice('======= Payload -PlayTech Gaming EndPoint  =======');
            \Log::notice(print_r($request->all(), true));

            \Log::channel('endpoint')->info('======= End -PlayTech Gaming EndPoint  =======');
            \Log::notice('======= End -PlayTech Gaming EndPoint  =======');
        } catch (\Throwable $th) {
            \Log::channel('endpoint')->error("Caught Exception ('{$th->getMessage()}')\n{$th}\n");
            \Log::notice("Caught Exception ('{$th->getMessage()}')\n{$th}\n");

            \Log::channel('endpoint')->error('======= Error -PlayTech Gaming EndPoint  =======');
            \Log::notice('======= Error -PlayTech Gaming EndPoint  =======');

            \Log::channel('endpoint')->info('======= End -PlayTech Gaming EndPoint  =======');
            \Log::notice('======= End -PlayTech Gaming EndPoint  =======');
        }
    }
}
