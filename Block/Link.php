<?php
namespace Space48\RangeAttributeListing\Block;

use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Space48\RangeAttributeListing\Model\Attribute;
use Space48\RangeAttributeListing\Helper\Data as Helper;

class Link extends Template
{
    private $attribute;
    private $helper;

    public function __construct(
        Context $context,
        Attribute $attribute,
        Helper $helper,
        array $data = []
    )
    {
        parent::__construct($context, $data);
        $this->attribute = $attribute;
        $this->helper = $helper;
    }


    /**
     * @return string
     * @codeCoverageIgnore
     */
    public function getRangeCategoryProductLink()
    {
        return $this->attribute->getRangeCategoryProductLink();
    }

    /**
     * @return string
     * @codeCoverageIgnore
     */
    public function getRangeCategoryOptionText()
    {
       return $this->attribute->getRangeCategoryOptionText();
    }
    


}