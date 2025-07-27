<?php


use Capart\Products\Models\Product;

Route::get('sitemap.xml', function(){
    $products = Product::active()->get();

    return Response::view('capart.products::sitemap', ['products' => $products])->header('Content-Type', 'text/xml');

});

Route::post('/add-to-cart', 'capart\Cart\Controllers\Carts@addToCart');
Route::post('/buy-now', 'capart\Cart\Controllers\Carts@buyNow');
Route::post('/delete-cart-item', 'capart\Cart\Controllers\Carts@removeFromCart');
Route::post('/update-quantity', 'capart\Cart\Controllers\Carts@updateItemQuantity');
Route::post('/payment-order', 'capart\Orders\Controllers\Orders@paymentOrder');
Route::post('/payment-order-callback', 'capart\Payments\Controllers\Payments@paymentOrderCallBack');

Route::get('errorlog', function () {
//    if ($_SERVER['REMOTE_ADDR'] == '188.123.138.96') {
        $Now = \Carbon\Carbon::now()->toDateString();
        $file = storage_path('logs/system-'.$Now.'.log');
        if (file_exists($file)) {
            print_R(file_get_contents($file));
        }
//    }
});

Route::get('clearerrorlog', function () {
//    if ($_SERVER['REMOTE_ADDR'] == '188.123.138.96') {
        $Now = \Carbon\Carbon::now()->toDateString();
        $file = storage_path('logs/system-'.$Now.'.log');
        if (file_exists($file)) {
            $file=fopen($file,"w");
            fwrite($file, '');
            fclose($file);
        }
//    }
});
//'skillset\Notifications\Controllers\Notifications@sendTestNotification
