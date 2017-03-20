<?php
namespace Space48\RangeAttributeListing\Setup;

use Magento\Framework\Setup\UpgradeDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Eav\Setup\EavSetup;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Catalog\Model\Product;

/**
 * Upgrade Data script
 * @codeCoverageIgnore
 */
class UpgradeData implements UpgradeDataInterface
{

    /**
     * EAV setup factory
     *
     * @var EavSetupFactory
     */
    private $eavSetupFactory;

    private $eavSetup;

    private $attributeCode = 'range_filter';


    /**
     * UpgradeData constructor.
     * @param EavSetupFactory $eavSetupFactory
     */
    public function __construct(EavSetupFactory $eavSetupFactory)
    {
        $this->eavSetupFactory = $eavSetupFactory;
    }

    /**
     * @param ModuleDataSetupInterface $setup
     * @param ModuleContextInterface $context
     */
    public function upgrade(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();

        $dbVersion = $context->getVersion();
        /** @var EavSetup $eavSetup */
        $this->eavSetup = $this->eavSetupFactory->create(['setup' => $setup]);

        if ( $context->getVersion() && version_compare($dbVersion, '0.0.2') < 0 ) {

            $this->eavSetup->updateAttribute(Product::ENTITY, $this->attributeCode, 'is_user_defined', 1);
        }


        $setup->endSetup();
    }
}
