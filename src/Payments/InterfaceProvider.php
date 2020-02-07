<?php
declare(strict_types=1);

namespace Setapp\Test\Payments;

use Setapp\Test\Core\InterfaceInvoice;

interface InterfaceProvider
{
    /**
     * @return string
     */
    public function getProviderName(): string;

    /**
     * @param InterfaceInvoice $invoice
     * @return bool
     */
    public function chargeInvoice(InterfaceInvoice $invoice): bool;
}
