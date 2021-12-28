<?php

namespace Avatar\CustomerAvatar\Block\Customer;

use Magento\Backend\Block\Template\Context;
use Magento\Customer\Model\SessionFactory;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\View\Element\Template;

use Avatar\CustomerAvatar\Model\MediaCustomerPath;

class Account extends Template
{
    /**
     * @var MediaCustomerPath
     */
    private $mediaCustomerPath;

    /**
     * @param MediaCustomerPath $mediaCustomerPath
     * @param Context $context
     * @param array $data
     */
    public function __construct(
        MediaCustomerPath $mediaCustomerPath,
        Context $context,
        array $data = []
    ) {
        $this->mediaCustomerPath = $mediaCustomerPath;
        parent::__construct($context, $data);
    }

    /**
     * @return string
     * @throws NoSuchEntityException
     */
    public function getFileUrl(): string
    {
        return $this->mediaCustomerPath->getMediaCustomerFilePath();
    }
}
