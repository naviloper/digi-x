<?php
/**
 * Created by PhpStorm.
 * User: navid
 * Date: 5/15/19
 * Time: 12:14 PM
 */

class Checkout
{

    /**
     * @var array
     */
    public $shoppingBasket;

    /**
     * @var array
     */
    public $pricingRules;


    public function __construct(array $pricingRules)
    {
        $this->pricingRules = $pricingRules;
        $this->shoppingBasket = [];

    }

    /**
     * Scan and add new product to customer buying items
     * @param string $sku
     */
    public function scan(string $sku)
    {
        $this->addToShoppingBasket($sku);
    }
    
    private function addToShoppingBasket($sku, $count = 1, $discount = 0)
    {
        if(isset($this->shoppingBasket[$sku])) {
            $this->shoppingBasket[$sku]['count'] += $count;
            $this->shoppingBasket[$sku]['discount'] += $discount;
        
        } else {
            $this->shoppingBasket[$sku]['name'] = $GLOBALS['products'][$sku]['name'];
            $this->shoppingBasket[$sku]['fee'] = $GLOBALS['products'][$sku]['price'];
            $this->shoppingBasket[$sku]['count'] = $count;
            $this->shoppingBasket[$sku]['discount'] = $discount;
        }
    
        $this->shoppingBasket[$sku]['price'] =
            ($this->shoppingBasket[$sku]['count'] * $this->shoppingBasket[$sku]['fee']) - $this->shoppingBasket[$sku]['discount'];
    }

    /**
     * This method calculate total items and price and returned array has this
     * structure:
     * [
     *     items: an array of total skus of products that must deliver to customer
     *     price: total price that customer must paid
     * ]
     * @return array
     */
    public function total()
    {
        foreach ($this->pricingRules as $pricingRule) {
            
            $pricingRuleMethodName = 'pricingRule_' . $pricingRule;
            if(method_exists($this, $pricingRuleMethodName)) {
                $this->$pricingRuleMethodName();
            }
        }
        
        $totalBill = 0;
        
        // Printing BILL
        $mask = "|%-10.10s |%-20.20s | %-10.10s | %-5.5s | %-10.10s | %-15.15s | \n";
        printf("--------------------------------------------------------------------------------------- \n");
        printf($mask, 'SKU', 'Name', 'Fee', 'Count', 'Discount', 'Price');
        printf("--------------------------------------------------------------------------------------- \n");
        foreach ($this->shoppingBasket as $key => $item)
        {
            printf($mask, $key, $item['name'], $item['fee'].'$', $item['count'], $item['discount'].'$', $item['price'].'$');
            $totalBill += $item['price'];
        }
        printf("--------------------------------------------------------------------------------------- \n");
        printf("Total: $totalBill\$ \n");
        
        

    }
    
    private function pricingRule_R1()
    {
        if( isset($this->shoppingBasket['atv']))
        {
            $numberOfFreeAtv = intdiv($this->shoppingBasket['atv']['count'], 3);
            
            $this->shoppingBasket['atv']['discount'] =
                $this->shoppingBasket['atv']['fee'] * $numberOfFreeAtv;
            
            $this->shoppingBasket['atv']['price'] =
                $this->shoppingBasket['atv']['price'] - $this->shoppingBasket['atv']['discount'];
        }
    }
    
    private function pricingRule_R2()
    {
        if( isset($this->shoppingBasket['ipd']) &&
            $this->shoppingBasket['ipd']['count'] >= 4
        )
        {
            $this->shoppingBasket['ipd']['discount'] =
                ($this->shoppingBasket['ipd']['fee'] - 499.99) *  $this->shoppingBasket['ipd']['count'];
            $this->shoppingBasket['ipd']['price'] =
                $this->shoppingBasket['ipd']['price'] - $this->shoppingBasket['ipd']['discount'];
        }
    }
    
    private function pricingRule_R3()
    {
        if( isset($this->shoppingBasket['mbp']) &&
            $this->shoppingBasket['mbp']['count'] >= 1
        )
        {
            $totalVGADiscount = $GLOBALS['products']['vga']['price'] * $this->shoppingBasket['mbp']['count'];
            
            $totalVGACountToAdd = $this->shoppingBasket['mbp']['count'] - $this->shoppingBasket['vga']['count'];
            
            $totalVGACountToAdd = $totalVGACountToAdd >= 0 ? $totalVGACountToAdd : 0;
            
            $this->addToShoppingBasket('vga', $totalVGACountToAdd, $totalVGADiscount);
        }
    }
    
    



}