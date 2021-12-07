<?php
class AcmeWidget {

    public $products=   array();
    public $offerRules='No offer available';

    public function __construct(){
        $this->products= array(
                                array("title"=>"Red Widget", "code"=>"R01","price"=>32.95, "offer"=>"yes"),
                                array("title"=>"Green Widget", "code"=>"G01","price"=>24.95, "offer"=>"no"),
                                array("title"=>"Blue Widget", "code"=>"B01","price"=>7.95,"offer"=>"no"),
                                );
    }

    public function totalMethod($basket) {

        if(is_array($basket) && count($basket) >0) {
           $productDetails= $this->productBasket($basket);
           $formatProductBasket = $this->checkOffer($productDetails);

           $productPrice = $this->getWidgetPrice($formatProductBasket);
           $totalCost = $this->addDeliveryCost($productPrice);
           $result = $this->formatResult($totalCost,$formatProductBasket);
           return $result;
        }
        else {
            return false;
        }
    }

    function formatResult($totalCost,$formatProductBasket){
        $result=array();
        foreach($formatProductBasket as $key=>$value) {
            $products[]= $value['code'];
        }

        $result['products'] = implode(",",$products);
        $result['total'] = $totalCost;
        $result['offerRule'] = $this->offerRules;
        return $result;

    }

    public function productBasket($basket) {
      foreach($basket as $key=>$value) {
               $productDetailsArray[]=  $this->getProductByCode($value);
            }
      return $productDetailsArray;
    }

    public function getWidgetPrice($basket) {
        $totalPrice = 0;
        foreach($basket as $key=>$value) {
              $totalPrice += $value['price'];
        }
        return $totalPrice;
    }

    public function addDeliveryCost($productPrice) {
        $totalPrice=$productPrice;
        if($productPrice>0 && $productPrice<49.9){
            $totalPrice += 4.95;
        }

        if($productPrice>49.9 && $productPrice<90){
            $totalPrice += 2.95;
        }
        return $totalPrice;
    }

    public function checkOffer($productBasket) {
        $redWidget=0;
        foreach($productBasket as $key=>$value) {
            if($value['code'] == "R01") {
                $redWidget ++;
                if($redWidget==2) {
                    $this->offerRules='Buy one red widget, bet the second half price';
                    $productBasket[$key]['price'] = $value['price']/2;
                }
            }
        }
        return $productBasket;
    }

    public function getProductByCode($productCode) {
        foreach($this->products as $key=>$value) {
                if($value['code'] ==$productCode) {
                   return $value;
                }
        }

    }

}

$acmeObject = new AcmeWidget();

$prodcutBasket = ["B01","B01","R01","R01","R01"];
$acmeObject->totalMethod($prodcutBasket);
echo "<pre>";
print_r($acmeObject->totalMethod($prodcutBasket));
echo "</pre>";

?>