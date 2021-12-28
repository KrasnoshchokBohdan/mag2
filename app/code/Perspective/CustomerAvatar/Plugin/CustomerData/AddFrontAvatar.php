<?php

namespace Perspective\CustomerAvatar\Plugin\CustomerData;

use Magento\Customer\CustomerData\Customer;
use Magento\Customer\Helper\Session\CurrentCustomer;
use Perspective\CustomerAvatar\Model\MediaCustomerPath;

class AddFrontAvatar
{
    /**
     * @var \Magento\Customer\Helper\Session\CurrentCustomer
     */
    protected $currentCustomer;
    /**
     * @var \Perspective\CustomerAvatar\Model\MediaCustomerPath
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
     * @param \Magento\Customer\CustomerData\Customer $subject
     * @param array $result
     * @return array
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function afterGetSectionData(Customer $subject, array $result): array
    {
        if (!$this->currentCustomer->getCustomerId()) {
            return $result;
        }

        $filePath = $this->mediaCustomerPath->getMediaCustomerFilePath();

   //     $filePath = "http://mag2.com/pub/media/sk_profile_pic/1/686c57e20da2069163313919a204aaa8.jpg";

        if ($filePath != '') {
            $result['avatar'] = $filePath;
        }

        return $result;
    }
}
