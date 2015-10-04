<?php
/**
 * @license see LICENSE
 */

namespace UForm\Validator\Csrf;

/**
 * Aims to validate csrf token with csrf validator
 * @see UForm\Validator\Csrf
 * @see
 */
interface CsrfInterface
{

    /**
     * Get a valid csrf token
     * @return string a csrf token
     */
    public function getToken();

    /**
     * Check if the given token is valid
     * @param string $token the token to check
     * @return bool true if the given token is valid
     */
    public function tokenIsValid($token);
}
