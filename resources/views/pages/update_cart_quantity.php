<?php

$shoppingCart = new ShoppingCart();
 
$shoppingCart->updateCartQuantity($_POST["new_quantity"], $_POST["cart_id"]);
                
?>