<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSkusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('skus', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->unsignedInteger('product_id');            
            $table->string('properties_name')->comment('sku所对应的销售属性的中文名字串20000:3275069:品牌:盈讯;1753146:3485013:型号:F908;-1234:-5678:自定义属性1:属性值1'); 
            $table->unsignedInteger('quantity')->comment('属于这个sku的商品的数量');
            $table->unsignedInteger('with_hold_quantity')->default(0)->comment('商品在付款减库存的状态下，该sku上未付款的订单数量');              
            $table->decimal('price',6,2)->comment('商品价格，精确到2位小数;单位:元'); 
            $table->decimal('discount_price',6,2)->comment('商品折扣价格，精确到2位小数;单位:元');   
            $table->unsignedInteger('sku_delivery_time')->default(72)->comment('sku级别发货时间');   
            
            //冗余
            $table->string('tb_sku_id',16);
            $table->string('tb_product_id',16);
             
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('skus');
    }
}
