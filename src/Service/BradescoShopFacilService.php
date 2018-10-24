<?php
/**
 * Created by PhpStorm.
 * User: Walderlan Sena <senawalderlan@gmail.com>
 * Date: 23/10/18
 * Time: 11:46
 */

namespace Mvs\ShopFacilSdk\Service;

class BradescoShopFacilService
{
    private $environment;
    private $bradescoShopFacilRepository;

    public function __construct(BradescoShopFacilRepositoryInterface $bradescoShopFacilRepository)
    {
        $this->getConfig();
        $this->bradescoShopFacilRepository = $bradescoShopFacilRepository;
    }

    public function getConfig()
    {
        $this->environment = require_once  __DIR__ .'/../../config/bradesco.shopfacil.config.php';
    }

    /**
     * @param string $environment
     * @return mixed|void
     * @throws \Exception
     */
    public function iniciarTrasacaoDePagamento(string $environment)
    {
        if (in_array($this->environment, $this->environment)) {
            throw new EnvironmentNotFound('O ambiente solicitado não existe !');
        }

        try {
            $response = $this->bradescoShopFacilRepository->iniciarTrasacaoDePagamento($this->environment);
        } catch (\Exception $exception) {
            throw new \Exception($exception->getMessage());
        }

        var_dump($response);
    }
}