<?php

namespace App\Http\Controllers\Test;

use App\Http\Controllers\Controller;
use App\Services\Test\TestService;
use Illuminate\Http\JsonResponse;

class TestController extends Controller
{

    public function roleTest(TestService $testService): JsonResponse {
        return $this->ok($testService->roleTest());
    }
    public function langTest(TestService $testService): JsonResponse {
        return $this->ok($testService->langTest());
    }


}
