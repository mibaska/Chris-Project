<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvoiceItemsTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $set_schema_table = 'invoice_items';

    /**
     * Run the migrations.
     * @table invoice_items
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable($this->set_schema_table)) return;
        Schema::create($this->set_schema_table, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->unsignedInteger('invoice_id');
            $table->unsignedInteger('tax_rate_id');
            $table->unsignedInteger('tax_rate_2_id')->default('0');
            $table->string('name');
            $table->text('description');
            $table->decimal('quantity', 20, 4)->default('0.0000');
            $table->integer('display_order')->default('0');
            $table->decimal('price', 20, 4)->default('0.0000');

            $table->index(["display_order"], 'invoice_items_display_order_index');

            $table->index(["invoice_id"], 'invoice_items_invoice_id_index');
            $table->nullableTimestamps();


            $table->foreign('invoice_id', 'invoice_items_invoice_id_index')
                ->references('id')->on('invoices')
                ->onDelete('cascade')
                ->onUpdate('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
     public function down()
     {
       Schema::dropIfExists($this->set_schema_table);
     }
}
