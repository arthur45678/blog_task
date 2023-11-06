<?php


use App\Models\CartItem;

function check_exist_product_in_cart($product_id){
    return CartItem::where('user_id', auth()->id())
        ->where('product_id', $product_id)
        ->first();

}
