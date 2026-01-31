<?php

declare(strict_types=1);

namespace PaymentGatewayOrchestrator\Gateway;

/**
 * Payment gateway interface
 */
interface PaymentGatewayInterface
{
    /**
     * Process a payment
     *
     * @param float $amount
     * @param array<string, mixed> $data
     * @return array<string, mixed>
     */
    public function charge(float $amount, array $data): array;

    /**
     * Refund a payment
     *
     * @param string $transactionId
     * @param float $amount
     * @return array<string, mixed>
     */
    public function refund(string $transactionId, float $amount): array;

    /**
     * Get gateway name
     */
    public function getName(): string;

    /**
     * Check if gateway is available
     */
    public function isAvailable(): bool;
}
