<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            
            

            
            $table->unsignedInteger('category_id')->index();
            $table->unsignedInteger('shop_id')->index();
            
            //冗余
            $table->string('tb_product_id',16);
            $table->string('tb_shop_id',16);  
            $table->string('tb_category_id',16);
            $table->string('shop_name',16);  
            $table->string('category_name',16);        
            
                        
            $table->enum('status',[0,1,2,3]);
            
            $table->string('name',60)->index();
            $table->string('pic_url');
            $table->text('pics_url');
            $table->text('desc');
            
            
            $table->string('binds_str');
            $table->string('sale_props_str');
            $table->text('sku_props');
            
            $table->decimal('price',6,2);
            $table->decimal('discount_price',6,2);

            
            $table->unsignedInteger('num')->default(0);
            $table->unsignedInteger('sale_num')->default(0)->comment('产品的销售量');
            $table->unsignedInteger('collect_num')->default(0)->comment('产品的collect次数（不提供数据，返回0)');   
            $table->unsignedInteger('rate_num')->default(0);
            
            $table->foreign('category_id')->references('id')->on('categories');
            $table->foreign('shop_id')->references('id')->on('shops')->onDelete('cascade');
            
            $table->datetime('created')->index();
            
            $table->decimal('dealer_price',6,2);
            $table->decimal('limit_price',6,2);
            $table->string('article_number',10);
            $table->boolean('owners')->default(false);
            $table->boolean('recommend')->default(false);
            $table->boolean('instock')->default(false);
            $table->boolean('presale')->default(false);
            $table->date('presale_date');
            
            $table->string('seller_code',20);
            $table->string('location',10);

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
