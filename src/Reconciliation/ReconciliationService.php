<?php

declare(strict_types=1);

namespace PaymentGatewayOrchestrator\Reconciliation;

/**
 * Payment reconciliation service
 */
final class ReconciliationService
{
    /** @var array<string, array<string, mixed>> */
    private array $transactions = [];

    public function recordTransaction(string $transactionId, array $data): void
    {
        $this->transactions[$transactionId] = array_merge($data, [
            'recorded_at' => time(),
        ]);
    }

    /**
     * @return array<string, mixed>|null
     */
    public function getTransaction(string $transactionId): ?array
    {
        return $this->transactions[$transactionId] ?? null;
    }

    /**
     * @return array<string, array<string, mixed>>
     */
    public function getAllTransactions(): array
    {
        return $this->transactions;
    }

    public function getTotalAmount(): float
    {
        return array_sum(array_column($this->transactions, 'amount'));
    }

    /**
     * Find discrepancies
     *
     * @return array<int, array<string, mixed>>
     */
    public function findDiscrepancies(): array
    {
        $discrepancies = [];

        foreach ($this->transactions as $id => $transaction) {
            if (($transaction['status'] ?? '') === 'failed') {
                $discrepancies[] = [
                    'transaction_id' => $id,
                    'reason' => 'failed_payment',
                    'data' => $transaction,
                ];
            }
        }

        return $discrepancies;
    }
}
