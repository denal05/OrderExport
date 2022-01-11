<?php

namespace SwiftOtter\OrderExport\Observer;

use Magento\Framework\Message\ManagerInterface as MessageManager;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Tax\Model\ClassModel as TaxClassModel;
use Magento\Tax\Model\ResourceModel\TaxClass\CollectionFactory as TaxClassCollectionFactory;

class DisplayTaxClassAfterLoadingCatalogProduct implements \Magento\Framework\Event\ObserverInterface
{
    private $messageManager;
    private $productRepo;
    private $taxClassCollection;

    public function __construct(
        MessageManager $mm,
        ProductRepositoryInterface $pri,
        TaxClassCollectionFactory $tccf
    )
    {
        $this->messageManager = $mm;
        $this->productRepo = $pri;
        $this->taxClassCollection = $tccf->create();
    }

    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        // TODO: Implement execute() method.
        try {
            /** @var TaxClassModel $taxClass */
            $this->taxClassCollection->addFieldToFilter('class_type', TaxClassModel::TAX_CLASS_TYPE_PRODUCT);
            $taxClass = $this->taxClassCollection->getFirstItem();

            $this->messageManager->addNoticeMessage("DisplayTaxClassAfterLoadingCatalogProduct::execute(): ...");
            return $this;
        } catch (\Exception $e) {
            echo <<<HTML
<pre>
{$e->getMessage()}
</pre>
HTML;
            return $this;
        }
    }
}