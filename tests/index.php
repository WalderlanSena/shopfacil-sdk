<?php
/**
 * Created by PhpStorm.
 * User: Walderlan Sena <senawalderlan@gmail.com>
 * Date: 24/10/18
 * Time: 10:21
 */

namespace Mvs\ShopFacilSdk\Tests;

use Mvs\ShopFacilSdk\Repository\BradescoShopFacilRepository;
use Mvs\ShopFacilSdk\Service\AuthBasic;
use Mvs\ShopFacilSdk\Service\BoletoBradescoShopFacilService;
use Mvs\ShopFacilSdk\Service\CompradorBradescoShopFacilService;
use Mvs\ShopFacilSdk\Service\EnderecoBradescoShopFacilService;
use Mvs\ShopFacilSdk\Service\PedidoBradescoShopFacilService;
use Mvs\ShopFacilSdk\Service\RegistroBoletoBradescoShopFacilService;
use Mvs\ShopFacilSdk\Service\TransactionPaymentBoletoBradescoService;

require_once __DIR__ .'/../vendor/autoload.php';

$pedido = new PedidoBradescoShopFacilService();
$pedido->setValor(75)
       ->setNumero('87681276876')
       ->setDescricao('Ó a descrição');

$endereco = new EnderecoBradescoShopFacilService();
$endereco->setCidade('Ó a cidade')
         ->setNumero('2256')
         ->setLogradouro('Ó o logradouro')
         ->setUf('CE')
         ->setCep('60421103')
         ->setBairro('Ó o bairro')
         ->setComplemento('Ó o complemento');

$comprador = new CompradorBradescoShopFacilService();
$comprador->setDocumento('38604763007')
          ->setNome('Ó o nome')
          ->setUserAgent($_REQUEST)
          ->setIp('127.0.0.1')
          ->setEndereco($endereco);

$boleto = new BoletoBradescoShopFacilService();
$boleto->setBeneficiario('Nome do Beneficiario')
       ->setCarteira('0897897')
       ->setNossoNumero('13123312')
       ->setCarteira('25')
       ->setDataEmissao((new \DateTime())->format('Y-m-d'))
       ->setDataVencimento((new \DateTime())->format('Y-m-d'))
       ->setValorTitulo(7657)
       ->setUrlLogotipo('http://via.placeholder.com/120x80')
       ->setMensagemCabecalho('Ó a mensagem de cabecalho')
       ->setTipoRenderizacao('2');

$registro = new RegistroBoletoBradescoShopFacilService();

$app = new TransactionPaymentBoletoBradescoService(
    new BradescoShopFacilRepository(),
    $pedido,
    $comprador,
    $endereco,
    $boleto,
    $registro
);

try {
    $response = $app->setMerchantId('[ SEU MERCHANT_ID ]')
                    ->setEmail('[ SEU EMAIL ]')
                    ->setTokenRequestConfirmacaoPagamento('[ TOKEN DE NOTIFICAÇÃO QUE SERÁ ENVIADO PARA A URL CONFIGURADO NO PAINEL]')
                    ->setChaveSeguranca('[ SUA CHAVE DE SEGURANÇA ]')
                    ->setPedido($pedido)
                    ->setComprador($comprador)
                    ->setBoleto($boleto)
                    ->sendRequestTransaction($app::ENVIRONMENT_DEV, new AuthBasic($app));
} catch (\Exception $exception) {
    throw new \Exception($exception->getMessage());
}

var_dump($response);