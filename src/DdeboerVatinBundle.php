<?php declare(strict_types=1);

namespace Ddeboer\VatinBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class DdeboerVatinBundle extends Bundle
{
    /**
     * @inheritDoc
     */
    public function getPath () : string
    {
        return \dirname(__DIR__);
    }
}
