<?php

declare(strict_types=1);

namespace PaymentGatewayOrchestrator\Orchestrator;

final class PaymentOrchestrator
{
    private array $gateways = [];

    public function registerGateway(string $name, object $gateway): void
    {
        $this->gateways[$name] = $gateway;
    }

    public function processPayment(string $gatewayName, float $amount): array
    {
        return [
            'gateway' => $gatewayName,
            'amount' => $amount,
            'status' => 'completed',
            'transaction_id' => uniqid('txn_'),
        ];
    }
}
