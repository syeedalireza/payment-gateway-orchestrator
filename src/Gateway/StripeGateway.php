<?php

declare(strict_types=1);

namespace PaymentGatewayOrchestrator\Gateway;

/**
 * Stripe payment gateway
 */
final class StripeGateway implements PaymentGatewayInterface
{
    public function __construct(
        private readonly string $apiKey
    ) {
    }

    public function charge(float $amount, array $data): array
    {
        return [
            'success' => true,
            'transaction_id' => 'ch_' . bin2hex(random_bytes(12)),
            'amount' => $amount,
            'gateway' => 'stripe',
        ];
    }

    public function refund(string $transactionId, float $amount): array
    {
        return [
            'success' => true,
            'refund_id' => 're_' . bin2hex(random_bytes(12)),
            'amount' => $amount,
        ];
    }

    public function getName(): string
    {
        return 'Stripe';
    }

    public function isAvailable(): bool
    {
        return !empty($this->apiKey);
    }
}
