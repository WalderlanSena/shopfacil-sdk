<?php
/**
 * Created by PhpStorm.
 * User: Walderlan Sena <senawalderlan@gmail.com>
 * Date: 24/10/18
 * Time: 10:15
 */

namespace Mvs\ShopFacilSdk\Repository;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Mvs\ShopFacilSdk\Service\AuthBasic;

class BradescoShopFacilRepository
{
    /**
     * @param $environment
     * @param $data
     * @param AuthBasic $authBasic
     * @return mixed|\Psr\Http\Message\ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Exception
     */
    public function initTransactionPayment($environment, $data, AuthBasic $authBasic)
    {
        $client = new Client();

        try {
            $response = $client->request('POST',$environment.'/transacao',[
                'headers' => [
                    'Content-Type'      => 'application/json',
                    'Accept'            => 'application/json',
                    'Accept-Encoding'   => 'application/json',
                    'Authorization'     => $authBasic->generateToken()
                ],
                'json' => $data
            ]);
        } catch (ClientException $exception) {
            if ($exception->getResponse()->getStatusCode() != 201) {
                throw new \Exception('Não foi possível gerar o boleto.');
            }
            $response = \GuzzleHttp\json_decode($exception->getResponse()->getBody()->getContents() ?? []);
            throw new \Exception($response->status->detalhes, $exception->getCode());
        }

        $response = \GuzzleHttp\json_decode($response->getBody()->getContents());
        return $response;
    }
}