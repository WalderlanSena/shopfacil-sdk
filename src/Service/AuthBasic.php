<?php
/**
 * Created by PhpStorm.
 * User: Walderlan Sena <senawalderlan@gmail.com>
 * Date: 24/10/18
 * Time: 11:27
 */

namespace Mvs\ShopFacilSdk\Service;

class AuthBasic
{
    private $transactionService;

    public function __construct(TransactionPaymentBoletoBradescoService $transactionService)
    {
        $this->transactionService = $transactionService;
        $this->generateToken();
    }

    public function generateToken()
    {
        return 'Basic '.base64_encode(
            $this->transactionService->getMerchantId().':'.$this->transactionService->getChaveSeguranca());
    }
}