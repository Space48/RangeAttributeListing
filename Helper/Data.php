<?php
namespace Space48\RangeAttributeListing\Helper;

use Magento\Framework\App\Config;
use Magento\Framework\App\Helper\Context;

class Data extends \Magento\Framework\App\Helper\AbstractHelper
{
    /**
     * @var Config
     */
    private $config;

    public function __construct(
        Context $context,
        Config $config
    )
    {
        parent::__construct($context);

        $this->config = $config;
    }


    /**
     * @return mixed
     * @codeCoverageIgnore
     */
    public function getRangeFilterAttributeCode()
    {
        return $this->config->getValue('range_filter_attribute_code');
    }

    /**
     * @return mixed
     * @codeCoverageIgnore
     */
    public function getRangeCategoryName()
    {
        return $this->config->getValue('range_category_name');
    }
    

}