<?php
//@codingStandardsIgnoreStart
namespace City\Definition\Controller\Index;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use City\Definition\Block\Link;

class Index extends Action
{
    /**
     * @var Link
     */
    protected $block;

    /**
     * @param Link $block
     * @param Context $context
     */
    public function __construct(
        Link    $block,
        Context $context

    ) {
        $this->block = $block;
        parent::__construct($context);
    }

    public function execute()
    {
        $post = $this->getRequest()->getParams();
        $test = $post['content']['0']['value'];

        try {

            $this->messageManager->addSuccess(__('Thank you!'));
        } catch (\Magento\Framework\Exception\LocalizedException $e) {
            $this->messageManager->addError($e->getMessage());
        } catch (\RuntimeException $e) {
            $this->messageManager->addError($e->getMessage());
        } catch (\Exception $e) {
            $this->messageManager->addException($e, __('Something went wrong . '));
        }
    }
}

