<?php
namespace Space48\RangeAttributeListing\Setup;

use Magento\Catalog\Model\Product;
use Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface;
use Magento\Eav\Setup\EavSetup;

use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Space48\RangeAttributeListing\Helper\Data;


class InstallData implements InstallDataInterface
{
    private $eavSetup;
    private $helper;
    private $rangeFilterCode;

    public function __construct(
        EavSetup $eavSetup,
        Data $helper
    )
    {
        $this->eavSetup = $eavSetup;
        $this->helper = $helper;
        $this->rangeFilterCode = $this->helper->getRangeFilterAttributeCode();
    }

    public function install(ModuleDataSetupInterface $setup,
                            ModuleContextInterface $context)
    {
        if ($this->rangeFilterCode) {
            $setup->startSetup();
            $this->eavSetup->addAttribute(Product::ENTITY, $this->rangeFilterCode, [
                'type' => 'int',
                'label' => 'Range',
                'input' => 'select',
                'required' => false,
                'sort_order' => 3,
                'source' => '',
                'backend' => 'Magento\Eav\Model\Entity\Attribute\Backend\ArrayBackend',
                'global' => ScopedAttributeInterface::SCOPE_GLOBAL,
                'filterable_in_search' => '1',
                'used_in_product_listing' => true,
                'visible_on_front' => true,
                'searchable' => '1',
                'filterable' => '1',
                'option' =>
                    array(
                        'values' =>
                            array(
                                0 => 'Marvel',
                                1 => 'Ben 10',
                                2 => 'My Little Pony',
                            ),
                    ),
            ]);
            $setup->endSetup();
        } else {
            throw new \Exception('no range code supplied');
        }
    }

} 