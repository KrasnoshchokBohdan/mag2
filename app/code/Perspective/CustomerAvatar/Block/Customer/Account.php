<?php

namespace Perspective\CustomerAvatar\Block\Customer;

use Magento\Backend\Block\Template\Context;
use Magento\Customer\Model\SessionFactory;
use Magento\Framework\View\Element\Template;

use Perspective\CustomerAvatar\Model\MediaCustomerPath;

class Account extends Template
{
    /**
     * @var MediaCustomerPath
     */
    private $mediaCustomerPath;

    /**
     * @param \Perspective\CustomerAvatar\Model\MediaCustomerPath $mediaCustomerPath
     * @param \Magento\Backend\Block\Template\Context $context
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
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getFileUrl(): string
    {
        return $this->mediaCustomerPath->getMediaCustomerFilePath();
    }
}
