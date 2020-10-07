<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

// Authentication routes...
Route::get('auth/login', 'Auth\AuthController@getLogin');
Route::post('auth/login', 'Auth\AuthController@postLogin');
Route::get('auth/logout', 'Auth\AuthController@getLogout');

// Registration routes...
Route::get('auth/register', 'Auth\AuthController@getRegister');
Route::post('auth/register', 'Auth\AuthController@postRegister');


//Admin AjaxController
Route::get('/ajax/fetch/products', 'AjaxController@getSupplierProducts');
Route::post('/ajax/fetch/customers', 'AjaxController@getCustomersJson');
Route::get('/ajax/fetch/category/products', 'AjaxController@getCategoryProducts');
Route::get('/ajax/fetch/key/products', 'AjaxController@getKeyProducts');
Route::get('/ajax/fetch/product/price', 'AjaxController@getProductPrice');
Route::get('/ajax/fetch/product/cost', 'AjaxController@getProductCost');
Route::get('/ajax/fetch/key/customers', 'AjaxController@getCustomerNames');
Route::get('/ajax/fetch/get/customer/details', 'AjaxController@getCustomerName');
Route::get('/ajax/fetch/key/supplier', 'AjaxController@getIdSupplierName');
Route::get('/ajax/fetch/product/onhand', 'AjaxController@checkProductOnHand');
Route::get('/ajax/fetch/delivery/products', 'AjaxController@getDeliveryProducts');
Route::get('/ajax/fetch/sales/products', 'AjaxController@getSalesProducts');
Route::get('/ajax/fetch/customer/credit', 'AjaxController@getCustomerCreditAmt');
Route::get('/ajax/update/order/qty', 'AjaxController@updateOrderQty');
Route::get('/ajax/update/product/unitcost', 'AjaxController@updateProductUnitCost');
Route::get('/ajax/store/product/unitcost', 'AjaxController@storeProductUnitCost');
Route::get('/ajax/check/product/stock', 'AjaxController@checkProductStock');
Route::get('/ajax/check/customer/credit', 'AjaxController@checkCustomerCredit');
Route::get('/admin/check/expenses', 'ExpensesController@index');
Route::get('/admin/check/expenses/create', 'ExpensesController@create');
Route::get('/admin/check/expenses/store', 'ExpensesController@store');
Route::get('/admin/check/expenses/edit/{id}', 'ExpensesController@edit');
Route::get('/admin/check/expenses/update/{id}', 'ExpensesController@update');
Route::get('/admin/check/expenses/delete/{id}', 'ExpensesController@delete');
Route::get('/admin/check/credit/store', 'CreditController@storePaymentCheque');
Route::get('/admin/credit/payment/history/view/{id}', 'CreditController@paymentHistoryView');



// Redirect
Route::get('/',
    [
        'as' => 'redirect',
        'uses' => 'RedirectController@index'
    ]);


/* ===================ADMINISTRATOR=================== */


// Home
Route::get('/admin',
    function(){
        return redirect()->route('salesIndex');
    });



// Sales
Route::get('/admin/sales',
    [
        'as' => 'salesIndex',
        'uses' => 'Admin\SalesController@index'
    ]);
Route::post('/admin/sales/create',
    [
        'as' => 'salesCreate',
        'uses' => 'Admin\SalesController@create'
    ]);
Route::get('/admin/sales/editCustomer/{id}',
    [
        'as' => 'salesEdit',
        'uses' => 'Admin\SalesController@editCustomer'
    ]);
Route::patch('/admin/sales/updateCustomer/{id}',
    [
        'as' => 'salesUpdate',
        'uses' => 'Admin\SalesController@updateCustomer'
    ]);
Route::get('/admin/sales/summary/{id}',
    [
        'as' => 'salesSummary',
        'uses' => 'Admin\SalesController@summary'
    ]);
Route::get('/admin/sales/summary/print/{id}',
    [
        'as' => 'salesSummaryPrint',
        'uses' => 'Admin\SalesController@printSummary'
    ]);
Route::get('/admin/sales/summaryform/print/{id}',
    [
        'as' => 'salesSummaryFormPrint',
        'uses' => 'Admin\SalesController@printSummaryForm'
    ]);



//Credit
Route::get('/admin/credit',
    [
        'as' => 'creditIndex',
        'uses' => 'Admin\CreditController@index'
    ]);
Route::get('/admin/credit/create/payment/{id}',
    [
        'as' => 'creditCreatePayment',
        'uses' => 'Admin\CreditController@createPayment'
    ]);
Route::post('/admin/credit/store/payment',
    [
        'as' => 'creditPaymentStore',
        'uses' => 'Admin\CreditController@storePayment'
    ]);
Route::post('/admin/credit/store/payment/cheque',
    [
        'as' => 'paymentChequeStore',
        'uses' => 'Admin\CreditController@storePaymentCheque'
    ]);
Route::get('/admin/credit/payment/history/{id}',
    [
        'as' => 'creditPaymentHistory',
        'uses' => 'Admin\CreditController@paymentHistory'
    ]);
Route::get('/admin/credit/payment/history/view/{id}',
    [
        'as' => 'paymentHistoryView',
        'uses' => 'Admin\CreditController@paymentHistoryView'
    ]);




// Orders
Route::post('/admin/sales',
    [
        'as' => 'ordersCreate',
        'uses' => 'Admin\OrdersController@store'
    ]);
Route::get('/admin/sales/destroy/{id}',
    [
        'as' => 'destroyOrder',
        'uses' => 'Admin\OrdersController@destroy'
    ]);




// Categories
Route::get('admin/category',
    [
        'as' => 'categoryIndex',
        'uses' => 'Admin\CategoryController@index'
    ]);
Route::get('/admin/category/create',
    [
        'as' => 'categoryCreate',
        'uses' => 'Admin\CategoryController@create'
    ]);
Route::post('/admin/category/store',
    [
        'as' => 'categoryStore',
        'uses' => 'Admin\CategoryController@store'
    ]);
Route::get('/admin/category/edit/{id}',
    [
        'as' => 'categoryEdit',
        'uses' => 'Admin\CategoryController@edit'
    ]);
Route::patch('/admin/category/update/{id}',
    [
        'as' => 'categoryUpdate',
        'uses' => 'Admin\CategoryController@update'
    ]);
Route::get('/admin/category/destroy/{id}',
    [
        'as' => 'categoryDestroy',
        'uses' => 'Admin\CategoryController@destroy'
    ]);



// Deliveries
Route::get('/admin/delivery',
    [
        'as' => 'deliveryIndex',
        'uses' => 'Admin\DeliveryController@index'
    ]);
Route::get('/admin/delivery/create',
    [
        'as' => 'deliveryCreate',
        'uses' => 'Admin\DeliveryController@create'
    ]);
Route::post('/admin/delivery/store',
    [
        'as' => 'deliveryStore',
        'uses' => 'Admin\DeliveryController@store'
    ]);
Route::get('/admin/delivery/edit/{id}',
    [
        'as' => 'deliveryEdit',
        'uses' => 'Admin\DeliveryController@edit'
    ]);
Route::patch('/admin/delivery/update/{id}',
    [
        'as' => 'deliveryUpdate',
        'uses' => 'Admin\DeliveryController@update'
    ]);
Route::get('/admin/delivery/destroy/{id}',
    [
        'as' => 'deliveryDestroy',
        'uses' => 'Admin\DeliveryController@destroy'
    ]);
Route::get('/admin/delivery/restock', 'Admin\DeliveryController@restock');




// Delivery Set
Route::post('/admin/delivery-set/create',
    [
        'as' => 'deliverySetStore',
        'uses' => 'Admin\DeliverySetController@store'
    ]);
Route::get('/admin/delivery-set/destroy/{id}',
    [
        'as' => 'destroyDelivery-set',
        'uses' => 'Admin\DeliverySetController@destroy'
    ]);



// Delivery Details
Route::get('/admin/delivery-details/show/{id}',
    [
        'as' => 'deliveryDetailsShow',
        'uses' => 'Admin\DeliveryDetailsController@show'
    ]);



// Supplier
Route::get('/admin/supplier',
    [
        'as' => 'supplierIndex',
        'uses' => 'Admin\SupplierController@index'
    ]);
Route::get('/admin/supplier/create',
    [
        'as' => 'supplierCreate',
        'uses' => 'Admin\SupplierController@create'
    ]);
Route::post('/admin/supplier/store',
    [
        'as' => 'supplierStore',
        'uses' => 'Admin\SupplierController@store'
    ]);
Route::get('/admin/supplier/edit/{id}',
    [
        'as' => 'supplierEdit',
        'uses' => 'Admin\SupplierController@edit'
    ]);
Route::patch('/admin/supplier/update/{id}',
    [
        'as' => 'supplierUpdate',
        'uses' => 'Admin\SupplierController@update'
    ]);
Route::get('/admin/supplier/destroy/{id}',
    [
        'as' => 'supplierDestroy',
        'uses' => 'Admin\SupplierController@destroy'
    ]);



// Customer
Route::get('/admin/customer',
    [
        'as' => 'customerIndex',
        'uses' => 'Admin\CustomerController@index'
    ]);

Route::get('/admin/cutomer/create',
    [
        'as' => 'customerCreate',
        'uses' => 'Admin\CustomerController@create'
    ]);
Route::post('/admin/customer/store',
    [
        'as' => 'customerStore',
        'uses' => 'Admin\CustomerController@store'
    ]);
Route::get('/admin/customer/edit/{id}',
    [
        'as' => 'customerEdit',
        'uses' => 'Admin\CustomerController@edit'
    ]);
Route::patch('/admin/customer/update/{id}',
    [
        'as' => 'customerUpdate',
        'uses' => 'Admin\CustomerController@update'
    ]);
Route::get('/admin/customer/destroy/{id}',
    [
        'as' => 'customerDestroy',
        'uses' => 'Admin\CustomerController@destroy'
    ]);



// Employees
Route::get('/admin/employee',
    [
        'as' => 'employeeIndex',
        'uses' => 'Admin\EmployeeController@index'
    ]);
Route::get('/admin/employee/create',
    [
        'as' => 'employeeCreate',
        'uses' => 'Admin\EmployeeController@create'
    ]);
Route::post('/admin/employee/store',
    [
        'as' => 'employeeStore',
        'uses' => 'Admin\EmployeeController@store'
    ]);
Route::get('/admin/employee/edit/{id}',
    [
        'as' => 'employeeEdit',
        'uses' => 'Admin\EmployeeController@edit'
    ]);
Route::patch('/admin/employee/update/{id}',
    [
        'as' => 'employeeUpdate',
        'uses' => 'Admin\EmployeeController@update'
    ]);
Route::get('/admin/employee/destroy/{id}',
    [
        'as' => 'employeeDestroy',
        'uses' => 'Admin\EmployeeController@destroy'
    ]);





// Products
Route::get('/admin/products',
    [
        'as' => 'productsIndex',
        'uses' => 'Admin\ProductsController@index'
    ]);
Route::get('/admin/products/create',
    [
        'as' => 'productsCreate',
        'uses' => 'Admin\ProductsController@create'
    ]);
Route::post('/admin/products/store',
    [
        'as' => 'productStore',
        'uses' => 'Admin\ProductsController@store'
    ]);
Route::get('/admin/products/edit/{id}',
    [
        'as' => 'productsEdit',
        'uses' => 'Admin\ProductsController@edit'
    ]);
Route::patch('/admin/products/update/{id}',
    [
        'as' => 'productsUpdate',
        'uses' => 'Admin\ProductsController@update'
    ]);
Route::get('/admin/products/destroy',
    [
        'as' => 'productsDestroy',
        'uses' => 'Admin\ProductsController@destroy'
    ]);
Route::get('/admin/products/set/status/{id}',
    [
        'as' => 'productStatus',
        'uses' => 'Admin\ProductsController@setStatus'
    ]);



// Transactions
Route::get('/admin/transactions/customer/{id}',
    [
        'as' => 'transactionsIndex',
        'uses' => 'Admin\TransactionsController@index'
    ]);


// CustomerAgent
Route::get('/admin/customerAgent/customer/{id}',
    [
        'as' => 'customerAgentIndex',
        'uses' => 'Admin\CustomerAgentController@index'
    ]);



// Sales Details
Route::get('/admin/customer/sales/details/{id}',
    [
        'as' => 'salesDetailsIndex',
        'uses' => 'Admin\SalesDetailsController@index'
    ]);
Route::get('/admin/customer/sales/print/details/{id}',
    [
        'as' => 'salesDetailsPrint',
        'uses' => 'Admin\SalesDetailsController@printInvoice'
    ]);
Route::get('/admin/customer/salesForm/print/details/{id}',
    [
        'as' => 'salesDetailsFormPrint',
        'uses' => 'Admin\SalesDetailsController@printInvoiceForm'
    ]);



// Reports
Route::get('/admin/report',
    [
        'as' => 'reportIndex',
        'uses' => 'Admin\ReportsController@index'
    ]);
Route::get('/admin/report/print/{option}/{day}/{month}',
    [
        'as' => 'reportPrint',
        'uses' => 'Admin\ReportsController@printReport'
    ]);
Route::get('/admin/custAgent/report',
    [
        'as' => 'reportCustAgentIndex',
        'uses' => 'Admin\ReportsController@custAgent'
    ]);
Route::get('/admin/custAgent/report/print/{custmer}',
    [
        'as' => 'reportCustAgentPrint',
        'uses' => 'Admin\ReportsController@printCustAgent'
    ]);

Route::get('/admin/agent/report/{id}',
    [
        'as' => 'reportAgentIndex',
        'uses' => 'Admin\ReportsController@agent'
    ]);
Route::get('/admin/agent/report/print/{custmer}',
    [
        'as' => 'reportAgentPrint',
        'uses' => 'Admin\ReportsController@printAgent'
    ]);

Route::get('/admin/inventory/report',
    [
        'as' => 'reportInventory',
        'uses' => 'Admin\ReportsController@inventory'
    ]);
Route::get('/admin/inventory/report/print/{category}',
    [
        'as' => 'reportInventoryPrint',
        'uses' => 'Admin\ReportsController@printInventoryReport'
    ]);

Route::get('/admin/report/sales',
    [
        'as' => 'reportSalesIndex',
        'uses' => 'Admin\ReportsController@sales'
    ]);
Route::get('/admin/report/sales/print/{option}/{year}/{month}',
    [
        'as' => 'reportSalesPrint',
        'uses' => 'Admin\ReportsController@salesPrint'
    ]);


Route::get('/admin/report/customers',
    [
        'as' => 'reportCustomerIndex',
        'uses' => 'Admin\ReportsController@customers'
    ]);
Route::get('/admin/report/customer/sales/{id}',
    [
        'as' => 'reportCustomerSalesIndex',
        'uses' => 'Admin\ReportsController@customerSales'
    ]);
Route::get('/admin/report/customer/sales/print/{date}/{id}',
    [
        'as' => 'reportCustomerSalesPrint',
        'uses' => 'Admin\ReportsController@customerSalesPrint'
    ]);

Route::get('/admin/report/payment',
    [
        'as' => 'reportPaymentIndex',
        'uses' => 'Admin\ReportsController@payment'
    ]);
Route::get('/admin/report/payment/print/{option}/{month}/{year}',
    [
        'as' => 'reportPaymentPrint',
        'uses' => 'Admin\ReportsController@paymentPrint'
    ]);

Route::get('/admin/report/delivery',
    [
        'as' => 'reportDeliveryIndex',
        'uses' => 'Admin\ReportsController@delivery'
    ]);
Route::get('/admin/report/delivery/print/{month}/{year}',
    [
        'as' => 'reportDeliveryPrint',
        'uses' => 'Admin\ReportsController@deliveryPrint'
    ]);

Route::get('/admin/report/stat',
    [
        'as' => 'reportStatIndex',
        'uses' => 'Admin\ReportsController@stat'
    ]);
Route::get('/admin/report/stat/print/{month}/{year}',
    [
        'as' => 'reportStatPrint',
        'uses' => 'Admin\ReportsController@statPrint'
    ]);

Route::get('/admin/report/incomestatement',
    [
        'as' => 'reportIncomeStatementIndex',
        'uses' => 'Admin\ReportsController@incomeStatement'
    ]);
Route::get('/admin/report/incomeStatement/print/{month}/{year}',
    [
        'as' => 'reportIncomeStatementPrint',
        'uses' => 'Admin\ReportsController@incomeStatementPrint'
    ]);

Route::get('/admin/report/reorder',
    [
        'as' => 'reportReorderIndex',
        'uses' => 'Admin\ReportsController@reorder'
    ]);
Route::get('/admin/report/reorder/print/{option}/{month}',
    [
        'as' => 'reportReorderPrint',
        'uses' => 'Admin\ReportsController@reorderPrint'
    ]);
Route::get('/admin/report/weeklypayment',
    [
        'as' => 'reportWeeklyPaymentIndex',
        'uses' => 'Admin\ReportsController@weeklyPayment'
    ]);




//Expenses

Route::get('/admin/expenses', 
    [
        'as' => 'expensesIndex',
        'uses' => 'Admin\ExpensesController@index'
    ]);
Route::get('/admin/expenses/create',
    [
        'as' => 'expensesCreate',
        'uses' => 'Admin\ExpensesController@create'
    ]);
Route::post('/admin/expenses/store',
    [
        'as' => 'expensesStore',
        'uses' => 'Admin\ExpensesController@store'
    ]);
Route::get('/admin/expenses/edit/{id}',
    [
        'as' => 'expensesEdit',
        'uses' => 'Admin\ExpensesController@edit'
    ]);
Route::patch('/admin/expenses/update/{id}',
    [
        'as' => 'expensesUpdate',
        'uses' => 'Admin\ExpensesController@update'
    ]);
Route::get('/admin/expenses/destroy/{id}',
    [
        'as' => 'expensesDestroy',
        'uses' => 'Admin\ExpensesController@destroy'
    ]);








/* ==================Supervisor========================  */

// Home
Route::get('/supervisor',
    function(){
        return view('supervisor.home');
    });



// Sales
Route::get('/supervisor/sales',
    [
        'as' => 'supervisorSalesIndex',
        'uses' => 'Supervisor\SalesController@index'
    ]);
Route::post('/supervisor/sales/create',
    [
        'as' => 'supervisorSalesCreate',
        'uses' => 'Supervisor\SalesController@create'
    ]);
Route::get('/supervisor/sales/editCustomer/{id}',
    [
        'as' => 'supervisorSalesEdit',
        'uses' => 'Supervisor\SalesController@editCustomer'
    ]);
Route::patch('/supervisor/sales/updateCustomer/{id}',
    [
        'as' => 'supervisorSalesUpdate',
        'uses' => 'Supervisor\SalesController@updateCustomer'
    ]);
Route::get('/supervisor/sales/summary/{id}',
    [
        'as' => 'supervisorSalesSummary',
        'uses' => 'Supervisor\SalesController@summary'
    ]);
Route::get('/supervisor/sales/summary/print/{id}',
    [
        'as' => 'supervisorSalesSummaryPrint',
        'uses' => 'Supervisor\SalesController@printSummary'
    ]);



//Credit
Route::get('/supervisor/credit',
    [
        'as' => 'supervisorCreditIndex',
        'uses' => 'Supervisor\CreditController@index'
    ]);
Route::get('/supervisor/credit/create/payment/{id}',
    [
        'as' => 'supervisorCreditCreatePayment',
        'uses' => 'Supervisor\CreditController@createPayment'
    ]);
Route::post('/supervisor/credit/store/payment',
    [
        'as' => 'supervisorCreditPaymentStore',
        'uses' => 'Supervisor\CreditController@storePayment'
    ]);
Route::get('/supervisor/credit/payment/history/{id}',
    [
        'as' => 'supervisorCreditPaymentHistory',
        'uses' => 'Supervisor\CreditController@paymentHistory'
    ]);


// Orders
Route::post('/supervisor/sales',
    [
        'as' => 'supervisorOrdersCreate',
        'uses' => 'Supervisor\OrdersController@store'
    ]);
Route::get('/supervisor/sales/destroy/{id}',
    [
        'as' => 'supervisorDestroyOrder',
        'uses' => 'Supervisor\OrdersController@destroy'
    ]);



// Categories
Route::get('/supervisor/category',
    [
        'as' => 'supervisorCategoryIndex',
        'uses' => 'Supervisor\CategoryController@index'
    ]);
Route::get('/supervisor/category/create',
    [
        'as' => 'supervisorCategoryCreate',
        'uses' => 'Supervisor\CategoryController@create'
    ]);
Route::post('/supervisor/category/store',
    [
        'as' => 'supervisorCategoryStore',
        'uses' => 'Supervisor\CategoryController@store'
    ]);
Route::get('/supervisor/category/edit/{id}',
    [
        'as' => 'supervisorCategoryEdit',
        'uses' => 'Supervisor\CategoryController@edit'
    ]);
Route::patch('/supervisor/category/update/{id}',
    [
        'as' => 'supervisorCategoryUpdate',
        'uses' => 'Supervisor\CategoryController@update'
    ]);
Route::get('/supervisor/category/destroy/{id}',
    [
        'as' => 'supervisorCategoryDestroy',
        'uses' => 'Supervisor\CategoryController@destroy'
    ]);
    
    

// Supplier
Route::get('/supervisor/supplier',
    [
        'as' => 'supervisorSupplierIndex',
        'uses' => 'Supervisor\SupplierController@index'
    ]);
Route::get('/supervisor/supplier/create',
    [
        'as' => 'supervisorSupplierCreate',
        'uses' => 'Supervisor\SupplierController@create'
    ]);
Route::post('/supervisor/supplier/store',
    [
        'as' => 'supervisorSupplierStore',
        'uses' => 'Supervisor\SupplierController@store'
    ]);
Route::get('/supervisor/supplier/edit/{id}',
    [
        'as' => 'supervisorSupplierEdit',
        'uses' => 'Supervisor\SupplierController@edit'
    ]);
Route::patch('/supervisor/supplier/update/{id}',
    [
        'as' => 'supervisorSupplierUpdate',
        'uses' => 'Supervisor\SupplierController@update'
    ]);
Route::get('/supervisor/supplier/destroy/{id}',
    [
        'as' => 'supervisorSupplierDestroy',
        'uses' => 'Supervisor\SupplierController@destroy'
    ]);
    


// Deliveries
Route::get('/supervisor/delivery',
    [
        'as' => 'supervisorDeliveryIndex',
        'uses' => 'Supervisor\DeliveryController@index'
    ]);
Route::get('/supervisor/delivery/create',
    [
        'as' => 'supervisorDeliveryCreate',
        'uses' => 'Supervisor\DeliveryController@create'
    ]);
Route::post('/supervisor/delivery/store',
    [
        'as' => 'supervisorDeliveryStore',
        'uses' => 'Supervisor\DeliveryController@store'
    ]);
Route::get('/supervisor/delivery/edit/{id}',
    [
        'as' => 'supervisorDeliveryEdit',
        'uses' => 'Supervisor\DeliveryController@edit'
    ]);
Route::patch('/supervisor/delivery/update/{id}',
    [
        'as' => 'supervisorDeliveryUpdate',
        'uses' => 'Supervisor\DeliveryController@update'
    ]);
Route::get('/supervisor/delivery/destroy/{id}',
    [
        'as' => 'supervisorDeliveryDestroy',
        'uses' => 'Supervisor\DeliveryController@destroy'
    ]);
Route::get('/supervisor/delivery/restock',
    [
        'as' => 'supervisorProductRestock',
        'uses' => 'Supervisor\DeliveryController@restock'
    ]);




    // Delivery Set
Route::post('/supervisor/delivery-set/create',
    [
        'as' => 'supervisorDeliverySetStore',
        'uses' => 'Supervisor\DeliverySetController@store'
    ]);
Route::get('/supervisor/delivery-set/destroy/{id}',
    [
        'as' => 'supervisorDestroyDelivery-set',
        'uses' => 'Supervisor\DeliverySetController@destroy'
    ]);



// Delivery Details
Route::get('/supervisor/delivery-details/show/{id}',
    [
        'as' => 'supervisorDeliveryDetailsShow',
        'uses' => 'Supervisor\DeliveryDetailsController@show'
    ]);



// Products
Route::get('/supervisor/products',
    [
        'as' => 'supervisorProductsIndex',
        'uses' => 'Supervisor\ProductsController@index'
    ]);
Route::get('/supervisor/products/create',
    [
        'as' => 'supervisorProductsCreate',
        'uses' => 'Supervisor\ProductsController@create'
    ]);
Route::post('/supervisor/products/store',
    [
        'as' => 'supervisorProductStore',
        'uses' => 'Supervisor\ProductsController@store'
    ]);
Route::get('/supervisor/products/edit/{id}',
    [
        'as' => 'supervisorProductsEdit',
        'uses' => 'Supervisor\ProductsController@edit'
    ]);
Route::patch('/supervisor/products/update/{id}',
    [
        'as' => 'supervisorProductsUpdate',
        'uses' => 'Supervisor\ProductsController@update'
    ]);
Route::get('/supervisor/products/destroy/{id}',
    [
        'as' => 'supervisorProductsDestroy',
        'uses' => 'Supervisor\ProductsController@destroy'
    ]);
Route::get('/supervisor/products/set/status/{id}',
    [
        'as' => 'supervisorProductStatus',
        'uses' => 'Supervisor\ProductsController@setStatus'
    ]);


// Transactions
Route::get('/supervisor/transactions/customer/{id}',
    [
        'as' => 'supervisorTransactionsIndex',
        'uses' => 'Supervisor\TransactionsController@index'
    ]);



// Sales Details
Route::get('/supervisor/customer/sales/details/{id}',
    [
        'as' => 'supervisorSalesDetailsIndex',
        'uses' => 'Supervisor\SalesDetailsController@index'
    ]);
Route::get('/supervisor/customer/sales/print/details/{id}',
    [
        'as' => 'supervisorSalesDetailsPrint',
        'uses' => 'Supervisor\SalesDetailsController@printInvoice'
    ]);




// Customers
Route::get('/supervisor/customer',
    [
        'as' => 'supervisorCustomerIndex',
        'uses' => 'Supervisor\CustomerController@index'
    ]);
Route::get('/supervisor/customer/create',
    [
        'as' => 'supervisorCustomerCreate',
        'uses' => 'Supervisor\CustomerController@create'
    ]);
Route::post('/supervisor/customer/store',
    [
        'as' => 'supervisorCustomerStore',
        'uses' => 'Supervisor\CustomerController@store'
    ]);
Route::get('/supervisor/customer/edit/{id}',
    [
        'as' => 'supervisorCustomerEdit',
        'uses' => 'Supervisor\CustomerController@edit'
    ]);
Route::patch('/supervisor/customer/update/{id}',
    [
        'as' => 'supervisorCustomerUpdate',
        'uses' => 'Supervisor\CustomerController@update'
    ]);



// Reports
Route::get('/supervisor/report',
    [
        'as' => 'supervisorReportIndex',
        'uses' => 'Supervisor\ReportsController@index'
    ]);
Route::get('/supervisor/report/print/{option}/{day}/{month}',
    [
        'as' => 'supervisorReportPrint',
        'uses' => 'Supervisor\ReportsController@printReport'
    ]);

Route::get('/supervisor/inventory/report',
    [
        'as' => 'supervisorReportInventory',
        'uses' => 'Supervisor\ReportsController@inventory'
    ]);
Route::get('/supervisor/inventory/report/print/{category}',
    [
        'as' => 'supervisorReportInventoryPrint',
        'uses' => 'Supervisor\ReportsController@printInventoryReport'
    ]);

Route::get('/supervisor/report/sales',
    [
        'as' => 'supervisorReportSalesIndex',
        'uses' => 'Supervisor\ReportsController@sales'
    ]);
Route::get('/supervisor/report/sales/print/{option}/{year}/{month}',
    [
        'as' => 'supervisorReportSalesPrint',
        'uses' => 'Supervisor\ReportsController@salesPrint'
    ]);

Route::get('/supervisor/report/customers',
    [
        'as' => 'supervisorReportCustomerIndex',
        'uses' => 'Supervisor\ReportsController@customers'
    ]);
Route::get('/supervisor/report/customer/sales/{id}',
    [
        'as' => 'supervisorReportCustomerSalesIndex',
        'uses' => 'Supervisor\ReportsController@customerSales'
    ]);
Route::get('/supervisor/report/customer/sales/print/{date}/{id}',
    [
        'as' => 'supervisorReportCustomerSalesPrint',
        'uses' => 'Supervisor\ReportsController@customerSalesPrint'
    ]);

Route::get('/supervisor/report/payment',
    [
        'as' => 'supervisorReportPaymentIndex',
        'uses' => 'Supervisor\ReportsController@payment'
    ]);
Route::get('/supervisor/report/payment/print/{option}/{month}/{year}',
    [
        'as' => 'supervisorReportPaymentPrint',
        'uses' => 'Supervisor\ReportsController@paymentPrint'
    ]);

Route::get('/supervisor/report/delivery',
    [
        'as' => 'supervisorReportDeliveryIndex',
        'uses' => 'Supervisor\ReportsController@delivery'
    ]);
Route::get('/supervisor/report/delivery/print/{option}/{day}/{month}',
    [
        'as' => 'supervisorReportDeliveryPrint',
        'uses' => 'Supervisor\ReportsController@deliveryPrint'
    ]);

Route::get('/supervisor/report/stat',
    [
        'as' => 'supervisorReportStatIndex',
        'uses' => 'Supervisor\ReportsController@stat'
    ]);
Route::get('/supervisor/report/stat/print/{option}/{month}',
    [
        'as' => 'supervisorReportStatPrint',
        'uses' => 'Supervisor\ReportsController@statPrint'
    ]);

Route::get('/supervisor/report/incomestatement',
    [
        'as' => 'supervisorReportIncomeStatementIndex',
        'uses' => 'Supervisor\ReportsController@incomeStatement'
    ]);
Route::get('/supervisor/report/incomeStatement/print/{month}/{year}',
    [
        'as' => 'supervisorReportIncomeStatementPrint',
        'uses' => 'Supervisor\ReportsController@incomeStatementPrint'
    ]);

Route::get('/supervisor/report/reorder',
    [
        'as' => 'supervisorReportReorderIndex',
        'uses' => 'Supervisor\ReportsController@reorder'
    ]);
Route::get('/supervisor/report/reorder/print/{option}/{month}',
    [
        'as' => 'supervisorReportReorderPrint',
        'uses' => 'Supervisor\ReportsController@reorderPrint'
    ]);




/* ====================Accountant====================== */

// Home
Route::get('/accountant',
    function(){
        return view('accountant.home');
    });



// Sales
Route::get('/accountant/sales',
    [
        'as' => 'accountantSalesIndex',
        'uses' => 'Accountant\SalesController@index'
    ]);
Route::post('/accountant/sales/create',
    [
        'as' => 'accountantSalesCreate',
        'uses' => 'Accountant\SalesController@create'
    ]);
Route::get('/accountant/sales/editCustomer/{id}',
    [
        'as' => 'accountantSalesEdit',
        'uses' => 'Accountant\SalesController@editCustomer'
    ]);
Route::patch('/accountant/sales/updateCustomer/{id}',
    [
        'as' => 'accountantSalesUpdate',
        'uses' => 'Accountant\SalesController@updateCustomer'
    ]);
Route::get('/accountant/sales/summary/{id}',
    [
        'as' => 'accountantSalesSummary',
        'uses' => 'Accountant\SalesController@summary'
    ]);
Route::get('/accountant/sales/summary/print/{id}',
    [
        'as' => 'accountantSalesSummaryPrint',
        'uses' => 'Accountant\SalesController@printSummary'
    ]);



//Credit
Route::get('/accountant/credit',
    [
        'as' => 'accountantCreditIndex',
        'uses' => 'Accountant\CreditController@index'
    ]);
Route::get('/accountant/credit/create/payment/{id}',
    [
        'as' => 'accountantCreditCreatePayment',
        'uses' => 'Accountant\CreditController@createPayment'
    ]);
Route::post('/accountant/credit/store/payment',
    [
        'as' => 'accountantCreditPaymentStore',
        'uses' => 'Accountant\CreditController@storePayment'
    ]);
Route::get('/accountant/credit/payment/history/{id}',
    [
        'as' => 'accountantCreditPaymentHistory',
        'uses' => 'Accountant\CreditController@paymentHistory'
    ]);



// Orders
Route::post('/accountant/sales',
    [
        'as' => 'accountantOrdersCreate',
        'uses' => 'Accountant\OrdersController@store'
    ]);
Route::get('/accountant/sales/destroy/{id}',
    [
        'as' => 'accountantDestroyOrder',
        'uses' => 'Accountant\OrdersController@destroy'
    ]);



// Transactions
Route::get('/accountant/transactions/customer/{id}',
    [
        'as' => 'accountantTransactionsIndex',
        'uses' => 'Accountant\TransactionsController@index'
    ]);



// Sales Details
Route::get('/accountant/customer/sales/details/{id}',
    [
        'as' => 'accountantSalesDetailsIndex',
        'uses' => 'Accountant\SalesDetailsController@index'
    ]);
Route::get('/accountant/customer/sales/print/details/{id}',
    [
        'as' => 'accountantSalesDetailsPrint',
        'uses' => 'Accountant\SalesDetailsController@printInvoice'
    ]); 




// Customer
Route::get('/accountant/customer',
    [
        'as' => 'accountantCustomerIndex',
        'uses' => 'Accountant\CustomerController@index'
    ]);
Route::get('/accountant/customer/create',
    [
        'as' => 'accountantCustomerCreate',
        'uses' => 'Accountant\CustomerController@create'
    ]);
Route::post('/accountant/customer/store',
    [
        'as' => 'accountantCustomerStore',
        'uses' => 'Accountant\CustomerController@store'
    ]);
Route::get('/accountant/customer/edit/{id}',
    [
        'as' => 'accountantCustomerEdit',
        'uses' => 'Accountant\CustomerController@edit'
    ]);
Route::patch('/accountant/customer/update/{id}',
    [
        'as' => 'accountantCustomerUpdate',
        'uses' => 'Accountant\CustomerController@update'
    ]);



// Products
Route::get('/accountant/products',
    [
        'as' => 'accountantProductsIndex',
        'uses' => 'Accountant\ProductsController@index'
    ]);
Route::get('/accountant/products/create',
    [
        'as' => 'accountantProductsCreate',
        'uses' => 'Accountant\ProductsController@create'
    ]);
Route::post('/accountant/products/store',
    [
        'as' => 'accountantProductStore',
        'uses' => 'Accountant\ProductsController@store'
    ]);
Route::get('/accountant/products/edit/{id}',
    [
        'as' => 'accountantProductsEdit',
        'uses' => 'Accountant\ProductsController@edit'
    ]);
Route::patch('/accountant/products/update/{id}',
    [
        'as' => 'accountantProductsUpdate',
        'uses' => 'Accountant\ProductsController@update'
    ]);
Route::get('/accountant/products/set/status/{id}',
    [
        'as' => 'accountantProductStatus',
        'uses' => 'Accountant\ProductsController@setStatus'
    ]);




// Categories
Route::get('/accountant/category',
    [
        'as' => 'accountantCategoryIndex',
        'uses' => 'Accountant\CategoryController@index'
    ]);
Route::get('/accountant/category/create',
    [
        'as' => 'accountantCategoryCreate',
        'uses' => 'Accountant\CategoryController@create'
    ]);
Route::post('/accountant/category/store',
    [
        'as' => 'accountantCategoryStore',
        'uses' => 'Accountant\CategoryController@store'
    ]);
Route::get('/accountant/category/edit/{id}',
    [
        'as' => 'accountantCategoryEdit',
        'uses' => 'Accountant\CategoryController@edit'
    ]);
Route::patch('/accountant/category/update/{id}',
    [
        'as' => 'accountantCategoryUpdate',
        'uses' => 'Accountant\CategoryController@update'
    ]); 




// Suppliers
Route::get('/accountant/supplier',
    [
        'as' => 'accountantSupplierIndex',
        'uses' => 'Accountant\SupplierController@index'
    ]);
Route::get('/accountant/supplier/create',
    [
        'as' => 'accountantSupplierCreate',
        'uses' => 'Accountant\SupplierController@create'
    ]);
Route::post('/accountant/supplier/store',
    [
        'as' => 'accountantSupplierStore',
        'uses' => 'Accountant\SupplierController@store'
    ]);
Route::get('/accountant/supplier/edit/{id}',
    [
        'as' => 'accountantSupplierEdit',
        'uses' => 'Accountant\SupplierController@edit'
    ]);
Route::patch('/accountant/supplier/update/{id}',
    [
        'as' => 'accountantSupplierUpdate',
        'uses' => 'Accountant\SupplierController@update'
    ]);




// Deliveries
Route::get('/accountant/delivery',
    [
        'as' => 'accountantDeliveryIndex',
        'uses' => 'Accountant\DeliveryController@index'
    ]);
Route::get('/accountant/delivery/create',
    [
        'as' => 'accountantDeliveryCreate',
        'uses' => 'Accountant\DeliveryController@create'
    ]);
Route::post('/accountant/delivery/store',
    [
        'as' => 'accountantDeliveryStore',
        'uses' => 'Accountant\DeliveryController@store'
    ]);
Route::get('/accountant/delivery/edit/{id}',
    [
        'as' => 'accountantDeliveryEdit',
        'uses' => 'Accountant\DeliveryController@edit'
    ]);
Route::patch('/accountant/delivery/update/{id}',
    [
        'as' => 'accountantDeliveryUpdate',
        'uses' => 'Accountant\DeliveryController@update'
    ]);
Route::get('/accountant/delivery/restock',
    [
        'as' => 'accountantProductRestock',
        'uses' => 'Accountant\DeliveryController@restock'
    ]);


// Delivery Set
Route::post('/accountant/delivery-set/create',
    [
        'as' => 'accountantDeliverySetStore',
        'uses' => 'Accountant\DeliverySetController@store'
    ]);
Route::get('/accountant/delivery-set/destroy/{id}',
    [
        'as' => 'accountantDestroyDelivery-set',
        'uses' => 'Accountant\DeliverySetController@destroy'
    ]);


// Delivery Details
Route::get('/accountant/delivery-details/show/{id}',
    [
        'as' => 'accountantDeliveryDetailsShow',
        'uses' => 'Accountant\DeliveryDetailsController@show'
    ]);



// Reports
Route::get('/accountant/report',
    [
        'as' => 'accountantReportIndex',
        'uses' => 'Accountant\ReportsController@index'
    ]);
Route::get('/accountant/report/print/{option}/{day}/{month}',
    [
        'as' => 'accountantReportPrint',
        'uses' => 'Accountant\ReportsController@printReport'
    ]);
Route::get('/accountant/inventory/report',
    [
        'as' => 'accountantReportInventory',
        'uses' => 'Accountant\ReportsController@inventory'
    ]);
Route::get('/accountant/inventory/report/print/{category}',
    [
        'as' => 'accountantReportInventoryPrint',
        'uses' => 'Accountant\ReportsController@printInventoryReport'
    ]);
Route::get('/accountant/report/sales',
    [
        'as' => 'accountantReportSalesIndex',
        'uses' => 'accountant\ReportsController@sales'
    ]);
Route::get('/accountant/report/sales/print/{option}/{year}/{month}',
    [
        'as' => 'accountantReportSalesPrint',
        'uses' => 'Accountant\ReportsController@salesPrint'
    ]);

Route::get('/accountant/report/customers',
    [
        'as' => 'accountantReportCustomerIndex',
        'uses' => 'Accountant\ReportsController@customers'
    ]);
Route::get('/accountant/report/customer/sales/{id}',
    [
        'as' => 'accountantReportCustomerSalesIndex',
        'uses' => 'Accountant\ReportsController@customerSales'
    ]);
Route::get('/accountant/report/customer/sales/print/{date}/{id}',
    [
        'as' => 'accountantReportCustomerSalesPrint',
        'uses' => 'Accountant\ReportsController@customerSalesPrint'
    ]);

Route::get('/accountant/report/payment',
    [
        'as' => 'accountantReportPaymentIndex',
        'uses' => 'Accountant\ReportsController@payment'
    ]);
Route::get('/accountant/report/payment/print/{option}/{month}/{year}',
    [
        'as' => 'accountantReportPaymentPrint',
        'uses' => 'Accountant\ReportsController@paymentPrint'
    ]);

Route::get('/accountant/report/delivery',
    [
        'as' => 'accountantReportDeliveryIndex',
        'uses' => 'Accountant\ReportsController@delivery'
    ]);
Route::get('/accountant/report/delivery/print/{option}/{day}/{month}',
    [
        'as' => 'accountantReportDeliveryPrint',
        'uses' => 'Accountant\ReportsController@deliveryPrint'
    ]);

Route::get('/accountant/report/stat',
    [
        'as' => 'accountantReportStatIndex',
        'uses' => 'Accountant\ReportsController@stat'
    ]);
Route::get('/accountant/report/stat/print/{month}/{year}',
    [
        'as' => 'accountantReportStatPrint',
        'uses' => 'Accountant\ReportsController@statPrint'
    ]);

Route::get('/accountant/report/incomestatement',
    [
        'as' => 'accountantReportIncomeStatementIndex',
        'uses' => 'Accountant\ReportsController@incomeStatement'
    ]);
Route::get('/accountant/report/incomeStatement/print/{month}/{year}',
    [
        'as' => 'accountantReportIncomeStatementPrint',
        'uses' => 'Accountant\ReportsController@incomeStatementPrint'
    ]);






/* =============================Secretary=========================== */

// Home
Route::get('/secretary',
    function(){
        return view('secretary.home');
    });

// Customer
Route::get('/secretary/customer',
    [
        'as' => 'secretaryCustomerIndex',
        'uses' => 'Secretary\CustomerController@index'
    ]);
Route::get('/secretary/cutomer/create',
    [
        'as' => 'secretaryCustomerCreate',
        'uses' => 'Secretary\CustomerController@create'
    ]);
Route::post('/secretary/customer/store',
    [
        'as' => 'secretaryCustomerStore',
        'uses' => 'Secretary\CustomerController@store'
    ]);
Route::get('/secretary/customer/edit/{id}',
    [
        'as' => 'secretaryCustomerEdit',
        'uses' => 'Secretary\CustomerController@edit'
    ]);
Route::patch('/secretary/customer/update/{id}',
    [
        'as' => 'secretaryCustomerUpdate',
        'uses' => 'Secretary\CustomerController@update'
    ]);
Route::get('/secretary/customer/destroy/{id}',
    [
        'as' => 'secretaryCustomerDestroy',
        'uses' => 'Secretary\CustomerController@destroy'
    ]);



// Transactions
Route::get('/secretary/transactions/customer/{id}',
    [
        'as' => 'secretaryTransactionsIndex',
        'uses' => 'Secretary\TransactionsController@index'
    ]);



// Sales Details
Route::get('/secretary/customer/sales/details/{id}',
    [
        'as' => 'secretarySalesDetailsIndex',
        'uses' => 'Secretary\SalesDetailsController@index'
    ]);
Route::get('/secretary/customer/sales/print/details/{id}',
    [
        'as' => 'secretarySalesDetailsPrint',
        'uses' => 'Secretary\SalesDetailsController@printInvoice'
    ]);



// Sales
Route::get('/secretary/sales',
    [
        'as' => 'secretarySalesIndex',
        'uses' => 'Secretary\SalesController@index'
    ]);
Route::post('/secretary/sales/create',
    [
        'as' => 'secretarySalesCreate',
        'uses' => 'Secretary\SalesController@create'
    ]);
Route::get('/secretary/sales/editCustomer/{id}',
    [
        'as' => 'secretarySalesEdit',
        'uses' => 'Secretary\SalesController@editCustomer'
    ]);
Route::patch('/secretary/sales/updateCustomer/{id}',
    [
        'as' => 'secretarySalesUpdate',
        'uses' => 'Secretary\SalesController@updateCustomer'
    ]);
Route::get('/secretary/sales/summary/{id}',
    [
        'as' => 'secretarySalesSummary',
        'uses' => 'Secretary\SalesController@summary'
    ]);
Route::get('/secretary/sales/summary/print/{id}',
    [
        'as' => 'secretarySalesSummaryPrint',
        'uses' => 'Secretary\SalesController@printSummary'
    ]);



//Credit
Route::get('/secretary/credit',
    [
        'as' => 'secretaryCreditIndex',
        'uses' => 'Secretary\CreditController@index'
    ]);
Route::get('/secretary/credit/create/payment/{id}',
    [
        'as' => 'secretaryCreditCreatePayment',
        'uses' => 'Secretary\CreditController@createPayment'
    ]);
Route::post('/secretary/credit/store/payment',
    [
        'as' => 'secretaryCreditPaymentStore',
        'uses' => 'Secretary\CreditController@storePayment'
    ]);
Route::get('/secretary/credit/payment/history/{id}',
    [
        'as' => 'secretaryCreditPaymentHistory',
        'uses' => 'Secretary\CreditController@paymentHistory'
    ]);



// Orders
Route::post('/secretary/sales',
    [
        'as' => 'secretaryOrdersCreate',
        'uses' => 'Secretary\OrdersController@store'
    ]);
Route::get('/secretary/sales/destroy/{id}',
    [
        'as' => 'secretaryDestroyOrder',
        'uses' => 'Secretary\OrdersController@destroy'
    ]);



// Products
Route::get('/secretary/products',
    [
        'as' => 'secretaryProductsIndex',
        'uses' => 'Secretary\ProductsController@index'
    ]);
Route::get('/secretary/products/create',
    [
        'as' => 'secretaryProductsCreate',
        'uses' => 'Secretary\ProductsController@create'
    ]);
Route::post('/secretary/products/store',
    [
        'as' => 'secretaryProductStore',
        'uses' => 'Secretary\ProductsController@store'
    ]);
Route::get('/secretary/products/edit/{id}',
    [
        'as' => 'secretaryProductsEdit',
        'uses' => 'Secretary\ProductsController@edit'
    ]);
Route::patch('/secretary/products/update/{id}',
    [
        'as' => 'secretaryProductsUpdate',
        'uses' => 'Secretary\ProductsController@update'
    ]);
Route::get('/secretary/products/set/status/{id}',
    [
        'as' => 'secretaryProductStatus',
        'uses' => 'Secretary\ProductsController@setStatus'
    ]);
    
    

// Category
Route::get('/secretary/category',
    [
        'as' => 'secretaryCategoryIndex',
        'uses' => 'Secretary\CategoryController@index'
    ]);
Route::get('/secretary/category/create',
    [
        'as' => 'secretaryCategoryCreate',
        'uses' => 'Secretary\CategoryController@create'
    ]);
Route::post('/secretary/category/store',
    [
        'as' => 'secretaryCategoryStore',
        'uses' => 'Secretary\CategoryController@store'
    ]);
Route::get('/secretary/category/edit/{id}',
    [
        'as' => 'secretaryCategoryEdit',
        'uses' => 'Secretary\CategoryController@edit'
    ]);
Route::patch('/secretary/category/update/{id}',
    [
        'as' => 'secretaryCategoryUpdate',
        'uses' => 'Secretary\CategoryController@update'
    ]);




// Supplier
Route::get('/secretary/supplier',
    [
        'as' => 'secretarySupplierIndex',
        'uses' => 'Secretary\SupplierController@index'
    ]);
Route::get('/secretary/supplier/create',
    [
        'as' => 'secretarySupplierCreate',
        'uses' => 'Secretary\SupplierController@create'
    ]);
Route::post('/secretary/supplier/store',
    [
        'as' => 'secretarySupplierStore',
        'uses' => 'Secretary\SupplierController@store'
    ]);
Route::get('/secretary/supplier/edit/{id}',
    [
        'as' => 'secretarySupplierEdit',
        'uses' => 'Secretary\SupplierController@edit'
    ]);
Route::patch('/secretary/supplier/update/{id}',
    [
        'as' => 'secretarySupplierUpdate',
        'uses' => 'Secretary\SupplierController@update'
    ]);




// Deliveries
Route::get('/secretary/delivery',
    [
        'as' => 'secretaryDeliveryIndex',
        'uses' => 'Secretary\DeliveryController@index'
    ]);
Route::get('/secretary/delivery/create',
    [
        'as' => 'secretaryDeliveryCreate',
        'uses' => 'Secretary\DeliveryController@create'
    ]);
Route::post('/secretary/delivery/store',
    [
        'as' => 'secretaryDeliveryStore',
        'uses' => 'Secretary\DeliveryController@store'
    ]);
Route::get('/secretary/delivery/edit/{id}',
    [
        'as' => 'secretaryDeliveryEdit',
        'uses' => 'Secretary\DeliveryController@edit'
    ]);
Route::patch('/secretary/delivery/update/{id}',
    [
        'as' => 'secretaryDeliveryUpdate',
        'uses' => 'Secretary\DeliveryController@update'
    ]);



// Delivery Set
Route::post('/secretary/delivery-set/create',
    [
        'as' => 'secretaryDeliverySetStore',
        'uses' => 'Secretary\DeliverySetController@store'
    ]);
Route::get('/secretary/delivery-set/destroy/{id}',
    [
        'as' => 'secretaryDestroyDelivery-set',
        'uses' => 'Secretary\DeliverySetController@destroy'
    ]);



// Delivery Details
Route::get('/secretary/delivery-details/show/{id}',
    [
        'as' => 'secretaryDeliveryDetailsShow',
        'uses' => 'Secretary\DeliveryDetailsController@show'
    ]);



// Reports
Route::get('/secretary/report',
    [
        'as' => 'secretaryReportIndex',
        'uses' => 'Secretary\ReportsController@index'
    ]);
Route::get('/secretary/report/print/{option}/{day}/{month}',
    [
        'as' => 'secretaryReportPrint',
        'uses' => 'Secretary\ReportsController@printReport'
    ]);
Route::get('/secretary/inventory/report',
    [
        'as' => 'secretaryReportInventory',
        'uses' => 'Secretary\ReportsController@inventory'
    ]);
Route::get('/secretary/inventory/report/print/{category}',
    [
        'as' => 'secretaryReportInventoryPrint',
        'uses' => 'Secretary\ReportsController@printInventoryReport'
    ]);
Route::get('/secretary/report/sales',
    [
        'as' => 'secretaryReportSalesIndex',
        'uses' => 'Secretary\ReportsController@sales'
    ]);
Route::get('/secretary/report/sales/print/{option}/{year}/{month}',
    [
        'as' => 'secretaryReportSalesPrint',
        'uses' => 'Secretary\ReportsController@salesPrint'
    ]);

Route::get('/secretary/report/customers',
    [
        'as' => 'secretaryReportCustomerIndex',
        'uses' => 'Secretary\ReportsController@customers'
    ]);
Route::get('/secretary/report/customer/sales/{id}',
    [
        'as' => 'secretaryReportCustomerSalesIndex',
        'uses' => 'Secretary\ReportsController@customerSales'
    ]);
Route::get('/secretary/report/customer/sales/print/{date}/{id}',
    [
        'as' => 'secretaryReportCustomerSalesPrint',
        'uses' => 'Secretary\ReportsController@customerSalesPrint'
    ]);

Route::get('/secretary/report/payment',
    [
        'as' => 'secretaryReportPaymentIndex',
        'uses' => 'Secretary\ReportsController@payment'
    ]);
Route::get('/secretary/report/payment/print/{option}/{month}/{year}',
    [
        'as' => 'secretaryReportPaymentPrint',
        'uses' => 'Secretary\ReportsController@paymentPrint'
    ]);

Route::get('/secretary/report/delivery',
    [
        'as' => 'secretaryReportDeliveryIndex',
        'uses' => 'Secretary\ReportsController@delivery'
    ]);
Route::get('/secretary/report/delivery/print/{option}/{day}/{month}',
    [
        'as' => 'secretaryReportDeliveryPrint',
        'uses' => 'Secretary\ReportsController@deliveryPrint'
    ]);
Route::get('/secretary/report/stat',
    [
        'as' => 'secretaryReportStatIndex',
        'uses' => 'Secretary\ReportsController@stat'
    ]);
Route::get('/secretary/report/stat/print/{option}/{month}',
    [
        'as' => 'secretaryReportStatPrint',
        'uses' => 'Secretary\ReportsController@statPrint'
    ]);
Route::get('/secretary/report/incomestatement',
    [
        'as' => 'secretaryReportIncomeStatementIndex',
        'uses' => 'Secretary\ReportsController@incomeStatement'
    ]);
Route::get('/secretary/report/incomeStatement/print/{month}/{year}',
    [
        'as' => 'secretaryReportIncomeStatementPrint',
        'uses' => 'Secretary\ReportsController@incomeStatementPrint'
    ]);