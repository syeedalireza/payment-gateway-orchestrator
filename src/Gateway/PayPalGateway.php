<?php

declare(strict_types=1);

namespace PaymentGatewayOrchestrator\Gateway;

/**
 * PayPal payment gateway
 */
final class PayPalGateway implements PaymentGatewayInterface
{
    public function __construct(
        private readonly string $clientId,
        private readonly string $clientSecret
    ) {
    }

    public function charge(float $amount, array $data): array
    {
        return [
            'success' => true,
            'transaction_id' => 'PAYID-' . strtoupper(bin2hex(random_bytes(10))),
            'amount' => $amount,
            'gateway' => 'paypal',
        ];
    }

    public function refund(string $transactionId, float $amount): array
    {
        return [
            'success' => true,
            'refund_id' => 'REFUND-' . strtoupper(bin2hex(random_bytes(10))),
            'amount' => $amount,
        ];
    }

    public function getName(): string
    {
        return 'PayPal';
    }

    public function isAvailable(): bool
    {
        return !empty($this->clientId) && !empty($this->clientSecret);
    }
}
