<?php
/**
 * Created by PhpStorm.
 * User: Walderlan Sena <senawalderlan@gmail.com>
 * Date: 23/10/18
 * Time: 13:49
 */

namespace Mvs\ShopFacilSdk\Service;

use Mvs\ShopFacilSdk\Repository\BradescoShopFacilRepository;

class TransactionPaymentBoletoBradescoService
{
    const ENVIRONMENT_PROD = 'https://meiosdepagamentobradesco.com.br/apiboleto';
    const ENVIRONMENT_DEV  = 'https://homolog.meiosdepagamentobradesco.com.br/apiboleto';

    private $merchant_id;
    private $email;
    private $chave_seguranca;
    private $pedido;
    private $comprador;
    private $boleto;
    private $token_request_confirmacao_pagamento;
    private $bradescoShopFacilRepository;
    /**
     * @var PedidoBradescoShopFacilService $pedidoBradescoShopFacilService
     */
    private $pedidoBradescoShopFacilService;
    /**
     * @var CompradorBradescoShopFacilService $compradorBradescoShopFacilService
     */
    private $compradorBradescoShopFacilService;
    /**
     * @var EnderecoBradescoShopFacilService $enderecoBradescoShopFacilService
     */
    private $enderecoBradescoShopFacilService;
    /**
     * @var BoletoBradescoShopFacilService $boletoBradescoShopFacilService
     */
    private $boletoBradescoShopFacilService;
    /**
     * @var RegistroBoletoBradescoShopFacilService $registroBoletoBradescoShopFacilService
     */
    private $registroBoletoBradescoShopFacilService;

    public function __construct(
        BradescoShopFacilRepository $bradescoShopFacilRepository,
        PedidoBradescoShopFacilService $pedidoBradescoShopFacilService,
        CompradorBradescoShopFacilService $compradorBradescoShopFacilService,
        EnderecoBradescoShopFacilService $enderecoBradescoShopFacilService,
        BoletoBradescoShopFacilService $boletoBradescoShopFacilService,
        RegistroBoletoBradescoShopFacilService $registroBoletoBradescoShopFacilService)
    {
        $this->bradescoShopFacilRepository            = $bradescoShopFacilRepository;
        $this->pedidoBradescoShopFacilService         = $pedidoBradescoShopFacilService;
        $this->compradorBradescoShopFacilService      = $compradorBradescoShopFacilService;
        $this->enderecoBradescoShopFacilService       = $enderecoBradescoShopFacilService;
        $this->boletoBradescoShopFacilService         = $boletoBradescoShopFacilService;
        $this->registroBoletoBradescoShopFacilService = $registroBoletoBradescoShopFacilService;
    }

    /**
     * @return mixed
     */
    public function getMerchantId()
    {
        return $this->merchant_id;
    }

    /**
     * @param mixed $merchant_id
     * @return TransactionPaymentBoletoBradescoService
     */
    public function setMerchantId($merchant_id)
    {
        $this->merchant_id = $merchant_id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     * @return TransactionPaymentBoletoBradescoService
     */
    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getChaveSeguranca()
    {
        return $this->chave_seguranca;
    }

    /**
     * @param mixed $chave_seguranca
     * @return TransactionPaymentBoletoBradescoService
     */
    public function setChaveSeguranca($chave_seguranca)
    {
        $this->chave_seguranca = $chave_seguranca;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPedido()
    {
        return $this->pedido;
    }

    /**
     * @param PedidoBradescoShopFacilService $pedido
     * @return $this
     */
    public function setPedido(PedidoBradescoShopFacilService $pedido)
    {
        $this->pedido = $pedido;
        return $this;
    }

    /**
     * @return CompradorBradescoShopFacilService
     */
    public function getComprador() : CompradorBradescoShopFacilService
    {
        return $this->comprador;
    }

    /**
     * @param CompradorBradescoShopFacilService $comprador
     * @return $this
     */
    public function setComprador(CompradorBradescoShopFacilService $comprador)
    {
        $this->comprador = $comprador;
        return $this;
    }

    /**
     * @return BoletoBradescoShopFacilService
     */
    public function getBoleto() : BoletoBradescoShopFacilService
    {
        return $this->boleto;
    }

    /**
     * @param BoletoBradescoShopFacilService $boleto
     * @return $this
     */
    public function setBoleto(BoletoBradescoShopFacilService $boleto)
    {
        $this->boleto = $boleto;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTokenRequestConfirmacaoPagamento()
    {
        return $this->token_request_confirmacao_pagamento;
    }

    /**
     * @param mixed $token_request_confirmacao_pagamento
     * @return TransactionPaymentBoletoBradescoService
     */
    public function setTokenRequestConfirmacaoPagamento($token_request_confirmacao_pagamento)
    {
        $this->token_request_confirmacao_pagamento = $token_request_confirmacao_pagamento;
        return $this;
    }

    /**
     * @param string $environment
     * @param AuthBasic $authBasic
     * @return mixed|\Psr\Http\Message\ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Exception
     */
    public function sendRequestTransaction(string $environment, AuthBasic $authBasic)
    {
        $this->setPedido($this->pedidoBradescoShopFacilService);
        $this->setComprador($this->compradorBradescoShopFacilService->setEndereco(
            $this->enderecoBradescoShopFacilService
        ));
        $this->setBoleto($this->boletoBradescoShopFacilService->setRegistro(
            $this->registroBoletoBradescoShopFacilService
        ));

        $data = [
            "merchant_id"                           => $this->getMerchantId(),
            "meio_pagamento"                        => "300",
            "pedido"                                => $this->getPedido()->getDataServicePedido(),
            "comprador"                             => $this->getComprador()->getDataCompradorService(),
            "boleto"                                => $this->getBoleto()->getDataServiceBoleto(),
            "token_request_confirmacao_pagamento"   => $this->getTokenRequestConfirmacaoPagamento()
        ];

        try {
            $response = $this->bradescoShopFacilRepository->initTransactionPayment($environment, $data, $authBasic);
        } catch (\Exception $exception) {
            throw new \Exception($exception->getMessage());
        }

        return $response;
    }
}