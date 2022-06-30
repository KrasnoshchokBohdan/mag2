<?php

namespace Training\PoolPattern\ViewModel;

use http\Exception\InvalidArgumentException;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\View\Element\Block\ArgumentInterface;
use Training\PoolPattern\Model\CodeValidationPool;

class Example implements ArgumentInterface
{
    /**
     * @var CodeValidationPool
     */
    protected CodeValidationPool $codeValidationPool;

    /**
     * @param CodeValidationPool $codeValidationPool
     */
    public function __construct(CodeValidationPool $codeValidationPool)
    {
        $this->codeValidationPool = $codeValidationPool;
    }

    /**
     * @param RequestInterface $request
     * @return string
     */
    public function getCode(RequestInterface $request): string
    {
        $code = (string)$request->getParam('code');
        $this->codeValidationPool->validate($code);
        return $code;
    }
}
