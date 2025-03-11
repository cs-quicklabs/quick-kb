<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class BaseController extends Controller
{
    /**
     * Send a successful response with a given status code.
     *
     * @param array $data
     * @param string $message
     * @param int $statuscode
     * @return \Illuminate\Http\JsonResponse
     */
    protected function sendSuccessResponse($data = [], $message = "Success", $statuscode = 200)
    {
        $response = [
            'success' => true,
            'data'    => $data,
            'message' => $message,
            'statuscode' => $statuscode
        ];

        return response()->json($response, $statuscode);
    }

    /**
     * Send an error response with a given status code.
     *
     * @param array $data Optional data to include in the response.
     * @param string $errors Error message or description.
     * @param int $statuscode HTTP status code for the response.
     * @return \Illuminate\Http\JsonResponse
     */

    protected function sendErrorResponse($data = [], $errors = "Failed", $statuscode = 500) {
        $response = [
            'success' => false,
            'data' => $data,
            'errors' => $errors,
            'statuscode' => $statuscode
        ];

        return response()->json($response, $statuscode);
    }


    /**
     * Throw a HttpResponseException with a validation error response.
     *
     * @param bool $success
     * @param string $message
     * @param array $errors
     * @param int $statuscode
     * @throws \Illuminate\Http\Exceptions\HttpResponseException
     */
    protected function sendValidationError($message = 'Validation errors', $errors = [], $statuscode = 422)
    {
        throw new HttpResponseException(
            response()->json([
                'success' => false,
                'message' => $message,
                'errors' => $errors
            ], $statuscode)
        );
    }
}
