<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Admin\{
    PaymentMethodManagement,
    VendorManagement,
    ShippingMethodManagement,
    CategoryManagement,
    BrandManagement,
    OrderManagement,
    ReviewManagement,
    ReportManagement,
    ProductCrud,
    TrashBin,
    UserManagement,
    OrderReturnManagement,
};

use App\Livewire\Customer\{
    Catalog,
    ProductDetail,
    Cart,
    Checkout,
    CustomerOrders,
    CustomerReturns,
};

Route::get('/', Catalog::class)->name('home');

Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(function () {
    Route::get('/catalog', Catalog::class)->name('customer.catalog');
    Route::get('/product/{id}', ProductDetail::class)->name('customer.product-detail');
    Route::get('/cart',Cart::class)->name('customer.cart');
    Route::get('/checkout', Checkout::class)->name('customer.checkout');
    Route::get('/orders', CustomerOrders::class)->name('customer.orders');
    Route::get('/returns', CustomerReturns::class)->name('customer.returns');
});

Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/dashboard', \App\Livewire\Admin\AdminDashboard::class)->name('dashboard');
        Route::get('/categories', CategoryManagement::class)->name('categories');
        Route::get('/brands', BrandManagement::class)->name('brands');
        Route::get('/products', ProductCrud::class)->name('products');
        Route::get('/vendors', VendorManagement::class)->name('vendors');
        Route::get('/payment-methods', PaymentMethodManagement::class)->name('payment-methods');
        Route::get('/shipping-methods', ShippingMethodManagement::class)->name('shipping-methods');
        Route::get('/orders', OrderManagement::class)->name('orders');
        Route::get('/reviews', ReviewManagement::class)->name('reviews');
        Route::get('/reports', ReportManagement::class)->name('reports');
        Route::get('/trash', TrashBin::class)->name('trash');
        Route::get('/users', UserManagement::class)->name('users');
        Route::get('/order-returns', OrderReturnManagement::class)->name('order-returns');
    });

