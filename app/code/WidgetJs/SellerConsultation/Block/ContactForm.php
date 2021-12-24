<?php

/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 * Php version 7.4
 * 
 * @category Some_Category
 * @package  Some_Package
 * @author   Display Name <someusername@example.com>
 * @license  some license
 * @link     some link
 */

namespace WidgetJs\SellerConsultation\Block;

use Magento\Framework\DataObject;

/**
 *  Short description
 *
 * @category   Some_Category
 * @package    Some_Package
 * @author     Display Name <someusername@example.com>
 * @license    some license
 * @link       some link
 * @since      00.00.00
 * @deprecated Some_deprecated
 * @api
 */
class ContactForm extends \Magento\Framework\View\Element\Template
{
    /**
     * Registry collection
     *
     * @var object
     */
    protected $registry;
    /**
     * Registry collection
     *
     * @var object
     */
    protected $helper;
    /**
     * MailInterface
     * 
     * @var MailInterface
     */
    protected $mail;


    /**
     * Index constructor
     * 
     * @param \Magento\Backend\Block\Template\Context       $context  context
     * @param \Magento\Framework\Registry                   $registry registry
     * @param \WidgetJs\SellerConsultation\Helper\SendEmail $helper   helper
     * @param \Magento\Contact\Model\MailInterface          $mail     mail
     * @param array<mixed>                                   $data     data
     * 
     * @some(some)
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Registry $registry,
        \WidgetJs\SellerConsultation\Helper\SendEmail $helper,
        \Magento\Contact\Model\MailInterface $mail,
        array $data = []
    ) {
        $this->helper = $helper;
        $this->registry = $registry;
        $this->mail = $mail;
        parent::__construct($context, $data);
    }

    /** 
     * Get current product
     * 
     * @return Object
     */
    public function getCurrentProduct()
    {
        $currentProduct = $this->registry->registry('current_product');
        return $currentProduct;
    }


    /**
     * Returns action url for contact form
     *
     * @return string
     */
    public function getFormAction()
    {
        $productUrl = $this->getCurrentProduct()->getProductUrl();
        $url = str_replace('http://mag2.com/', '', $productUrl);
        return $this->getUrl($url, ['_secure' => true]);
    }

    /**
     * Validated Params
     *
     * @return mixed
     */
    public function validatedParams()
    {
        $request = $this->getRequest();
        if (trim($request->getParam('name')) === '' || strlen($request->getParam('name')) > 15) {
            return (__('Enter the Name and try again (name must contain no more than 15 characters).'));
        }

        if (trim($request->getParam('comment')) === '') {
            return (__('Enter the comment and try again.'));
        }
        if (false === \strpos($request->getParam('email'), '@') || preg_match("/[А-Яа-я]/", $request->getParam('email')) !== 0) {
            return (__('The email address is invalid. Verify the email address and try again (invalid characters found).'));
        }
        if (trim($request->getParam('hideit')) !== '') {
            return ' ';
        }
        $pattern = "/^\+380\d{3}\d{2}\d{2}\d{2}$/";
        $telephoneData = preg_match($pattern, $request->getParam('telephone'));
        $telephoneOperator = substr($request->getParam('telephone'), 3, 3);
        $arrOperators = ['095', '099', '066', '068', '050'];
        $res = in_array($telephoneOperator, $arrOperators);
        if (trim($request->getParam('telephone')) === '' || $telephoneData === 0 || $res !== true) {
            return (__('Enter the phone number and try again (incorrect phone format).'));
        }

        return null;
    }
    /**
     * Get Name
     *
     * @return mixed
     */
    public function getName()
    {
        $request = $this->getRequest();
        if ($request->getParam('name')) {
            return $request->getParam('name');
        }
        return null;
    }

    /**
     * Get Email
     *
     * @return mixed
     */
    public function getEmail()
    {
        $request = $this->getRequest();
        if ($request->getParam('email')) {
            return $request->getParam('email');
        }
        return null;
    }

    /**
     * Get Telephone
     *
     * @return mixed
     */
    public function getTelephone()
    {
        $request = $this->getRequest();
        if ($request->getParam('telephone')) {
            return $request->getParam('telephone');
        }
        return null;
    }

    /**
     * Get Comment
     *
     * @return mixed
     */
    public function getComment()
    {
        $request = $this->getRequest();
        if ($request->getParam('comment')) {
            return $request->getParam('comment');
        }
        return null;
    }

    /**
     * Send Email
     * 
     * @param array $post Post data from contact form
     * @return void
     */
    public function sendEmail($post)
    {
        $this->mail->send(
            $post['email'],
            ['data' => new DataObject($post)]
        );
    }


    /**
     * Try to send Email
     *
     * @return mixed
     */
    public function sendTry()
    {
        $request = $this->getRequest();
        $param = $request->getParams();
        return  $this->sendEmail($param);
    }
}
