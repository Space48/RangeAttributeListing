<?php
namespace Space48\RangeAttributeListing\Test\Unit\Model;

use Magento\Catalog\Model\Product;


class AttributeTest extends \PHPUnit_Framework_TestCase
{
    protected $objectManager;
    protected $attribute;
    protected $product;
    
    protected function setUp()
    {
        $this->attribute = $this->getMockBuilder('Space48\RangeAttributeListing\Model\Attribute')
            ->disableOriginalConstructor()
            ->setMethods(array('getProduct','getRangeCategoryUrlKey', 'getBaseUrl', 'isProductInRangeCategory', 'getFilterAttributeCodeValue', 'getRangeAttributeCode'))
            ->getMock();
        $this->product = $this->getMockBuilder('Magento\Catalog\Model\Product')
            ->disableOriginalConstructor()
            ->getMock();

        $this->attribute->method('getRangeCategoryUrlKey')->willReturn('range');
        $this->attribute->method('getRangeAttributeCode')->willReturn('range_filter');
        $this->attribute->method('getBaseUrl')->willReturn('https://partyshowroom.com/');
        $this->attribute->method('getProduct')->willReturn($this->product);
        

        
    }
    public function testItReturnsFalseWhenNoRangeAttributeSetAndProductInCategory()
    {
        $this->attribute->method('getFilterAttributeCodeValue')->willReturn('');
        $this->attribute->method('isProductInRangeCategory')->willReturn(true);

        $this->assertEmpty($this->attribute->getRangeCategoryProductLink());
        $this->assertTrue($this->attribute->isProductInRangeCategory());
    }
    
    
    public function testItReturnsTrueWhenARangeAttributeSetAndProductInCategory()
    {
        $this->attribute->method('getFilterAttributeCodeValue')->willReturn('223');
        $this->attribute->method('isProductInRangeCategory')->willReturn(true);
        
        $this->assertContains('http', $this->attribute->getRangeCategoryProductLink()) ;
        $this->assertTrue($this->attribute->isProductInRangeCategory());
        
    }

    public function testItReturnsFalseWhenNoRangeAttributeSetAndNoProductInCategory()
    {
        $this->attribute->method('getFilterAttributeCodeValue')->willReturn('');
        $this->attribute->method('isProductInRangeCategory')->willReturn(false);

        $this->assertEmpty($this->attribute->getRangeCategoryProductLink());
        $this->assertFalse($this->attribute->isProductInRangeCategory());
    }

    public function testItReturnsFalseWhenRangeAttributeSetAndNoProductInCategory()
    {
        $this->attribute->method('getFilterAttributeCodeValue')->willReturn('');
        $this->attribute->method('isProductInRangeCategory')->willReturn(false);

        $this->assertEmpty($this->attribute->getRangeCategoryProductLink());
        $this->assertFalse($this->attribute->isProductInRangeCategory());
    }
    

}