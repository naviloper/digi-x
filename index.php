<?php
include_once 'Checkout.php';

/**
 * Created by PhpStorm.
 * User: navid
 * Date: 5/15/19
 * Time: 12:45 PM
 */

$GLOBALS["products"] = [

    'ipd' => [
        'name' => 'Super iPad',
        'price' => 549.99
    ],

    'mbp' => [
        'name' => 'MacBook Pro',
        'price' => 1399.99
    ],

    'atv' => [
        'name' => 'Apple TV',
        'price' => 109.50
    ],

    'vga' => [
        'name' => 'VGA adapter',
        'price' => 30.00
    ]
];

$co = new Checkout(['R1', 'R2', 'R3']);

$co->scan('atv');
$co->scan('atv');
$co->scan('atv');
$co->scan('vga');

//$co->scan('atv');
//$co->scan('ipd');
//$co->scan('ipd');
//$co->scan('atv');
//$co->scan('ipd');
//$co->scan('ipd');
//$co->scan('ipd');
//
//$co->scan('mbp');
//$co->scan('vga');
//$co->scan('ipd');

$co->total();

