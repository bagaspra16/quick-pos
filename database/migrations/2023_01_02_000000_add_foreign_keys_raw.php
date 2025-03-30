<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        // Products FK
        DB::statement('ALTER TABLE products ADD CONSTRAINT products_category_id_foreign FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE CASCADE');
        
        // Orders FK
        DB::statement('ALTER TABLE orders ADD CONSTRAINT orders_table_id_foreign FOREIGN KEY (table_id) REFERENCES tables(id)');
        DB::statement('ALTER TABLE orders ADD CONSTRAINT orders_user_id_foreign FOREIGN KEY (user_id) REFERENCES users(id)');
        
        // Order Items FK
        DB::statement('ALTER TABLE order_items ADD CONSTRAINT order_items_order_id_foreign FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE');
        DB::statement('ALTER TABLE order_items ADD CONSTRAINT order_items_product_id_foreign FOREIGN KEY (product_id) REFERENCES products(id)');
        
        // Payments FK
        DB::statement('ALTER TABLE payments ADD CONSTRAINT payments_order_id_foreign FOREIGN KEY (order_id) REFERENCES orders(id)');
        DB::statement('ALTER TABLE payments ADD CONSTRAINT payments_user_id_foreign FOREIGN KEY (user_id) REFERENCES users(id)');
    }

    public function down()
    {
        // Payments FK
        DB::statement('ALTER TABLE payments DROP CONSTRAINT payments_order_id_foreign');
        DB::statement('ALTER TABLE payments DROP CONSTRAINT payments_user_id_foreign');
        
        // Order Items FK
        DB::statement('ALTER TABLE order_items DROP CONSTRAINT order_items_order_id_foreign');
        DB::statement('ALTER TABLE order_items DROP CONSTRAINT order_items_product_id_foreign');
        
        // Orders FK
        DB::statement('ALTER TABLE orders DROP CONSTRAINT orders_table_id_foreign');
        DB::statement('ALTER TABLE orders DROP CONSTRAINT orders_user_id_foreign');
        
        // Products FK
        DB::statement('ALTER TABLE products DROP CONSTRAINT products_category_id_foreign');
    }
}; 