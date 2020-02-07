<?php
declare(strict_types=1);

namespace Setapp\Test\Payments\Adapters;

use Setapp\Test\Core\InterfaceInvoice;
use Setapp\Test\Payments\InterfaceProvider;
use Setapp\Test\Payments\Providers\SimpleProvider;

class SimpleProviderAdapter implements InterfaceProvider
{
    private $provider;

    public function __construct(SimpleProvider $provider)
    {
        $this->provider = $provider;
    }

    /**
     * @return string
     */
    public function getProviderName(): string
    {
        return SimpleProvider::NAME;
    }

    /**
     * @param InterfaceInvoice $invoice
     * @return bool
     */
    public function chargeInvoice(InterfaceInvoice $invoice): bool
    {
        $result = $this->provider->charge(
            $invoice->getCustomerId(),
            $invoice->getAmount()
        );

        return $result;
    }
}
