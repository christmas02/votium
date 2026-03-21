<?php

namespace App\Transaction\Transferts;


class ProcessTransfertHyperfast
{
    protected $hyperfastAuthenticate;
    protected $hyperfastTransfert;
    protected $hyperfastVerification;

    public function __construct(HyperfastAuthenticate $hyperfastAuthenticate,
                                HyperfastPayment $hyperfastPayment,
                                HyperfastVerification $hyperfastVerification)
    {
        $this->hyperfastAuthenticate = $hyperfastAuthenticate;
        $this->hyperfastPayment = $hyperfastPayment;
        $this->hyperfastVerification = $hyperfastVerification;

    }
}