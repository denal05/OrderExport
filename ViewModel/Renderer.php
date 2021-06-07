<?php
declare(strict_types=1);

namespace SwiftOtter\OrderExport\ViewModel;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\View\Element\Block\ArgumentInterface;
use Magento\Store\Model\StoreManagerInterface;

class Renderer implements ArgumentInterface
{
    private $scopeConfig;

    public function __construct(
        ScopeConfigInterface $scopeConfigInterface
    )
    {
        $this->scopeConfig = $scopeConfigInterface;
    }

    public function getStoreAddress()
    {
        $importCompany = $this->scopeConfig->getValue(
            'general/store_information/phone'
        );

        return $importCompany;
    }
}
