<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

use App\Http\Controllers\Api\TestController;

Route::get('/ping', [TestController::class, 'ping']);

use App\Http\Controllers\Api\AuthController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

use App\Http\Controllers\UserController;

Route::get('/users', [UserController::class, 'index']);        // ดึงผู้ใช้ทั้งหมด
Route::get('/users/{id}', [UserController::class, 'show']);    // ดูรายชื่อผู้ใช้เดี่ยว
Route::post('/users', [UserController::class, 'store']);       // เพิ่มผู้ใช้ใหม่
Route::put('/users/{id}', [UserController::class, 'update']);  // อัปเดตข้อมูล
Route::delete('/users/{id}', [UserController::class, 'destroy']); // ลบผู้ใช้

use App\Http\Controllers\CategoryController;

Route::get('/categories', [CategoryController::class, 'index']);
Route::post('/categories', [CategoryController::class, 'store']);
Route::put('/categories/{id}', [CategoryController::class, 'update']);
Route::delete('/categories/{id}', [CategoryController::class, 'destroy']);

use App\Http\Controllers\ProductController;


Route::apiResource('products', ProductController::class);
Route::delete('/products/{id}', [ProductController::class, 'destroy']);

use App\Http\Controllers\CustomerController;

Route::apiResource('customers', CustomerController::class); 

use App\Http\Controllers\PaymentVoucherController;

Route::apiResource('payment-vouchers', PaymentVoucherController::class);
Route::patch('/payment-vouchers/{id}/status', [PaymentVoucherController::class, 'updateStatus']);

use App\Http\Controllers\ReceiptController;

Route::apiResource('receipts', ReceiptController::class);

use App\Http\Controllers\InvoiceController;

Route::apiResource('invoices', InvoiceController::class);
Route::patch('/invoices/{id}/status', [InvoiceController::class, 'updateStatus']);

use App\Http\Controllers\TaxInvoiceController;

Route::apiResource('tax-invoices', TaxInvoiceController::class);
Route::post('/tax-invoices/{id}/send-email', [TaxInvoiceController::class, 'sendEmail']);

use App\Http\Controllers\PurchaseOrderController;

Route::apiResource('purchase-orders', PurchaseOrderController::class);
Route::patch('/purchase-orders/{id}/status', [PurchaseOrderController::class, 'updateStatus']);

use App\Http\Controllers\QuotationController;

Route::apiResource('quotations', QuotationController::class);
Route::patch('/quotations/{id}/status', [QuotationController::class, 'updateStatus']);

use App\Http\Controllers\ReceiveVoucherController;

Route::apiResource('receive-vouchers', ReceiveVoucherController::class);

use App\Http\Controllers\WithholdingTaxController;

Route::apiResource('withholding-taxes', WithholdingTaxController::class);

use App\Http\Controllers\CompanySettingController;

Route::get('/company-settings', [CompanySettingController::class, 'index']);
Route::put('/company-settings', [CompanySettingController::class, 'update']);

use App\Http\Controllers\ProjectController;

Route::apiResource('projects', ProjectController::class);

