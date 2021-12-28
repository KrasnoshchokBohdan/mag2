<?php

namespace Avatar\CustomerAvatar\Model;

use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Customer\Helper\Session\CurrentCustomer;
use Magento\Customer\Model\Data\Customer;
use Magento\Framework\Exception\InputException;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Exception\State\InputMismatchException;
use Magento\Framework\UrlInterface;
use Magento\Store\Model\StoreManagerInterface;

class MediaCustomerPath
{
    /**
     * @var CurrentCustomer
     */
    private $currentCustomer;
    /**
     * @var StoreManagerInterface
     */
    private $storeManager;
    /**
     * @var CustomerRepositoryInterface
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
     * @throws NoSuchEntityException
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
        return sprintf("%s%s%s", $urlMedia, 'customer', $file);
    }

    /**
     * @param Customer $customer
     * @param string $picture
     * @throws InputException
     * @throws LocalizedException
     * @throws InputMismatchException
     */
    public function setPicture(Customer $customer, string $picture): void
    {
        $customer->setCustomAttribute('profile_picture', $picture);
        $this->customerRepositoryInterface->save($customer);
    }
}
