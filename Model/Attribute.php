<?php
namespace Space48\RangeAttributeListing\Model;

use Magento\Framework\Data\Collection\AbstractDb;
use Magento\Framework\Model\Context;
use Magento\Framework\Model\ResourceModel\AbstractResource;
use Magento\Framework\Registry;
use Magento\Framework\UrlInterface;
use Magento\Store\Model\StoreManagerInterface as Store;
use Space48\RangeAttributeListing\Helper\Data as Helper;
use Magento\Catalog\Model\Category;

class Attribute extends \Magento\Framework\Model\AbstractModel
{
    private $rangeAttributeCode;
    private $rangeCategoryUrlKey;

    /** @var \Magento\Store\Model\Store $store */
    private $store;

    /** @var \Magento\Catalog\Model\Product $product */
    private $product;

    /**
     * @var Registry
     */
    private $registry;
    /**
     * @var Category
     */
    private $category;

    /** @var  \Magento\Catalog\Model\ResourceModel\Category\Collection */
    private $rangeCategory;
    /**
     * @var Helper
     */
    private $helper;

    /**
     * Attribute constructor.
     * @param Store $store
     * @param Helper $helper
     * @param Category $category
     * @param Context $context
     * @param Registry $registry
     * @param AbstractResource|null $resource
     * @param AbstractDb|null $resourceCollection
     * @param array $data
     * @codeCoverageIgnore
     */
    public function __construct(
        Store $store,
        Helper $helper,
        Category $category,

        Context $context,
        Registry $registry,
        AbstractResource $resource = null,
        AbstractDb $resourceCollection = null,
        array $data = []
    )
    {
        parent::__construct(
            $context, $registry, $resource, $resourceCollection, $data
        );

        $this->registry = $registry;
        $this->store = $store;
        $this->category = $category;
        $this->helper = $helper;

        $this->product = $this->getProduct();
    }

    /**
     * @return string
     */
    public function getRangeCategoryProductLink()
    {
        if ($this->isRangeAttributeSelectedInProduct() && $this->isProductInRangeCategory()) {
            return $this->getRangeCategoryUrl() . '?' . $this->getRangeAttributeCode() . '=' . $this->getFilterAttributeCodeValue();
        }
    }

    /**
     * @return string
     * @codeCoverageIgnore
     */
    public function getRangeCategoryOptionText()
    {
        return $this->getProduct()->getAttributeText($this->getRangeAttributeCode());
    }

    /**
     * @return mixed
     * @codeCoverageIgnore
     */
    public function getRangeAttributeCode()
    {
        if (!$this->rangeAttributeCode) {
            $this->rangeAttributeCode = $this->helper->getRangeFilterAttributeCode();
        }
        return $this->rangeAttributeCode;
    }


    /**
     * @return array|bool|string
     * @codeCoverageIgnore
     */
    public function getFilterAttributeCodeValue()
    {
        if ($this->getProduct()) {
            return $this->getProduct()
                ->getResource()
                ->getAttributeRawValue(
                    $this->getProduct()->getId(),
                    $this->getRangeAttributeCode(),
                    $this->store->getStore()->getId()
                );
        }
    }

    /**
     * @return bool
     * @codeCoverageIgnore
     */
    public function isRangeAttributeSelectedInProduct()
    {
        if ($this->getFilterAttributeCodeValue() && $this->getRangeCategoryUrlKey()) {
            return true;
        }
    }


    /**
     * @return mixed
     * @codeCoverageIgnore
     */
    public function getBaseUrl()
    {
        return $this->store->getStore()->getBaseUrl(UrlInterface::URL_TYPE_LINK);
    }

    /**
     * @return \Magento\Catalog\Model\Product|mixed
     * @codeCoverageIgnore
     */
    public function getProduct()
    {
        if (!$this->product) {
            $this->product = $this->registry->registry('current_product');
        }
        return $this->product;
    }

    /**
     * @return array|mixed
     * @codeCoverageIgnore
     */
    public function getRangeCategoryUrlKey()
    {
        if (!$this->rangeCategoryUrlKey) {
            $this->rangeCategoryUrlKey = $this->getRangeCategory()
                ->getData('url_key');
        }
        return $this->rangeCategoryUrlKey;
    }

    /**
     * @return $this|\Magento\Catalog\Model\ResourceModel\Category\Collection
     * @codeCoverageIgnore
     */
    public function getRangeCategory()
    {
        if(!$this->rangeCategory){
            $this->rangeCategory = $this->category->getCollection()
                ->addFieldToSelect('entity_id')
                ->addFieldToSelect('url_key')
                ->addFieldToFilter('name', $this->helper->getRangeCategoryName())
                ->getFirstItem();
        }

        return $this->rangeCategory;

    }

    /**
     * @return bool
     * @codeCoverageIgnore
     */
    public function isProductInRangeCategory()
    {
        $categoriesForProduct = $this->product->getCategoryIds();
        if (in_array($this->getRangeCategory()->getId(),$categoriesForProduct)){
            return true;
        }
        
        return false;
    }

    /**
     * @return string
     * @codeCoverageIgnore
     */
    public function getRangeCategoryUrl()
    {
        return $this->getBaseUrl() . $this->getRangeCategoryUrlKey() . '.html';
    }
}