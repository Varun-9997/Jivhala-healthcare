<?php

/**
 * Create a Razorpay Order
 *
 * @param string $keyId
 * @param string $keySecret
 * @param int $amount Amount in paise
 * @param string $receipt Unique receipt/reference
 * @param array $notes Optional notes
 *
 * @return array Razorpay order response
 *
 * @throws Exception
 */
function createRazorpayOrder(
    string $keyId,
    string $keySecret,
    int $amount,
    string $receipt,
    array $notes = []
): array {

    $url = 'https://api.razorpay.com/v1/orders';

    $payload = [
        'amount' => $amount,
        'currency' => 'INR',
        'receipt' => $receipt
    ];

    if (!empty($notes)) {
        $payload['notes'] = $notes;
    }

    $ch = curl_init($url);

    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,

        // Razorpay uses HTTP Basic Authentication
        CURLOPT_USERPWD => $keyId . ':' . $keySecret,

        CURLOPT_HTTPHEADER => [
            'Content-Type: application/json'
        ],

        CURLOPT_POSTFIELDS => json_encode($payload),

        CURLOPT_TIMEOUT => 30,

        // Verify SSL certificate
        CURLOPT_SSL_VERIFYPEER => true,
        CURLOPT_SSL_VERIFYHOST => 2
    ]);

    $response = curl_exec($ch);

    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $curlError = curl_error($ch);

    curl_close($ch);

    if ($response === false || !empty($curlError)) {
        throw new Exception(
            'Unable to connect to Razorpay: ' . $curlError
        );
    }

    $data = json_decode($response, true);

    if (!is_array($data)) {
        throw new Exception(
            'Invalid response received from Razorpay.'
        );
    }

    if ($httpCode < 200 || $httpCode >= 300) {

        $message = $data['error']['description']
            ?? 'Razorpay API request failed.';

        throw new Exception($message);
    }

    if (empty($data['id'])) {
        throw new Exception(
            'Razorpay order ID was not returned.'
        );
    }

    return $data;
}