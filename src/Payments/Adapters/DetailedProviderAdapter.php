<?php
declare(strict_types=1);

namespace Setapp\Test\Payments\Adapters;

use Setapp\Test\Core\InterfaceInvoice;
use Setapp\Test\Payments\InterfaceProvider;
use Setapp\Test\Payments\Providers\DetailedProvider;

class DetailedProviderAdapter implements InterfaceProvider
{
    const DATE_FORMAT = 'Y-m-d\TH:i:sP';

    private $provider;

    public function __construct(DetailedProvider $provider)
    {
        $this->provider = $provider;
    }

    /**
     * @return string
     */
    public function getProviderName(): string
    {
        return DetailedProvider::NAME;
    }

    /**
     * @param InterfaceInvoice $invoice
     * @return bool
     */
    public function chargeInvoice(InterfaceInvoice $invoice): bool
    {
        $this->provider->schedule(
            $invoice->getCustomerId(),
            [
                'amount' => $invoice->getAmount(),
                'request_time' => $this->getRequestTime(),
                'invoice_id' => $invoice->getId(),
            ]
        );

        return true;
    }

    /**
     * @return string
     */
    private function getRequestTime(): string
    {
        return date(self::DATE_FORMAT);
    }
}
