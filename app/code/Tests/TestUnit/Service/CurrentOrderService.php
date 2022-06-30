<?php

namespace Tests\TestUnit\Service;

use Magento\Framework\App\RequestInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Sales\Api\Data\OrderInterface;
use Magento\Sales\Api\OrderRepositoryInterface;

class CurrentOrderService
{
    /**
     * @var OrderRepositoryInterface
     */
    private OrderRepositoryInterface $orderRepository;

    /**
     * @var RequestInterface
     */
    private RequestInterface $request;

    /**
     * @param OrderRepositoryInterface $orderRepository
     * @param RequestInterface $request
     */
    public function __construct(
        OrderRepositoryInterface $orderRepository,
        RequestInterface             $request
    ) {
        $this->orderRepository = $orderRepository;
        $this->request = $request;
    }

    /**
     * @return OrderInterface|null/null
     */
    public function getOrder(): ?OrderInterface
    {
        try {
            return $this->orderRepository->get($this->request->getParam('order_id'));
        } catch (NoSuchEntityException $exception) {
            return null;
        }
    }
}
