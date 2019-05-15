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
        if(isset($shoppingBasket[$sku])) {

        } else {

        }
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

    }



}