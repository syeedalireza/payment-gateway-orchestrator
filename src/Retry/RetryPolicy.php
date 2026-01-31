<?php

declare(strict_types=1);

namespace PaymentGatewayOrchestrator\Retry;

/**
 * Retry policy with exponential backoff
 */
final class RetryPolicy
{
    public function __construct(
        private readonly int $maxAttempts = 3,
        private readonly int $initialDelayMs = 100,
        private readonly float $multiplier = 2.0
    ) {
    }

    /**
     * Execute with retry logic
     *
     * @param callable $operation
     * @return mixed
     * @throws \Exception
     */
    public function execute(callable $operation): mixed
    {
        $attempt = 0;
        $delay = $this->initialDelayMs;

        while ($attempt < $this->maxAttempts) {
            try {
                return $operation();
            } catch (\Exception $e) {
                $attempt++;
                
                if ($attempt >= $this->maxAttempts) {
                    throw $e;
                }

                usleep($delay * 1000);
                $delay = (int) ($delay * $this->multiplier);
            }
        }

        throw new \RuntimeException('Should not reach here');
    }

    public function getMaxAttempts(): int
    {
        return $this->maxAttempts;
    }
}
