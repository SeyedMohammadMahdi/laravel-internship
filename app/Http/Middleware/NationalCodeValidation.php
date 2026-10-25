<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;

class NationalCodeValidation
{

    public function handle(Request $request, Closure $next): Response
    {
        $validator = Validator::make($request->all(), [
            'nationalCode' => 'required|integer|between:3,100',
        ]);
        $ip = $request->ip();
        if ($validator->fails()) {
            Log::error("NationalCodeValidationMiddleware: notional code NOT FOUND, ip: $ip");
            return response()->json($validator->errors(), 400);
        }
        Log::info("NationalCodeValidationMiddleware: notional code FOUND, ip: $ip");

        return $next($request);
    }
}
