<?php

$order = new Order();
$order->setPrice(4000);
var_dump($order);
echo $order->getTotalHtml();

class Order
{
  const MINIMUM_PRICE_FREE_SHIPPING = 5000;
  const TAX_VALUE = 0.05;
  protected $tax = 0 ;
  protected $shipping = 0;
  protected $price = 0;

  public function setPrice($price)
  {
    $this->price = $price;
    $this->calculateShipping($price);
    $this->calculateTax($price);
    return $this;
  }

  protected function validatePrice($price)
  {
    return is_numeric($price);
  }

  protected function calculateTotal()
  {
    $result = false;
    if($this->validatePrice($this->price)){
      $result = $this->price + $this->tax + $this->shipping;
    }

    return $result;
    
  }

  protected function calculateShipping($price)
  {
    if($price && $price < self::MINIMUM_PRICE_FREE_SHIPPING){
      $this->shipping = 60;
    }

    return $this->shipping;
  }

  protected function calculateTax($price)
  {
    $this->tax = $this->price * self::TAX_VALUE;

    return $this->tax;
  }

  public function getTotalHtml()
  {
    $result = 'Please enter right number format.';
    $total = $this->calculateTotal();
    if($total){
      $result = $this->printHTML('Price',$this->price);
      $result .= $this->printHTML('Shipping',$this->shipping);
      $result .= $this->printHTML('Tax',$this->tax);
      $result .= $this->printHTML('Total', $total);
    }

    return $result;
  }

  protected function printHTML($title, $value)
  {
    return $title . ': '. $value. '<br>';
  }

}