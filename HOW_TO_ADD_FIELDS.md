# คู่มือการเพิ่ม Field ใน Database (Laravel)

## 📋 สารบัญ
1. [การเพิ่ม Field ใหม่](#1-การเพิ่ม-field-ใหม่)
2. [การสร้าง Database ใหม่](#2-การสร้าง-database-ใหม่)
3. [การแก้ไขปัญหาที่พบบ่อย](#3-การแก้ไขปัญหาที่พบบ่อย)

---

## 1. การเพิ่ม Field ใหม่

### ขั้นตอนการเพิ่ม Field (4 ขั้นตอนหลัก)

#### ขั้นตอนที่ 1: สร้าง Migration File
```powershell
php artisan make:migration add_field_name_to_table_name
```

**ตัวอย่าง:**
```powershell
# เพิ่ม field customer_phone ใน receipts table
php artisan make:migration add_customer_phone_to_receipts_table

# เพิ่มหลาย fields ใน withholding_taxes table
php artisan make:migration add_payer_fields_to_withholding_taxes_table
```

---

#### ขั้นตอนที่ 2: แก้ไข Migration File

ไปที่ `database/migrations/` แล้วเปิดไฟล์ที่เพิ่งสร้าง

**ตัวอย่างการเพิ่ม 1 field:**
```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCustomerPhoneToReceiptsTable extends Migration
{
    public function up()
    {
        Schema::table('receipts', function (Blueprint $table) {
            // เพิ่ม column หลัง column ที่ระบุ
            $table->string('customer_phone', 20)->nullable()->after('customer_name');
        });
    }

    public function down()
    {
        Schema::table('receipts', function (Blueprint $table) {
            // ลบ column เมื่อ rollback
            $table->dropColumn('customer_phone');
        });
    }
}
```

**ตัวอย่างการเพิ่มหลาย fields:**
```php
public function up()
{
    Schema::table('receipts', function (Blueprint $table) {
        $table->string('customer_phone', 20)->nullable()->after('customer_name');
        $table->string('customer_email')->nullable()->after('customer_phone');
        $table->text('customer_address')->nullable()->after('customer_email');
    });
}

public function down()
{
    Schema::table('receipts', function (Blueprint $table) {
        $table->dropColumn(['customer_phone', 'customer_email', 'customer_address']);
    });
}
```

**ประเภทของ Field ที่ใช้บ่อย:**
```php
// String (ข้อความสั้น)
$table->string('field_name', 255)->nullable();

// Text (ข้อความยาว)
$table->text('field_name')->nullable();

// Integer (ตัวเลขเต็ม)
$table->integer('field_name')->nullable();

// Decimal (ตัวเลขทศนิยม)
$table->decimal('field_name', 10, 2)->nullable(); // 10 หลัก, 2 ทศนิยม

// Date (วันที่)
$table->date('field_name')->nullable();

// DateTime (วันที่และเวลา)
$table->dateTime('field_name')->nullable();

// Boolean (true/false)
$table->boolean('field_name')->default(false);

// Enum (ตัวเลือก)
$table->enum('field_name', ['option1', 'option2', 'option3'])->nullable();
```

---

#### ขั้นตอนที่ 3: อัพเดท Model

เปิดไฟล์ Model ที่ `app/Models/`

**ตัวอย่าง: `app/Models/Receipt.php`**
```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Receipt extends Model
{
    protected $fillable = [
        'receipt_no',
        'date',
        'customer',
        'customer_phone',      // ← เพิ่มตรงนี้
        'customer_email',      // ← เพิ่มตรงนี้
        'customer_address',    // ← เพิ่มตรงนี้
        'amount',
        'status',
    ];

    protected $casts = [
        'date' => 'date',
        'amount' => 'decimal:2',
    ];
}
```

**สำคัญ:** ต้องเพิ่ม field ใหม่ใน `$fillable` array เท่านั้น ถึงจะสามารถบันทึกข้อมูลได้

---

#### ขั้นตอนที่ 4: อัพเดท Controller (Validation)

เปิดไฟล์ Controller ที่ `app/Http/Controllers/`

**ตัวอย่าง: `app/Http/Controllers/ReceiptController.php`**
```php
public function store(Request $request)
{
    $validated = $request->validate([
        'receipt_no' => 'required|string|max:50',
        'date' => 'required|date',
        'customer' => 'required|string|max:255',
        'customer_phone' => 'nullable|string|max:20',        // ← เพิ่ม validation
        'customer_email' => 'nullable|email|max:255',        // ← เพิ่ม validation
        'customer_address' => 'nullable|string',             // ← เพิ่ม validation
        'amount' => 'required|numeric|min:0',
        'status' => 'required|in:ร่าง,รอออก,ออกแล้ว,ยกเลิก',
    ]);

    $receipt = Receipt::create($validated);
    return response()->json($receipt, 201);
}

public function update(Request $request, $id)
{
    $validated = $request->validate([
        'receipt_no' => 'required|string|max:50',
        'customer_phone' => 'nullable|string|max:20',        // ← เพิ่ม validation
        'customer_email' => 'nullable|email|max:255',        // ← เพิ่ม validation
        'customer_address' => 'nullable|string',             // ← เพิ่ม validation
        // ... fields อื่นๆ
    ]);

    $receipt = Receipt::findOrFail($id);
    $receipt->update($validated);
    return response()->json($receipt);
}
```

**Validation Rules ที่ใช้บ่อย:**
```php
'required'              // ต้องกรอก
'nullable'              // ไม่บังคับกรอก
'string'                // ต้องเป็น string
'max:255'               // ความยาวสูงสุด 255 ตัวอักษร
'min:0'                 // ค่าต่ำสุด 0
'email'                 // ต้องเป็นรูปแบบ email
'numeric'               // ต้องเป็นตัวเลข
'integer'               // ต้องเป็นเลขจำนวนเต็ม
'date'                  // ต้องเป็นวันที่
'in:value1,value2'      // ต้องเป็นค่าที่ระบุเท่านั้น
'unique:table,column'   // ต้องไม่ซ้ำในตาราง
```

---

#### ขั้นตอนที่ 5: Run Migration

```powershell
# ตรวจสอบสถานะ migration
php artisan migrate:status

# Run migration
php artisan migrate

# Clear cache
php artisan optimize:clear
```

---

## 2. การสร้าง Database ใหม่

### 2.1 สร้าง Model + Migration + Controller ทีเดียว

```powershell
# สร้างครบทุกอย่าง
php artisan make:model Product -mcr

# -m = สร้าง migration
# -c = สร้าง controller
# -r = เพิ่ม resource methods (index, create, store, show, edit, update, destroy)
```

---

### 2.2 ออกแบบ Migration

**ตัวอย่าง: สร้างตาราง products**

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();                                          // Primary key
            $table->string('product_code', 50)->unique();          // รหัสสินค้า (ไม่ซ้ำ)
            $table->string('product_name');                        // ชื่อสินค้า
            $table->text('description')->nullable();               // คำอธิบาย
            $table->decimal('price', 10, 2);                       // ราคา
            $table->integer('stock')->default(0);                  // จำนวนในสต็อก
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->foreignId('category_id')->nullable()           // Foreign key
                  ->constrained('categories')
                  ->onDelete('set null');
            $table->timestamps();                                  // created_at, updated_at
        });
    }

    public function down()
    {
        Schema::dropIfExists('products');
    }
}
```

---

### 2.3 กำหนด Model

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_code',
        'product_name',
        'description',
        'price',
        'stock',
        'status',
        'category_id',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'stock' => 'integer',
    ];

    // Relationship: Product belongs to Category
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
```

---

### 2.4 สร้าง Controller

```php
<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // แสดงรายการทั้งหมด
    public function index()
    {
        $products = Product::with('category')->orderBy('created_at', 'desc')->get();
        return response()->json($products);
    }

    // แสดงรายการเดียว
    public function show($id)
    {
        $product = Product::with('category')->findOrFail($id);
        return response()->json($product);
    }

    // สร้างใหม่
    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_code' => 'required|string|max:50|unique:products',
            'product_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'status' => 'required|in:active,inactive',
            'category_id' => 'nullable|exists:categories,id',
        ]);

        $product = Product::create($validated);

        return response()->json([
            'message' => 'สร้างสินค้าสำเร็จ',
            'data' => $product
        ], 201);
    }

    // อัพเดท
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'product_code' => 'required|string|max:50|unique:products,product_code,' . $id,
            'product_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'status' => 'required|in:active,inactive',
            'category_id' => 'nullable|exists:categories,id',
        ]);

        $product = Product::findOrFail($id);
        $product->update($validated);

        return response()->json([
            'message' => 'อัพเดทสินค้าสำเร็จ',
            'data' => $product
        ]);
    }

    // ลบ
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return response()->json([
            'message' => 'ลบสินค้าสำเร็จ'
        ]);
    }
}
```

---

### 2.5 เพิ่ม Routes

**ไฟล์: `routes/api.php`**
```php
use App\Http\Controllers\ProductController;

Route::apiResource('products', ProductController::class);

// สร้าง routes ทั้งหมดนี้อัตโนมัติ:
// GET    /api/products           -> index
// GET    /api/products/{id}      -> show
// POST   /api/products           -> store
// PUT    /api/products/{id}      -> update
// DELETE /api/products/{id}      -> destroy
```

---

### 2.6 Run Migration

```powershell
php artisan migrate
php artisan optimize:clear
```

---

## 3. การแก้ไขปัญหาที่พบบ่อย

### ปัญหาที่ 1: สร้าง Migration ผิด / พิมพ์ชื่อ field ผิด

**อาการ:** Field ถูกสร้างด้วยชื่อผิด หรือ type ผิด

**วิธีแก้:**

```powershell
# 1. Rollback migration ล่าสุด
php artisan migrate:rollback

# 2. แก้ไขไฟล์ migration
# 3. Run migration ใหม่
php artisan migrate
```

**ตัวอย่าง:** สร้าง `custmer_name` แต่ต้องการ `customer_name`

```php
// ✗ ก่อนแก้ไข (ผิด)
$table->string('custmer_name')->nullable();

// ✓ หลังแก้ไข (ถูก)
$table->string('customer_name')->nullable();
```

---

### ปัญหาที่ 2: Column Already Exists (มี column ซ้ำ)

**อาการ:** 
```
SQLSTATE[42S21]: Column already exists: 1060 Duplicate column name 'field_name'
```

**สาเหตุ:** มี migration 2 ไฟล์ที่พยายามสร้าง field เดียวกัน

**วิธีแก้:**

```powershell
# 1. ตรวจสอบ migration ที่ยังไม่ run
php artisan migrate:status

# 2. ลบไฟล์ migration ที่ซ้ำ
Remove-Item "database/migrations/2025_11_13_xxxxxx_duplicate_migration.php"

# 3. หรือแก้ไข migration ให้ตรวจสอบก่อนสร้าง
```

**ตัวอย่างการแก้ไขใน migration:**
```php
public function up()
{
    Schema::table('receipts', function (Blueprint $table) {
        // ตรวจสอบว่ามี column แล้วหรือยัง
        if (!Schema::hasColumn('receipts', 'customer_phone')) {
            $table->string('customer_phone', 20)->nullable();
        }
    });
}
```

---

### ปัญหาที่ 3: Field ไม่บันทึกลง Database

**อาการ:** ส่งข้อมูลจาก frontend แล้วแต่ไม่เข้า database

**สาเหตุ:** ลืมเพิ่ม field ใน `$fillable` ของ Model

**วิธีแก้:**

```php
// ✗ ก่อนแก้ไข (ไม่มี field ใหม่)
protected $fillable = [
    'receipt_no',
    'date',
    'customer',
];

// ✓ หลังแก้ไข (เพิ่ม field ใหม่)
protected $fillable = [
    'receipt_no',
    'date',
    'customer',
    'customer_phone',    // ← เพิ่ม
    'customer_email',    // ← เพิ่ม
];
```

```powershell
# Clear cache หลังแก้ไข Model
php artisan optimize:clear
```

---

### ปัญหาที่ 4: Validation Error (ส่งข้อมูลไม่ผ่าน)

**อาการ:** Frontend ส่งข้อมูลมา แต่ Backend ตอบกลับว่า validation error

**สาเหตุ:** ลืมเพิ่ม validation rules ใน Controller

**วิธีแก้:**

```php
// ✗ ก่อนแก้ไข (ไม่มี validation สำหรับ field ใหม่)
public function store(Request $request)
{
    $validated = $request->validate([
        'receipt_no' => 'required|string',
        'customer' => 'required|string',
    ]);
    
    $receipt = Receipt::create($validated);
}

// ✓ หลังแก้ไข (เพิ่ม validation)
public function store(Request $request)
{
    $validated = $request->validate([
        'receipt_no' => 'required|string',
        'customer' => 'required|string',
        'customer_phone' => 'nullable|string|max:20',   // ← เพิ่ม
        'customer_email' => 'nullable|email',           // ← เพิ่ม
    ]);
    
    $receipt = Receipt::create($validated);
}
```

---

### ปัญหาที่ 5: Migration ไม่ลำดับตามที่ต้องการ

**อาการ:** Migration file ถูกสร้างไม่เรียงตามลำดับ หรือต้องการรัน migration ก่อน/หลัง

**วิธีแก้:**

```powershell
# 1. Rollback migration ทั้งหมด
php artisan migrate:rollback --step=5  # rollback 5 migrations ล่าสุด

# 2. เปลี่ยนชื่อไฟล์ migration (เปลี่ยนเลขหน้า timestamp)
# ตัวอย่าง:
# 2025_11_13_070000_create_products_table.php
# 2025_11_13_080000_create_categories_table.php

# 3. Run migration ใหม่
php artisan migrate
```

---

### ปัญหาที่ 6: ต้องการลบ Field ที่สร้างไปแล้ว

**วิธีแก้:**

```powershell
# 1. สร้าง migration ใหม่
php artisan make:migration remove_customer_phone_from_receipts_table
```

```php
// 2. แก้ไข migration
public function up()
{
    Schema::table('receipts', function (Blueprint $table) {
        $table->dropColumn('customer_phone');
    });
}

public function down()
{
    Schema::table('receipts', function (Blueprint $table) {
        // กู้คืนถ้า rollback
        $table->string('customer_phone', 20)->nullable();
    });
}
```

```powershell
# 3. Run migration
php artisan migrate
```

**ลบหลาย columns พร้อมกัน:**
```php
public function up()
{
    Schema::table('receipts', function (Blueprint $table) {
        $table->dropColumn(['customer_phone', 'customer_email', 'customer_address']);
    });
}
```

---

### ปัญหาที่ 7: ต้องการเปลี่ยน Type ของ Field

**วิธีแก้:**

```powershell
# 1. ติดตั้ง doctrine/dbal (ถ้ายังไม่มี)
composer require doctrine/dbal

# 2. สร้าง migration
php artisan make:migration change_customer_phone_type_in_receipts_table
```

```php
// 3. แก้ไข migration
public function up()
{
    Schema::table('receipts', function (Blueprint $table) {
        // เปลี่ยนจาก string เป็น integer
        $table->integer('customer_phone')->nullable()->change();
    });
}

public function down()
{
    Schema::table('receipts', function (Blueprint $table) {
        // เปลี่ยนกลับ
        $table->string('customer_phone', 20)->nullable()->change();
    });
}
```

```powershell
# 4. Run migration
php artisan migrate
```

---

### ปัญหาที่ 8: Migration ติด Error และต้องการเริ่มใหม่

**วิธีแก้แบบรีเซ็ตทั้งหมด (ระวัง: จะลบข้อมูลทั้งหมด):**

```powershell
# 1. Rollback ทั้งหมด
php artisan migrate:reset

# 2. Run migration ใหม่ทั้งหมด
php artisan migrate

# 3. หรือใช้คำสั่งเดียว (fresh)
php artisan migrate:fresh
```

**วิธีแก้แบบปลอดภัย (ไม่ลบข้อมูล):**

```powershell
# 1. ลบ record ของ migration ที่มีปัญหาออกจาก table migrations
# เข้า database โดยตรง และ run:
DELETE FROM migrations WHERE migration = '2025_11_13_070000_problematic_migration';

# 2. ลบหรือแก้ไขไฟล์ migration ที่มีปัญหา

# 3. Run migration อีกครั้ง
php artisan migrate
```

---

### ปัญหาที่ 9: Cache ไม่อัพเดท

**อาการ:** แก้โค้ดแล้วแต่ยังใช้โค้ดเก่า

**วิธีแก้:**

```powershell
# Clear cache ทั้งหมด
php artisan optimize:clear

# หรือ clear แยกเป็นรายตัว
php artisan config:clear    # Clear config cache
php artisan route:clear     # Clear route cache
php artisan view:clear      # Clear view cache
php artisan cache:clear     # Clear application cache
```

---

## 📊 Checklist เมื่อเพิ่ม Field ใหม่

- [ ] 1. สร้าง migration file
- [ ] 2. แก้ไข migration (up และ down)
- [ ] 3. เพิ่ม field ใน Model `$fillable`
- [ ] 4. เพิ่ม validation ใน Controller (`store` และ `update`)
- [ ] 5. Run migration: `php artisan migrate`
- [ ] 6. Clear cache: `php artisan optimize:clear`
- [ ] 7. ทดสอบ API ด้วย Postman หรือ curl
- [ ] 8. อัพเดท frontend TypeScript interface (ถ้ามี)

---

## 🔧 คำสั่งที่ใช้บ่อย

```powershell
# Migration
php artisan make:migration create_table_name              # สร้างตารางใหม่
php artisan make:migration add_field_to_table             # เพิ่ม field
php artisan migrate                                       # Run migration
php artisan migrate:status                                # ดูสถานะ
php artisan migrate:rollback                              # ยกเลิกล่าสุด
php artisan migrate:rollback --step=2                     # ยกเลิก 2 migrations
php artisan migrate:reset                                 # ยกเลิกทั้งหมด
php artisan migrate:fresh                                 # Drop + Migrate ใหม่

# Model
php artisan make:model ModelName                          # สร้าง model
php artisan make:model ModelName -m                       # + migration
php artisan make:model ModelName -mc                      # + migration + controller
php artisan make:model ModelName -mcr                     # + resource controller

# Controller
php artisan make:controller ControllerName                # สร้าง controller
php artisan make:controller ControllerName --resource     # Resource controller

# Cache
php artisan optimize:clear                                # Clear ทั้งหมด
php artisan config:clear                                  # Clear config
php artisan route:clear                                   # Clear routes
php artisan cache:clear                                   # Clear cache

# Database
php artisan db:seed                                       # Run seeder
php artisan migrate:fresh --seed                          # Fresh + Seed

# Syntax Check
php -l app/Models/ModelName.php                           # ตรวจสอบ syntax
php -l app/Http/Controllers/ControllerName.php
```

---

## 💡 เคล็ดลับเพิ่มเติม

### 1. ใช้ Git สำหรับการทำงาน
```powershell
# สร้าง branch ก่อนแก้ไข
git checkout -b feature/add-customer-fields

# Commit เมื่อทำงานเสร็จแต่ละส่วน
git add .
git commit -m "Add customer phone and email fields"
```

### 2. Backup Database ก่อนทำงาน
```powershell
# Export database (ใช้ใน PhpMyAdmin หรือ MySQL Workbench)
# หรือใช้คำสั่ง mysqldump
```

### 3. ทดสอบ API ด้วย Postman
- สร้าง Collection สำหรับทุก endpoint
- ทดสอบ GET, POST, PUT, DELETE
- ตรวจสอบว่า field ใหม่บันทึกและแสดงผลถูกต้อง

### 4. ตั้งชื่อ Field ให้สื่อความหมาย
```
✓ ดี:    customer_phone, customer_email, customer_tax_id
✗ ไม่ดี: phone, mail, tax
```

### 5. ใช้ nullable() สำหรับ field ที่ไม่บังคับ
```php
$table->string('customer_phone')->nullable();  // ไม่บังคับกรอก
$table->string('customer_name');               // บังคับกรอก
```

---

## 🎯 สรุป

1. **เพิ่ม Field** = Migration → Model → Controller → Migrate → Clear Cache
2. **สร้าง Table** = Model + Migration → Design Schema → Controller → Routes → Migrate
3. **แก้ไขปัญหา** = Rollback → แก้ไข → Migrate ใหม่ → Clear Cache

**อย่าลืม:** ทดสอบทุกครั้งหลังแก้ไข!

---

## 📚 อ่านเพิ่มเติม

- [Laravel Migrations Documentation](https://laravel.com/docs/migrations)
- [Laravel Eloquent Documentation](https://laravel.com/docs/eloquent)
- [Laravel Validation Documentation](https://laravel.com/docs/validation)

---

---

## 4. การเชื่อม Backend กับ Frontend

### 4.1 ตรวจสอบ Backend ก่อน

#### ตรวจสอบว่า Backend Server รันอยู่

```powershell
# ตรวจสอบว่า port 8000 มี service รันอยู่หรือไม่
Get-NetTCPConnection -LocalPort 8000 -ErrorAction SilentlyContinue
```

**ถ้ายังไม่รัน ให้รัน Laravel server:**
```powershell
cd C:\Users\ADMIN\Desktop\SAB\sab-backend
php artisan serve
# หรือ
php artisan serve --host=127.0.0.1 --port=8000
```

#### ตรวจสอบ Routes

```powershell
# ดู routes ทั้งหมด
php artisan route:list

# ดู routes เฉพาะ API
php artisan route:list --path=api

# ดู routes เฉพาะตาราง receipts
php artisan route:list --path=api/receipts
```

**ตัวอย่างผลลัพธ์ที่ควรเห็น:**
```
+--------+----------+-------------------------+------------------+
| Method | URI      | Name                    | Action           |
+--------+----------+-------------------------+------------------+
| GET    | api/receipts                           | receipts.index   |
| POST   | api/receipts                           | receipts.store   |
| GET    | api/receipts/{id}                      | receipts.show    |
| PUT    | api/receipts/{id}                      | receipts.update  |
| DELETE | api/receipts/{id}                      | receipts.destroy |
+--------+----------+-------------------------+------------------+
```

#### ทดสอบ API ด้วย PowerShell

```powershell
# ทดสอบ GET all records
Invoke-RestMethod -Uri "http://localhost:8000/api/receipts" -Method Get -Headers @{"Accept"="application/json"}

# ทดสอบ GET record เดียว
Invoke-RestMethod -Uri "http://localhost:8000/api/receipts/1" -Method Get -Headers @{"Accept"="application/json"}

# ทดสอบ POST (สร้างใหม่)
$body = @{
    receipt_no = "REC001"
    date = "2025-11-14"
    customer = "Test Customer"
    customer_phone = "0812345678"
    customer_email = "test@example.com"
    amount = 1000
    status = "ร่าง"
} | ConvertTo-Json

Invoke-RestMethod -Uri "http://localhost:8000/api/receipts" -Method Post -Body $body -ContentType "application/json" -Headers @{"Accept"="application/json"}
```

---

### 4.2 ตรวจสอบ CORS Configuration

**CORS** = Cross-Origin Resource Sharing (อนุญาตให้ Frontend เรียกใช้ Backend จากคนละ domain)

#### ตรวจสอบไฟล์ `config/cors.php`

```php
<?php

return [
    'paths' => ['api/*', 'sanctum/csrf-cookie'],
    
    'allowed_methods' => ['*'],  // อนุญาตทุก method (GET, POST, PUT, DELETE)
    
    'allowed_origins' => [
        'http://127.0.0.1:5173',    // ← เพิ่ม Frontend URL
        'http://localhost:5173',     // ← เพิ่ม Frontend URL
    ],
    
    'allowed_origins_patterns' => [],
    
    'allowed_headers' => ['*'],  // อนุญาตทุก header
    
    'exposed_headers' => [],
    
    'max_age' => 0,
    
    'supports_credentials' => true,  // อนุญาตให้ส่ง cookies
];
```

**ถ้าแก้ไข CORS ต้อง clear cache:**
```powershell
php artisan config:clear
php artisan optimize:clear
```

---

### 4.3 เตรียม Frontend (TypeScript/React)

#### ขั้นตอนที่ 1: ตรวจสอบว่า Frontend Server รันอยู่

```powershell
cd C:\Users\ADMIN\Desktop\SAB\sab-frontend

# ตรวจสอบว่า port 5173 มี service รันอยู่
Get-NetTCPConnection -LocalPort 5173 -ErrorAction SilentlyContinue

# ถ้ายังไม่รัน
npm run dev
# หรือ
yarn dev
```

---

#### ขั้นตอนที่ 2: สร้าง/ตรวจสอบไฟล์ API Configuration

**ไฟล์: `src/services/api.ts`**

```typescript
import axios from 'axios';

// Base API URL - กำหนด URL ของ Backend
const API_BASE_URL = 'http://127.0.0.1:8000/api';

// สร้าง axios instance พร้อม config พื้นฐาน
export const apiClient = axios.create({
  baseURL: API_BASE_URL,
  headers: {
    'Content-Type': 'application/json',
    'Accept': 'application/json',
  },
  // timeout: 10000, // timeout 10 วินาที (optional)
});

// Interceptor สำหรับ request (ถ้าต้องการใส่ token)
apiClient.interceptors.request.use(
  (config) => {
    // เพิ่ม Authorization token ถ้ามี
    const token = localStorage.getItem('token');
    if (token) {
      config.headers.Authorization = `Bearer ${token}`;
    }
    return config;
  },
  (error) => {
    return Promise.reject(error);
  }
);

// Interceptor สำหรับ response (จัดการ error)
apiClient.interceptors.response.use(
  (response) => {
    return response;
  },
  (error) => {
    // จัดการ error แบบรวม
    if (error.response) {
      // Server ตอบกลับมาพร้อม error status
      console.error('API Error:', error.response.data);
      
      // ถ้าเป็น 401 Unauthorized ให้ redirect ไป login
      if (error.response.status === 401) {
        // window.location.href = '/login';
      }
    } else if (error.request) {
      // Request ถูกส่งไปแล้วแต่ไม่ได้รับ response
      console.error('Network Error:', error.request);
    } else {
      // เกิด error ตอน setup request
      console.error('Error:', error.message);
    }
    return Promise.reject(error);
  }
);

export default apiClient;
```

---

#### ขั้นตอนที่ 3: สร้าง TypeScript Interface

**ไฟล์: `src/types/receipt.ts`** (หรือในไฟล์ service)

```typescript
// Interface สำหรับ Receipt
export interface Receipt {
  id?: number;
  receipt_no: string;
  date: string;
  customer: string;
  customer_address?: string;      // ← Field ใหม่
  customer_tax_id?: string;       // ← Field ใหม่
  customer_phone?: string;        // ← Field ใหม่
  customer_email?: string;        // ← Field ใหม่
  invoice_ref?: string;
  amount: number;
  description?: string;
  status: 'ร่าง' | 'รอออก' | 'ออกแล้ว' | 'ยกเลิก';
  doc_type?: 'original' | 'copy';
  doc_type_label?: string;        // Thai label from backend
  created_at?: string;
  updated_at?: string;
}

// Interface สำหรับ Form Data (ไม่มี id, timestamps)
export interface ReceiptFormData {
  receipt_no: string;
  date: string;
  customer: string;
  customer_address?: string;
  customer_tax_id?: string;
  customer_phone?: string;
  customer_email?: string;
  invoice_ref?: string;
  amount: number;
  description?: string;
  status: 'ร่าง' | 'รอออก' | 'ออกแล้ว' | 'ยกเลิก';
  doc_type?: 'original' | 'copy';
}

// Interface สำหรับ API Response
export interface ReceiptResponse {
  message: string;
  data: Receipt;
}

export interface ReceiptsListResponse {
  data?: Receipt[];
  // หรือถ้า backend ส่งเป็น array โดยตรง
  // แล้วแต่ backend response format
}
```

---

#### ขั้นตอนที่ 4: สร้าง Service Function

**ไฟล์: `src/services/receiptService.ts`**

```typescript
import { apiClient } from './api';
import { Receipt, ReceiptFormData, ReceiptResponse, ReceiptsListResponse } from '../types/receipt';

// Base path สำหรับ receipts API
const RECEIPT_PATH = '/receipts';

// 1. ดึงรายการทั้งหมด (GET /api/receipts)
export const getAllReceipts = async (): Promise<Receipt[]> => {
  try {
    const response = await apiClient.get<Receipt[]>(RECEIPT_PATH);
    return response.data;
  } catch (error) {
    console.error('Error fetching receipts:', error);
    throw error;
  }
};

// 2. ดึงรายการเดียว (GET /api/receipts/{id})
export const getReceiptById = async (id: number): Promise<Receipt> => {
  try {
    const response = await apiClient.get<Receipt>(`${RECEIPT_PATH}/${id}`);
    return response.data;
  } catch (error) {
    console.error(`Error fetching receipt ${id}:`, error);
    throw error;
  }
};

// 3. สร้างใหม่ (POST /api/receipts)
export const createReceipt = async (data: ReceiptFormData): Promise<Receipt> => {
  try {
    const response = await apiClient.post<ReceiptResponse>(RECEIPT_PATH, data);
    return response.data.data;  // ถ้า backend ส่ง { message, data }
    // หรือ return response.data; ถ้า backend ส่ง Receipt โดยตรง
  } catch (error) {
    console.error('Error creating receipt:', error);
    throw error;
  }
};

// 4. อัพเดท (PUT /api/receipts/{id})
export const updateReceipt = async (id: number, data: ReceiptFormData): Promise<Receipt> => {
  try {
    const response = await apiClient.put<ReceiptResponse>(`${RECEIPT_PATH}/${id}`, data);
    return response.data.data;
  } catch (error) {
    console.error(`Error updating receipt ${id}:`, error);
    throw error;
  }
};

// 5. ลบ (DELETE /api/receipts/{id})
export const deleteReceipt = async (id: number): Promise<void> => {
  try {
    await apiClient.delete(`${RECEIPT_PATH}/${id}`);
  } catch (error) {
    console.error(`Error deleting receipt ${id}:`, error);
    throw error;
  }
};

// 6. ฟังก์ชันเพิ่มเติม: ค้นหา
export const searchReceipts = async (keyword: string): Promise<Receipt[]> => {
  try {
    const response = await apiClient.get<Receipt[]>(`${RECEIPT_PATH}?search=${keyword}`);
    return response.data;
  } catch (error) {
    console.error('Error searching receipts:', error);
    throw error;
  }
};

// 7. ฟังก์ชันเพิ่มเติม: กรองตามสถานะ
export const getReceiptsByStatus = async (status: string): Promise<Receipt[]> => {
  try {
    const response = await apiClient.get<Receipt[]>(`${RECEIPT_PATH}?status=${status}`);
    return response.data;
  } catch (error) {
    console.error('Error fetching receipts by status:', error);
    throw error;
  }
};

export default {
  getAllReceipts,
  getReceiptById,
  createReceipt,
  updateReceipt,
  deleteReceipt,
  searchReceipts,
  getReceiptsByStatus,
};
```

---

#### ขั้นตอนที่ 5: ใช้งานใน React Component

**ตัวอย่าง: รายการทั้งหมด (List Component)**

```typescript
// src/components/ReceiptList.tsx
import React, { useState, useEffect } from 'react';
import { getAllReceipts, deleteReceipt } from '../services/receiptService';
import { Receipt } from '../types/receipt';

const ReceiptList: React.FC = () => {
  const [receipts, setReceipts] = useState<Receipt[]>([]);
  const [loading, setLoading] = useState<boolean>(true);
  const [error, setError] = useState<string | null>(null);

  // ดึงข้อมูลตอน component mount
  useEffect(() => {
    fetchReceipts();
  }, []);

  const fetchReceipts = async () => {
    try {
      setLoading(true);
      setError(null);
      const data = await getAllReceipts();
      setReceipts(data);
    } catch (err: any) {
      setError(err.message || 'เกิดข้อผิดพลาดในการดึงข้อมูล');
      console.error('Error:', err);
    } finally {
      setLoading(false);
    }
  };

  const handleDelete = async (id: number) => {
    if (!window.confirm('ต้องการลบใบเสร็จนี้หรือไม่?')) return;
    
    try {
      await deleteReceipt(id);
      // ดึงข้อมูลใหม่หลังลบ
      fetchReceipts();
      alert('ลบสำเร็จ');
    } catch (err: any) {
      alert('ลบไม่สำเร็จ: ' + err.message);
    }
  };

  if (loading) return <div>กำลังโหลด...</div>;
  if (error) return <div>Error: {error}</div>;

  return (
    <div className="receipt-list">
      <h1>รายการใบเสร็จ</h1>
      <button onClick={fetchReceipts}>รีเฟรช</button>
      
      <table>
        <thead>
          <tr>
            <th>เลขที่</th>
            <th>วันที่</th>
            <th>ลูกค้า</th>
            <th>โทรศัพท์</th>
            <th>อีเมล</th>
            <th>ยอดเงิน</th>
            <th>สถานะ</th>
            <th>จัดการ</th>
          </tr>
        </thead>
        <tbody>
          {receipts.map((receipt) => (
            <tr key={receipt.id}>
              <td>{receipt.receipt_no}</td>
              <td>{new Date(receipt.date).toLocaleDateString('th-TH')}</td>
              <td>{receipt.customer}</td>
              <td>{receipt.customer_phone || '-'}</td>
              <td>{receipt.customer_email || '-'}</td>
              <td>{receipt.amount.toLocaleString('th-TH')} บาท</td>
              <td>{receipt.status}</td>
              <td>
                <button onClick={() => handleDelete(receipt.id!)}>ลบ</button>
              </td>
            </tr>
          ))}
        </tbody>
      </table>
    </div>
  );
};

export default ReceiptList;
```

---

**ตัวอย่าง: ฟอร์มสร้าง/แก้ไข (Form Component)**

```typescript
// src/components/ReceiptForm.tsx
import React, { useState, useEffect } from 'react';
import { useNavigate, useParams } from 'react-router-dom';
import { createReceipt, updateReceipt, getReceiptById } from '../services/receiptService';
import { ReceiptFormData } from '../types/receipt';

const ReceiptForm: React.FC = () => {
  const navigate = useNavigate();
  const { id } = useParams<{ id: string }>();
  const isEditMode = Boolean(id);

  const [formData, setFormData] = useState<ReceiptFormData>({
    receipt_no: '',
    date: new Date().toISOString().split('T')[0],
    customer: '',
    customer_address: '',
    customer_tax_id: '',
    customer_phone: '',
    customer_email: '',
    invoice_ref: '',
    amount: 0,
    description: '',
    status: 'ร่าง',
    doc_type: 'original',
  });

  const [loading, setLoading] = useState<boolean>(false);
  const [errors, setErrors] = useState<any>({});

  // ถ้าเป็นโหมดแก้ไข ให้ดึงข้อมูลเดิม
  useEffect(() => {
    if (isEditMode && id) {
      fetchReceipt(parseInt(id));
    }
  }, [id]);

  const fetchReceipt = async (receiptId: number) => {
    try {
      const data = await getReceiptById(receiptId);
      setFormData({
        receipt_no: data.receipt_no,
        date: data.date,
        customer: data.customer,
        customer_address: data.customer_address || '',
        customer_tax_id: data.customer_tax_id || '',
        customer_phone: data.customer_phone || '',
        customer_email: data.customer_email || '',
        invoice_ref: data.invoice_ref || '',
        amount: data.amount,
        description: data.description || '',
        status: data.status,
        doc_type: data.doc_type || 'original',
      });
    } catch (err) {
      console.error('Error fetching receipt:', err);
      alert('ไม่สามารถดึงข้อมูลได้');
    }
  };

  const handleChange = (e: React.ChangeEvent<HTMLInputElement | HTMLTextAreaElement | HTMLSelectElement>) => {
    const { name, value } = e.target;
    setFormData(prev => ({
      ...prev,
      [name]: name === 'amount' ? parseFloat(value) : value
    }));
    // ล้าง error ของ field นั้น
    if (errors[name]) {
      setErrors((prev: any) => ({ ...prev, [name]: null }));
    }
  };

  const handleSubmit = async (e: React.FormEvent) => {
    e.preventDefault();
    setLoading(true);
    setErrors({});

    try {
      if (isEditMode && id) {
        // แก้ไข
        await updateReceipt(parseInt(id), formData);
        alert('อัพเดทสำเร็จ');
      } else {
        // สร้างใหม่
        await createReceipt(formData);
        alert('สร้างสำเร็จ');
      }
      navigate('/receipts'); // กลับไปหน้ารายการ
    } catch (err: any) {
      console.error('Error submitting form:', err);
      
      // จัดการ validation errors จาก backend
      if (err.response && err.response.data.errors) {
        setErrors(err.response.data.errors);
      } else {
        alert('เกิดข้อผิดพลาด: ' + (err.message || 'Unknown error'));
      }
    } finally {
      setLoading(false);
    }
  };

  return (
    <div className="receipt-form">
      <h1>{isEditMode ? 'แก้ไขใบเสร็จ' : 'สร้างใบเสร็จใหม่'}</h1>
      
      <form onSubmit={handleSubmit}>
        {/* เลขที่ใบเสร็จ */}
        <div>
          <label>เลขที่ใบเสร็จ *</label>
          <input
            type="text"
            name="receipt_no"
            value={formData.receipt_no}
            onChange={handleChange}
            required
          />
          {errors.receipt_no && <span className="error">{errors.receipt_no[0]}</span>}
        </div>

        {/* วันที่ */}
        <div>
          <label>วันที่ *</label>
          <input
            type="date"
            name="date"
            value={formData.date}
            onChange={handleChange}
            required
          />
          {errors.date && <span className="error">{errors.date[0]}</span>}
        </div>

        {/* ลูกค้า */}
        <div>
          <label>ชื่อลูกค้า *</label>
          <input
            type="text"
            name="customer"
            value={formData.customer}
            onChange={handleChange}
            required
          />
          {errors.customer && <span className="error">{errors.customer[0]}</span>}
        </div>

        {/* ที่อยู่ลูกค้า */}
        <div>
          <label>ที่อยู่</label>
          <textarea
            name="customer_address"
            value={formData.customer_address}
            onChange={handleChange}
            rows={3}
          />
        </div>

        {/* เลขประจำตัวผู้เสียภาษี */}
        <div>
          <label>เลขประจำตัวผู้เสียภาษี</label>
          <input
            type="text"
            name="customer_tax_id"
            value={formData.customer_tax_id}
            onChange={handleChange}
            maxLength={13}
            placeholder="0-0000-00000-00-0"
          />
        </div>

        {/* โทรศัพท์ */}
        <div>
          <label>โทรศัพท์</label>
          <input
            type="tel"
            name="customer_phone"
            value={formData.customer_phone}
            onChange={handleChange}
            maxLength={20}
            placeholder="081-234-5678"
          />
          {errors.customer_phone && <span className="error">{errors.customer_phone[0]}</span>}
        </div>

        {/* อีเมล */}
        <div>
          <label>อีเมล</label>
          <input
            type="email"
            name="customer_email"
            value={formData.customer_email}
            onChange={handleChange}
            placeholder="example@email.com"
          />
          {errors.customer_email && <span className="error">{errors.customer_email[0]}</span>}
        </div>

        {/* ยอดเงิน */}
        <div>
          <label>ยอดเงิน *</label>
          <input
            type="number"
            name="amount"
            value={formData.amount}
            onChange={handleChange}
            min="0"
            step="0.01"
            required
          />
          {errors.amount && <span className="error">{errors.amount[0]}</span>}
        </div>

        {/* สถานะ */}
        <div>
          <label>สถานะ *</label>
          <select
            name="status"
            value={formData.status}
            onChange={handleChange}
            required
          >
            <option value="ร่าง">ร่าง</option>
            <option value="รอออก">รอออก</option>
            <option value="ออกแล้ว">ออกแล้ว</option>
            <option value="ยกเลิก">ยกเลิก</option>
          </select>
        </div>

        {/* ประเภทเอกสาร */}
        <div>
          <label>ประเภทเอกสาร</label>
          <select
            name="doc_type"
            value={formData.doc_type}
            onChange={handleChange}
          >
            <option value="original">ต้นฉบับ</option>
            <option value="copy">สำเนา</option>
          </select>
        </div>

        {/* หมายเหตุ */}
        <div>
          <label>หมายเหตุ</label>
          <textarea
            name="description"
            value={formData.description}
            onChange={handleChange}
            rows={4}
          />
        </div>

        {/* ปุ่ม */}
        <div className="form-actions">
          <button type="submit" disabled={loading}>
            {loading ? 'กำลังบันทึก...' : isEditMode ? 'อัพเดท' : 'สร้าง'}
          </button>
          <button type="button" onClick={() => navigate('/receipts')}>
            ยกเลิก
          </button>
        </div>
      </form>
    </div>
  );
};

export default ReceiptForm;
```

---

### 4.4 การใช้งานด้วย React Hooks (Custom Hook)

**สร้าง Custom Hook สำหรับจัดการ State**

```typescript
// src/hooks/useReceipts.ts
import { useState, useEffect } from 'react';
import { getAllReceipts, deleteReceipt } from '../services/receiptService';
import { Receipt } from '../types/receipt';

export const useReceipts = () => {
  const [receipts, setReceipts] = useState<Receipt[]>([]);
  const [loading, setLoading] = useState<boolean>(true);
  const [error, setError] = useState<string | null>(null);

  const fetchReceipts = async () => {
    try {
      setLoading(true);
      setError(null);
      const data = await getAllReceipts();
      setReceipts(data);
    } catch (err: any) {
      setError(err.message);
    } finally {
      setLoading(false);
    }
  };

  useEffect(() => {
    fetchReceipts();
  }, []);

  const removeReceipt = async (id: number) => {
    try {
      await deleteReceipt(id);
      await fetchReceipts(); // Reload
      return { success: true };
    } catch (err: any) {
      return { success: false, error: err.message };
    }
  };

  return {
    receipts,
    loading,
    error,
    fetchReceipts,
    removeReceipt,
  };
};
```

**ใช้งาน Custom Hook:**

```typescript
import React from 'react';
import { useReceipts } from '../hooks/useReceipts';

const ReceiptListSimple: React.FC = () => {
  const { receipts, loading, error, removeReceipt } = useReceipts();

  const handleDelete = async (id: number) => {
    const result = await removeReceipt(id);
    if (result.success) {
      alert('ลบสำเร็จ');
    } else {
      alert('ลบไม่สำเร็จ: ' + result.error);
    }
  };

  if (loading) return <div>Loading...</div>;
  if (error) return <div>Error: {error}</div>;

  return (
    <div>
      {receipts.map(receipt => (
        <div key={receipt.id}>
          <span>{receipt.receipt_no}</span>
          <button onClick={() => handleDelete(receipt.id!)}>ลบ</button>
        </div>
      ))}
    </div>
  );
};
```

---

### 4.5 การจัดการ Error และ Loading State

#### แบบที่ 1: ใช้ Try-Catch

```typescript
const fetchData = async () => {
  try {
    setLoading(true);
    const data = await getAllReceipts();
    setReceipts(data);
  } catch (error: any) {
    // จัดการ error
    if (error.response) {
      // Backend ตอบกลับพร้อม error
      setError(error.response.data.message || 'เกิดข้อผิดพลาด');
    } else if (error.request) {
      // ไม่ได้รับ response จาก server
      setError('ไม่สามารถเชื่อมต่อกับ server ได้');
    } else {
      setError(error.message);
    }
  } finally {
    setLoading(false);
  }
};
```

#### แบบที่ 2: ใช้ Toast/Notification

```typescript
import { toast } from 'react-toastify'; // ต้อง install ก่อน

const handleSubmit = async () => {
  try {
    await createReceipt(formData);
    toast.success('สร้างใบเสร็จสำเร็จ!');
    navigate('/receipts');
  } catch (error: any) {
    toast.error('เกิดข้อผิดพลาด: ' + error.message);
  }
};
```

---

### 4.6 การ Debug เมื่อมีปัญหา

#### ปัญหาที่ 1: CORS Error

**อาการ:**
```
Access to XMLHttpRequest at 'http://localhost:8000/api/receipts' 
from origin 'http://localhost:5173' has been blocked by CORS policy
```

**วิธีแก้:**

1. ตรวจสอบ `config/cors.php` ใน Backend
2. เพิ่ม Frontend URL ใน `allowed_origins`
3. Clear cache: `php artisan config:clear`
4. Restart Laravel server

```php
// config/cors.php
'allowed_origins' => [
    'http://localhost:5173',
    'http://127.0.0.1:5173',
],
```

---

#### ปัญหาที่ 2: Network Error / Can't Connect

**วิธีตรวจสอบ:**

```powershell
# 1. ตรวจสอบว่า Backend รันอยู่หรือไม่
Get-NetTCPConnection -LocalPort 8000

# 2. ทดสอบ API ด้วย curl หรือ PowerShell
Invoke-RestMethod -Uri "http://localhost:8000/api/receipts" -Method Get

# 3. ตรวจสอบ URL ใน Frontend
# ไฟล์: src/services/api.ts
# const API_BASE_URL = 'http://127.0.0.1:8000/api'; // ต้องตรงกับ Backend
```

---

#### ปัญหาที่ 3: 404 Not Found

**สาเหตุ:** Route ไม่ถูกต้อง หรือยังไม่ได้สร้าง

**วิธีแก้:**

```powershell
# 1. ตรวจสอบ routes ใน Backend
php artisan route:list --path=api/receipts

# 2. ตรวจสอบว่าใช้ URL ถูกต้องใน Frontend
# ถูก:   /api/receipts
# ผิด:   /receipts (ไม่มี /api)
# ผิด:   /api/receipt (ไม่มี s)
```

---

#### ปัญหาที่ 4: 422 Validation Error

**อาการ:** Backend ตอบกลับว่า validation ไม่ผ่าน

**วิธีแก้:**

```typescript
// จัดการ validation errors จาก Backend
try {
  await createReceipt(formData);
} catch (error: any) {
  if (error.response && error.response.status === 422) {
    // แสดง validation errors
    const validationErrors = error.response.data.errors;
    console.log('Validation Errors:', validationErrors);
    setErrors(validationErrors);
  }
}
```

**ตัวอย่าง validation errors จาก Backend:**
```json
{
  "message": "The given data was invalid.",
  "errors": {
    "receipt_no": ["The receipt no has already been taken."],
    "customer_email": ["The customer email must be a valid email address."]
  }
}
```

---

#### ปัญหาที่ 5: Field ไม่แสดงค่า

**วิธีตรวจสอบ:**

1. เช็คว่า Backend ส่งข้อมูลมาครบหรือไม่
```typescript
const data = await getAllReceipts();
console.log('Backend Response:', data);
```

2. เช็คว่า TypeScript Interface ตรงกับ Backend หรือไม่
3. เช็คว่าเพิ่ม field ใน Model `$fillable` แล้วหรือยัง
4. เช็คว่าเพิ่ม validation ใน Controller แล้วหรือยัง

---

### 4.7 ตัวอย่างการทดสอบครบวงจร

```powershell
# 1. Start Backend
cd C:\Users\ADMIN\Desktop\SAB\sab-backend
php artisan serve

# 2. Start Frontend (Terminal ใหม่)
cd C:\Users\ADMIN\Desktop\SAB\sab-frontend
npm run dev

# 3. ทดสอบ API ด้วย PowerShell (Terminal ใหม่)
# GET all
Invoke-RestMethod -Uri "http://localhost:8000/api/receipts" -Method Get

# POST new
$body = @{
    receipt_no = "TEST001"
    date = "2025-11-14"
    customer = "ทดสอบ"
    customer_phone = "0812345678"
    customer_email = "test@test.com"
    amount = 500
    status = "ร่าง"
} | ConvertTo-Json

Invoke-RestMethod -Uri "http://localhost:8000/api/receipts" -Method Post -Body $body -ContentType "application/json"

# 4. เปิด Browser ไปที่ http://localhost:5173
# ควรเห็นข้อมูลจาก Backend
```

---

## 📊 สรุป Flow การทำงาน

```
Frontend (React)
    ↓
1. User กรอกฟอร์ม/คลิกปุ่ม
    ↓
2. Component เรียก Service Function
    ↓
3. Service Function เรียก apiClient (axios)
    ↓
4. ส่ง HTTP Request → Backend Laravel (API)
    ↓
5. Backend Controller รับ Request
    ↓
6. Validate ข้อมูล
    ↓
7. เขียน/อ่าน Database (Model)
    ↓
8. ส่ง Response กลับ (JSON)
    ↓
9. Frontend รับ Response
    ↓
10. Update State & แสดงผลหน้าจอ
```

---

## ✅ Checklist เชื่อมต่อ Frontend-Backend

### Backend:
- [ ] Laravel server รันอยู่ที่ port 8000
- [ ] Routes ถูกสร้างใน `routes/api.php`
- [ ] Controller มี methods: index, show, store, update, destroy
- [ ] Model มี `$fillable` ครบทุก field
- [ ] Validation rules ครบใน Controller
- [ ] CORS config อนุญาต Frontend URL
- [ ] Migration ถูก run แล้ว
- [ ] Cache ถูก clear แล้ว

### Frontend:
- [ ] Frontend server รันอยู่ที่ port 5173
- [ ] ติดตั้ง axios แล้ว: `npm install axios`
- [ ] สร้างไฟล์ `src/services/api.ts`
- [ ] BASE_URL ตั้งค่าถูกต้อง (http://127.0.0.1:8000/api)
- [ ] สร้าง TypeScript Interface ตรงกับ Backend
- [ ] สร้าง Service Functions (CRUD)
- [ ] Component เรียกใช้ Service Functions
- [ ] จัดการ Loading & Error State
- [ ] ทดสอบทุก function (GET, POST, PUT, DELETE)

---

**สร้างโดย:** GitHub Copilot  
**วันที่:** 14 พฤศจิกายน 2025  
**เวอร์ชัน:** Laravel 8.x - 10.x | React + TypeScript
