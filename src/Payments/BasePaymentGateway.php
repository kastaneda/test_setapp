<?php
declare(strict_types=1);

namespace Setapp\Test\Payments;

use Setapp\Test\Core\InterfaceInvoice;
use Setapp\Test\Payments\InterfaceProvider;

class BasePaymentGateway implements InterfacePaymentGateway
{
    private $providers = [];

    /**
     * @param InterfaceProvider ...$providers
     */
    public function __construct(InterfaceProvider ...$providers)
    {
        $this->providers = $providers;
    }

    /**
     * @param InterfaceInvoice[]|array $invoices
     *
     * @return boolean[] array for results [INVOICEID => RESULT, ...]
     */
    public function charge(array $invoices): array
    {
        $result = [];

        foreach ($invoices as $invoice) {
            $result[$invoice->getId()] = $this->chargeInvoice($invoice);
        }

        return $result;
    }

    /**
     * @param InterfaceInvoice $invoice
     * @return bool
     */
    private function chargeInvoice(InterfaceInvoice $invoice): bool
    {
        foreach ($this->providers as $provider) {
            if ($provider->getProviderName() == $invoice->getProvider()) {
                return $provider->chargeInvoice($invoice);
            }
        }

        // If provider not found
        return false;
    }
}
