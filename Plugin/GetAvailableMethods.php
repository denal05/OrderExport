<?php

namespace SwiftOtter\OrderExport\Plugin;

use Magento\Payment\Model\MethodList;
use Psr\Log\LoggerInterface;
use Magento\Framework\Message\ManagerInterface as MessageManager;

class GetAvailableMethods
{
    private $debug;
    private $messageManager;
    private $logger;

    public function __construct(
        MessageManager $mm,
        LoggerInterface $l
    ) {
        $this->messageManager = $mm;
        $this->logger = $l;
    }

    public function afterGetAvailableMethods(
        MethodList $subject,
        $result,
        \Magento\Quote\Api\Data\CartInterface $quote = null
    ) {
        $debug = true;
        try
        {
            $message = "Customer Email: " . $quote->getCustomer()->getEmail();

            $this->messageManager->addNoticeMessage($message);

            $zendLogWriter = new \Zend\Log\Writer\Stream(BP . '/var/log/SwiftOtter_OrderExport_Plugin_GetAvailableMethods.log');
            $zendLogLogger = new \Zend\Log\Logger();
            $zendLogLogger->addWriter($zendLogWriter);
            if ($debug) { $zendLogLogger->info('------------------------------------------'); }
            if ($debug) { $zendLogLogger->info($message); }

        } catch (\Exception $e) {
            $this->logger->error($e->getMessage());
        }

        return $result;
    }
}