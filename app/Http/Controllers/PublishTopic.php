<?php

namespace App\Http\Controllers;

use App\Events\ReceivedMessage;
use App\Exceptions\RequestValidationException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class PublishTopic extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param Request $request
     * @param string $topic
     * @return string
     */
    public function __invoke(Request $request, string $topic): string
    {
        try {
            // Validate request
            $validation = Validator::make($request->all(), ['msg' => 'required']);

            if ($validation->fails()) {
                throw new RequestValidationException($validation->errors()->first());
            }

            event(new ReceivedMessage(['topic' => $topic, 'data' => $request->all()]));

            return response()->json(null, Response::HTTP_OK);
        } catch (\Throwable $e) {
            if ($e instanceof RequestValidationException) {
                return response()->json($e->getMessage(), Response::HTTP_BAD_REQUEST);
            }

            return response()->json($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
