<?php

namespace Learning\Currency\Pricing;

use Magento\Framework\Pricing\SaleableInterface;

/**
 * Base price render
 *
 * @api
 * @method string getPriceRenderHandle()
 *
 * @api
 */
class Render extends \Magento\Framework\Pricing\Render
{
    /**
     * Render price
     *
     * @param string $priceCode
     * @param SaleableInterface $saleableItem
     * @param array $arguments
     * @return string
     * @throws \InvalidArgumentException
     * @throws \RuntimeException
     */
    public function render($priceCode, SaleableInterface $saleableItem, array $arguments = [])
    {
        $useArguments = array_replace($this->_data, $arguments);

        /** @var \Magento\Framework\Pricing\Render\RendererPool $rendererPool */
        $rendererPool = $this->priceLayout->getBlock('render.product.prices.custom');
        if (!$rendererPool) {
            throw new \RuntimeException('Wrong Price Rendering layout configuration. Factory block is missed');
        }

        // obtain concrete Price Render
        $priceRender = $rendererPool->createPriceRender($priceCode, $saleableItem, $useArguments);
        return $priceRender->toHtml();
    }
}
