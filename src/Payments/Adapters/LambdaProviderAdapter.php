<?php
declare(strict_types=1);

namespace Setapp\Test\Payments\Adapters;

use Setapp\Test\Core\InterfaceInvoice;
use Setapp\Test\Payments\InterfaceProvider;
use Setapp\Test\Payments\Providers\LambdaProvider;

class LambdaProviderAdapter implements InterfaceProvider
{
    private $provider;

    public function __construct(LambdaProvider $provider)
    {
        $this->provider = $provider;
    }

    /**
     * @return string
     */
    public function getProviderName(): string
    {
        return LambdaProvider::NAME;
    }

    /**
     * @param InterfaceInvoice $invoice
     * @return bool
     */
    public function chargeInvoice(InterfaceInvoice $invoice): bool
    {
        $data = [
            'invoices' => [
                $invoice->getId() => [
                    $invoice->getCustomerId(),
                    $invoice->getAmount(),
                ],
            ],
        ];

        $result = $this->provider->charge($data);

        return $result[$invoice->getId()];
    }
}
