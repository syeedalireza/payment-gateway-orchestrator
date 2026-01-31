<?php

declare(strict_types=1);

namespace PaymentGatewayOrchestrator\Gateway;

/**
 * Square payment gateway
 */
final class SquareGateway implements PaymentGatewayInterface
{
    public function __construct(
        private readonly string $accessToken
    ) {
    }

    public function charge(float $amount, array $data): array
    {
        return [
            'success' => true,
            'transaction_id' => 'sq_' . bin2hex(random_bytes(12)),
            'amount' => $amount,
            'gateway' => 'square',
        ];
    }

    public function refund(string $transactionId, float $amount): array
    {
        return [
            'success' => true,
            'refund_id' => 'sq_refund_' . bin2hex(random_bytes(10)),
            'amount' => $amount,
        ];
    }

    public function getName(): string
    {
        return 'Square';
    }

    public function isAvailable(): bool
    {
        return !empty($this->accessToken);
    }
}
