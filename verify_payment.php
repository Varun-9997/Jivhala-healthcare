<?php

header('Content-Type: application/json; charset=utf-8');

require_once 'conn.php';

try {

    // Only allow POST requests
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception('Invalid request method.');
    }

    // Get payment details from Checkout
    $paymentId = trim($_POST['razorpay_payment_id'] ?? '');
    $checkoutOrderId = trim($_POST['razorpay_order_id'] ?? '');
    $signature = trim($_POST['razorpay_signature'] ?? '');

    if ($paymentId === '' || $checkoutOrderId === '' || $signature === '') {
        throw new Exception('Incomplete payment information.');
    }

    /*
     * Load Razorpay credentials
     * Key Secret remains on the server and is never sent to JavaScript.
     */
    $razorpayConfig = require __DIR__ . '/config/razorpay.php';

    $keySecret = $razorpayConfig['key_secret'] ?? '';

    if ($keySecret === '') {
        throw new Exception('Razorpay configuration is missing.');
    }

    /*
     * IMPORTANT:
     * Do NOT trust the razorpay_order_id sent by the browser.
     *
     * Find the booking using the order ID stored in our database.
     */
    $stmt = $pdo->prepare("
        SELECT
            id,
            booking_number,
            amount,
            booking_status,
            payment_status,
            razorpay_order_id,
            razorpay_payment_id
        FROM equipment_bookings
        WHERE razorpay_order_id = ?
        LIMIT 1
    ");

    $stmt->execute([$checkoutOrderId]);

    $booking = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$booking) {
        throw new Exception('Booking associated with this payment was not found.');
    }

    /*
     * Make sure this payment has not already been processed.
     */
    if ($booking['payment_status'] === 'paid') {

        echo json_encode([
            'success' => true,
            'message' => 'Payment has already been verified.',
            'booking_number' => $booking['booking_number']
        ]);

        exit;
    }

    /*
     * Verify that the Razorpay order ID returned by Checkout
     * matches the order ID stored for this booking.
     */
    if (
        empty($booking['razorpay_order_id']) ||
        !hash_equals(
            $booking['razorpay_order_id'],
            $checkoutOrderId
        )
    ) {
        throw new Exception('Invalid Razorpay order.');
    }

    /*
     * Generate the signature using:
     *
     * order_id|payment_id
     *
     * and the Razorpay Key Secret.
     */
    $generatedSignature = hash_hmac(
        'sha256',
        $booking['razorpay_order_id'] . '|' . $paymentId,
        $keySecret
    );

    /*
     * Compare generated signature with the signature
     * returned by Razorpay Checkout.
     */
    if (!hash_equals($generatedSignature, $signature)) {
        throw new Exception('Payment signature verification failed.');
    }

    /*
     * Signature is valid.
     *
     * Update the booking.
     */
    $pdo->beginTransaction();

    $update = $pdo->prepare("
        UPDATE equipment_bookings
        SET
            payment_status = 'paid',
            razorpay_payment_id = ?,
            paid_at = NOW(),
            booking_status = 'confirmed'
        WHERE id = ?
          AND payment_status = 'pending'
    ");

    $update->execute([
        $paymentId,
        $booking['id']
    ]);

    /*
     * Make sure exactly one pending booking was updated.
     */
    if ($update->rowCount() !== 1) {

        $pdo->rollBack();

        /*
         * It may have already been processed by another request.
         */
        $check = $pdo->prepare("
            SELECT payment_status
            FROM equipment_bookings
            WHERE id = ?
            LIMIT 1
        ");

        $check->execute([$booking['id']]);

        $currentStatus = $check->fetchColumn();

        if ($currentStatus === 'paid') {

            echo json_encode([
                'success' => true,
                'message' => 'Payment has already been verified.',
                'booking_number' => $booking['booking_number']
            ]);

            exit;
        }

        throw new Exception('Unable to update payment status.');
    }

    $pdo->commit();

    echo json_encode([
        'success' => true,
        'message' => 'Payment verified successfully.',
        'booking_number' => $booking['booking_number'],
        'payment_id' => $paymentId
    ]);

} catch (Throwable $e) {

    if (isset($pdo) && $pdo->inTransaction()) {
        $pdo->rollBack();
    }

    http_response_code(400);

    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}