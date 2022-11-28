<?php

namespace App\Http\Errors;

class ErrorCodes
{
    public const ERROR_NOT_DEFINED = 999;
    public const WITHOUT_ERROR = 00;

    private const AUTHENTICATION_ERRORS = [
        'AUTHENTICATION_ERROR_UNKNOWN' => 001,
        'LOGIN_FAILED' => 002,
        'INVALID_USER_TOKEN' => 003,
    ];

    /**
     * @param $errorName
     *
     * @return int
     */
    public function getAuthenticationErrorCode($errorName): int
    {
        if (in_array($errorName, self::AUTHENTICATION_ERRORS)) {
            return self::AUTHENTICATION_ERRORS[$errorName];
        }
        return self::ERROR_NOT_DEFINED;
    }
}
