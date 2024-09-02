<?php

declare(strict_types=1);

namespace App\Core\Bases;

/**
 * Contains every service comon operation
 *
 * @package App\Core\Bases
 */
class BaseService
{
    /**
     * Mounts the response array for the controller
     *
     * @param int|string $httpResponseCode Response status code
     * @param string $message Response message
     * @param null|array $additionalData Response data
     * @return array
     */
    protected function mountResponseArray(int|string $httpResponseCode, string $message, ?array $additionalData = null): array
    {
        $response = [
            'response_http_code' => (int)$httpResponseCode,
            'response_body'      => [
                'message' => $message,
            ]
        ];

        if (!is_null($additionalData)) {
            $response['response_body']['data'] = $additionalData;
        }

        return $response;
    }

    /**
     * Check if all the mandatory request data exists and is the correct data type
     *
     * @param array $requestData Request data
     * @param array $mandatoryRequestDataInfo Expect request data and data type
     * @return bool
     */
    protected function validateMandatoryRequestData(array $requestData, array $mandatoryRequestDataInfo): bool
    {
        foreach ($mandatoryRequestDataInfo as $key => $type) {
            // Validate mandatory data existence
            if (!array_key_exists($key, $requestData)) {
                return false;
            }

            if (gettype($requestData[$key]) !== $type) {
                return false;
            }
        }

        return true;
    }
}
