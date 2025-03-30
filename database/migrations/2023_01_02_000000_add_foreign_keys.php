<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Add foreign keys to products
        Schema::table('products', function (Blueprint $table) {
            $table->foreign('category_id')
                ->references('id')
                ->on('categories')
                ->onDelete('cascade');
        });

        // Add foreign keys to orders
        Schema::table('orders', function (Blueprint $table) {
            $table->foreign('table_id')
                ->references('id')
                ->on('tables');
                
            $table->foreign('user_id')
                ->references('id')
                ->on('users');
        });

        // Add foreign keys to order_items
        Schema::table('order_items', function (Blueprint $table) {
            $table->foreign('order_id')
                ->references('id')
                ->on('orders')
                ->onDelete('cascade');
                
            $table->foreign('product_id')
                ->references('id')
                ->on('products');
        });

        // Add foreign keys to payments
        Schema::table('payments', function (Blueprint $table) {
            $table->foreign('order_id')
                ->references('id')
                ->on('orders');
                
            $table->foreign('user_id')
                ->references('id')
                ->on('users');
        });
    }

    public function down()
    {
        // Drop foreign keys from payments
        Schema::table('payments', function (Blueprint $table) {
            $table->dropForeign(['order_id']);
            $table->dropForeign(['user_id']);
        });

        // Drop foreign keys from order_items
        Schema::table('order_items', function (Blueprint $table) {
            $table->dropForeign(['order_id']);
            $table->dropForeign(['product_id']);
        });

        // Drop foreign keys from orders
        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign(['table_id']);
            $table->dropForeign(['user_id']);
        });

        // Drop foreign keys from products
        Schema::table('products', function (Blueprint $table) {
            $table->dropForeign(['category_id']);
        });
    }
}; 