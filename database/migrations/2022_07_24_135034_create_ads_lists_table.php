<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdsListsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ads_lists', function (Blueprint $table) {
            $table->id();
            $table->integer('property_type');
            $table->integer('user_id');
            $table->string('email')->nullable();
            $table->integer('transactions')->comment('1: flats, 2:penthouse');
            $table->string('location');
            $table->string('lat')->nullable();
            $table->string('lng')->nullable();
            $table->string('street_name')->nullable();
            $table->string('street_no')->nullable();
            $table->boolean('hide_street')->default(false);
            $table->string('resdential_area')->nullable();
            $table->string('phone')->nullable();
            $table->string('name')->nullable();
            $table->integer('prefer_connection')->default(1)->comment('1: chat and phone, 2: chat');
            $table->string('country')->nullable();
            $table->integer('condition')->default(2)->comment('1: Need renovation, 2: Good condition');
            $table->string('built_area')->comment('m2');
            $table->string('useable_area')->nullable()->comment('m2');
            $table->string('plot_area')->nullable()->comment('m2');
            $table->integer('total_bathroom');
            $table->integer('total_bedroom');
            $table->string('orientation')->nullable()->comment('North, East, South, West');
            $table->integer('total_floor')->nullable();
            $table->json('other_features')->nullable();
            $table->json('building_features')->nullable();
            $table->string('price');
            $table->string('community_cost')->nullable();
            $table->longText('description_en')->nullable();
            $table->longText('description_sp')->nullable();
            $table->json('images')->nullable();
            $table->integer('status')->default(0);
            $table->boolean('is_featured')->default(false);
            $table->boolean('top_property')->default(false);
            $table->boolean('urgent_property')->default(false);
            $table->integer('views')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ads_lists');
    }
}
