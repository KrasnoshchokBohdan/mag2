<?php

namespace Avatar\CustomerAvatar\Plugin\CustomerData;

use Magento\Customer\CustomerData\Customer;
use Magento\Customer\Helper\Session\CurrentCustomer;
use Avatar\CustomerAvatar\Model\MediaCustomerPath;
use Magento\Framework\Exception\NoSuchEntityException;

class AddFrontAvatar
{
    /**
     * @var CurrentCustomer
     */
    protected $currentCustomer;
    /**
     * @var MediaCustomerPath
     */
    private $mediaCustomerPath;

    public function __construct(
        MediaCustomerPath $mediaCustomerPath,
        CurrentCustomer $currentCustomer
    ) {
        $this->currentCustomer = $currentCustomer;
        $this->mediaCustomerPath = $mediaCustomerPath;
    }

    /**
     * @param Customer $subject
     * @param array $result
     * @return array
     * @throws NoSuchEntityException
     */
    public function afterGetSectionData(Customer $subject, array $result): array
    {
        if (!$this->currentCustomer->getCustomerId()) {
            return $result;
        }

        $filePath = $this->mediaCustomerPath->getMediaCustomerFilePath();

        if ($filePath != '') {
            $result['avatar'] = $filePath;
        }

        return $result;
    }
}
