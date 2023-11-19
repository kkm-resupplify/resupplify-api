<?php

namespace App\Helpers;

use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

trait JsonResponseTrait
{
    /**
     * Returns a JSON response
     *
     * @param $data
     * @param $code
     *
     * @return JsonResponse
     */
    public function responseJson($data, $code): JsonResponse
    {
        return response()->json($data, $code);
    }

    /**
     * Returns a wrapped array
     *
     * @param $data
     *
     * @return array
     */
    public function wrap(array $arr): array
    {
        return $arr;
    }

    /**
     * @param $data
     *
     * @return array
     */
    private function wrapSuccess($data): array
    {
        $response = [
            'success' => true,
            'data' => $data,
        ];

        if (isset($data['pagination'])) {
            $response['pagination'] = $data['pagination'];
            unset($data['pagination']);
        }

        return $this->wrap($response);
    }

    /**
     * Wraps response with error data
     *
     * @param string $errorMsg
     * @param int $httpCode
     * @param string $errorCode
     * @param string $errorUid
     * @param $errorData
     *
     * @return array
     */
    private function wrapError(
        string $errorMsg,
        int $httpCode,
        string $errorCode,
        string $errorUuid = '',
        $errorData = ''
    ): array {
        $array = [
            'success' => false,
            'httpCode' => $httpCode,
            'error' => [
                'code' => $errorCode,
                'message' => $errorMsg,
                'uuid' => $errorUuid,
            ],
        ];

        if ($errorData != '') {
            $array['error']['data'] = $errorData;
        }

        return $this->wrap($array);
    }

    /**
     * HTTP code 200 - ok.
     *
     * @param array $data
     *
     * @return JsonResponse
     */
    protected function ok($data = []): JsonResponse
    {
        return $this->responseJson(
            $this->wrapSuccess($data),
            Response::HTTP_OK
        );
    }

    /**
     * HTTP code 201 - created.
     *
     * @param array $data
     *
     * @return JsonResponse
     */
    protected function created($data = []): JsonResponse
    {
        return $this->responseJson(
            $this->wrapSuccess($data),
            Response::HTTP_CREATED
        );
    }

    /**
     * HTTP code 202 - accepted
     *
     * @param array $data
     *
     * @return JsonResponse
     */
    protected function accepted($data = []): JsonResponse
    {
        return $this->responseJson(
            $this->wrapSuccess($data),
            Response::HTTP_ACCEPTED
        );
    }

    /**
     * HTTP code 204 - no content
     *
     * @param array $data
     *
     * @return JsonResponse
     */
    protected function noContent($data = []): JsonResponse
    {
        return $this->responseJson(
            $this->wrapSuccess($data),
            Response::HTTP_NO_CONTENT
        );
    }

    /**
     * HTTP code 401 - unauthorized
     *
     * @param string $error
     * @param string $errorCode
     *
     * @return JsonResponse
     */
    protected function unauthorized(
        string $error = '',
        string $errorCode = ''
    ): JsonResponse {
        if ($error == '') {
            $error = __('httpRequests.401');
        }

        return $this->responseJson(
            $this->wrapError($error, Response::HTTP_UNAUTHORIZED, $errorCode),
            Response::HTTP_UNAUTHORIZED
        );
    }

    /**
     * HTTP code 403 - forbidden
     *
     * @param string $error
     * @param string $errorCode
     *
     * @return JsonResponse
     */
    protected function forbidden(
        string $error = '',
        string $errorCode = ''
    ): JsonResponse {
        if ($error == '') {
            $error = __('httpRequests.403');
        }

        return $this->responseJson(
            $this->wrapError($error, Response::HTTP_FORBIDDEN, $errorCode),
            Response::HTTP_FORBIDDEN
        );
    }

    /**
     * HTTP code 404 - not found
     *
     * @param string $error
     * @param string $errorCode
     *
     * @return JsonResponse
     */
    protected function notFound(
        string $error = '',
        string $errorCode = ''
    ): JsonResponse {
        if ($error == '') {
            $error = __('httpRequests.404');
        }

        return $this->responseJson(
            $this->wrapError($error, Response::HTTP_NOT_FOUND, $errorCode),
            Response::HTTP_NOT_FOUND
        );
    }

    /**
     * HTTP code 422 - unprocessable entity
     *
     * @param string $error
     * @param string $errorCode
     *
     * @return JsonResponse
     */
    protected function unprocessableEntity(
        string $error = '',
        string $errorCode = ''
    ): JsonResponse {
        if ($error == '') {
            $error = __('httpRequests.422');
        }

        return $this->responseJson(
            $this->wrapError(
                $error,
                Response::HTTP_UNPROCESSABLE_ENTITY,
                $errorCode
            ),
            Response::HTTP_UNPROCESSABLE_ENTITY
        );
    }

    /**
     * HTTP code 500 - internal server error
     *
     * @param string $error
     * @param string $errorCode
     *
     * @return JsonResponse
     */
    protected function internalServerError(
        string $error = '',
        string $errorCode = ''
    ): JsonResponse {
        if ($error == '') {
            $error = __('httpRequests.500');
        }

        return $this->responseJson(
            $this->wrapError(
                $error,
                Response::HTTP_INTERNAL_SERVER_ERROR,
                $errorCode
            ),
            Response::HTTP_INTERNAL_SERVER_ERROR
        );
    }
}
