<?php

namespace App\Exceptions;

use App\Helpers\JsonResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;

abstract class BasicException extends \Exception
{
    use JsonResponseTrait;

    protected string $errorCode;

    protected int $errorHttpCode;

    protected $errorMsg;

    protected $errorData;

    private string $errorUuid;

    protected string $translationKey;

    protected array $translationParams;

    abstract protected function init();

    public function __construct(
        $message = '',
        $code = 0,
        \Throwable $previous = null,
        $errorData = '',
    ) {
        parent::__construct($message, $code, $previous);

        $this->init();
        $this->errorUuid = Str::uuid();
        $this->errorData = $errorData;
        $this->message = class_basename($this);
    }

    public function render(): JsonResponse
    {
        return $this->responseJson(
            $this->wrapError(
                $this->errorMsg,
                $this->errorHttpCode,
                $this->errorCode,
                $this->errorUuid,
                $this->errorData
            ),
            $this->errorHttpCode
        );
    }

    /**
     * Get error code.
     *
     * @return string
     */
    public function getErrorCode(): string
    {
        return $this->errorCode;
    }

    /**
     * Get error http code.
     *
     * @return int
     */
    public function getErrorHttpCode(): int
    {
        return $this->errorHttpCode;
    }

    /**
     * Get error data field.
     *
     * @return mixed
     */
    public function getErrorData(): mixed
    {
        return $this->errorData;
    }

    /**
     * Get uuid of an error.
     *
     * @return string
     */
    public function getUuid(): string
    {
        return $this->errorUuid;
    }

    /**
     * Get error message.
     *
     * @return string
     */
    public function getErrorMessage(): string
    {
        return $this->errorMsg;
    }

    /**
     * Get translation data.
     *
     * @return array
     */
    public function getTranslationData(): array
    {
        return [
            'key' => $this->translationKey,
            'params' => $this->translationParams,
        ];
    }

    public function __(string $key, array $params = []): string
    {
        $this->translationKey = $key;
        $this->translationParams = $params;

        return __($key, $params);
    }
}
