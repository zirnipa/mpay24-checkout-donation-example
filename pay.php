<?php
  include_once ("lib/MPAY24.php");
  
  $shop = new MPAY24();

  $mdxi = new ORDER();
  $rand = rand(1, 99999999999);
  $mdxi->Order->Tid = $rand;
  
  $mdxi->Order->TemplateSet->setLanguage("DE");
   $mdxi->Order->TemplateSet->setCSSName("MODERN");
  $mdxi->Order->ShoppingCart->Description = "Ihre Spende";
      
  $mdxi->Order->ShoppingCart->Item(1)->Number = 1;
  $mdxi->Order->ShoppingCart->Item(1)->ProductNr = 1;
  $mdxi->Order->ShoppingCart->Item(1)->Description = "Spende";
  $mdxi->Order->ShoppingCart->Item(1)->ItemPrice = $_POST['amount'];

  $mdxi->Order->Price = $_POST['amount'];
  
  $mdxi->Order->BillingAddr->setMode("ReadWrite");
  $mdxi->Order->BillingAddr->Name = $_POST['name'];
  $mdxi->Order->BillingAddr->Street = $_POST['street'];
  $mdxi->Order->BillingAddr->Zip = $_POST['zip'];
  $mdxi->Order->BillingAddr->City = $_POST['city'];
  $mdxi->Order->BillingAddr->Country->setCode('AT');
  $mdxi->Order->BillingAddr->Email = $_POST['email'];

    $mdxi->Order->URL->Success = substr($_SERVER['HTTP_REFERER'], 0, strrpos($_SERVER['HTTP_REFERER'], '/')) . "/success.php";
    $mdxi->Order->URL->Error = substr($_SERVER['HTTP_REFERER'], 0, strrpos($_SERVER['HTTP_REFERER'], '/')) . "/error.php";
    $mdxi->Order->URL->Confirmation = substr($_SERVER['HTTP_REFERER'], 0, strrpos($_SERVER['HTTP_REFERER'], '/')) . "/confirm.php?token=";
    $mdxi->Order->URL->Cancel = substr($_SERVER['HTTP_REFERER'], 0, strrpos($_SERVER['HTTP_REFERER'], '/')) . "/index.php";

  header('Location: '.$shop->selectPayment($mdxi)->location);
?>