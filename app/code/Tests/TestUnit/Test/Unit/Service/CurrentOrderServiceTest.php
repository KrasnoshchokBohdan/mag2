<?php

namespace Tests\TestUnit\Test\Unit\Service;

use Magento\Framework\Exception\NoSuchEntityException;
use Tests\TestUnit\Service\CurrentOrderService;
use PHPUnit\Framework\TestCase;
use Magento\Sales\Api\OrderRepositoryInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Sales\Api\Data\OrderInterface;

class CurrentOrderServiceTest extends TestCase
{

    /**
     * @return void
     */
    public function testGetCurrentOrderException()
    {
        $orderRepository = $this->getMockBuilder(OrderRepositoryInterface::class)
            ->disableOriginalConstructor()
            ->setMethods(['get'])
            ->getMockForAbstractClass();

        $exception = new NoSuchEntityException();

        $orderRepository->expects($this->once())
            ->method('get')
            ->will($this->throwException($exception));

        $request = $this->getMockBuilder(RequestInterface::class)
            ->disableOriginalConstructor()
            ->setMethods(['getParam'])
            ->getMockForAbstractClass();

        $request->expects($this->once())
            ->method('getParam')
            ->with('order_id');

        $object = new CurrentOrderService($orderRepository, $request);

        $this->assertNull($object->getOrder());
    }

    public function testGetCurrentOrder()
    {
        $orderId = 10;

        $order = $this->getMockBuilder(OrderInterface::class)
            ->disableOriginalConstructor()
            ->getMockForAbstractClass();

        $orderRepository = $this->getMockBuilder(OrderRepositoryInterface::class)
            ->disableOriginalConstructor()
            ->setMethods(['get'])
            ->getMockForAbstractClass();

        $orderRepository->expects($this->once())
            ->method('get')
            ->with($orderId)
            ->willReturn($order);

        $request = $this->getMockBuilder(RequestInterface::class)
            ->disableOriginalConstructor()
            ->setMethods(['getParam'])
            ->getMockForAbstractClass();

        $request->expects($this->once())
            ->method('getParam')
            ->with('order_id')
            ->willReturn($orderId);

        $object = new CurrentOrderService($orderRepository, $request);

        $this->assertInstanceOf(OrderInterface::class, $object->getOrder());
    }

}
