<?php

namespace Perspective\CustomerAvatar\Model;

use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Customer\Helper\Session\CurrentCustomer;
use Magento\Customer\Model\Data\Customer;
use Magento\Framework\UrlInterface;
use Magento\Store\Model\StoreManagerInterface;

class MediaCustomerPath
{
    /**
     * @var \Magento\Customer\Helper\Session\CurrentCustomer
     */
    private $currentCustomer;
    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    private $storeManager;
    /**
     * @var \Magento\Customer\Api\CustomerRepositoryInterface
     */
    private $customerRepositoryInterface;

    public function __construct(
        CustomerRepositoryInterface $customerRepositoryInterface,
        CurrentCustomer $currentCustomer,
        StoreManagerInterface $storeManager
    ) {
        $this->customerRepositoryInterface = $customerRepositoryInterface;
        $this->currentCustomer = $currentCustomer;
        $this->storeManager = $storeManager;
    }

    /**
     * @return string
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getMediaCustomerFilePath(): string
    {
        $customer = $this->currentCustomer->getCustomer();
        if (!empty($customer->getCustomAttribute('profile_picture'))) {
            $file = $customer->getCustomAttribute('profile_picture')->getValue();
        } else {
            return '';
        }

        $urlMedia = $this->storeManager->getStore()->getBaseUrl(UrlInterface::URL_TYPE_MEDIA);
 //       $urlMedia = 'http://mag2.com/pub/media/';

  //      $debug = sprintf("%s%s%s", $urlMedia, 'customer', $file);

        return sprintf("%s%s%s", $urlMedia, 'customer', $file);
    }

    /**
     * @param \Magento\Customer\Model\Data\Customer $customer
     * @param string $picture
     * @throws \Magento\Framework\Exception\InputException
     * @throws \Magento\Framework\Exception\LocalizedException
     * @throws \Magento\Framework\Exception\State\InputMismatchException
     */
    public function setPicture(Customer $customer, string $picture): void
    {
        $customer->setCustomAttribute('profile_picture', $picture);
        $this->customerRepositoryInterface->save($customer);
    }
}
