<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('name');
            //
            $table->string('first_name')->nullable()->after('id');
            $table->string('last_name')->nullable()->after('first_name');
            //
            $table->boolean('is_admin')->default(false)->after('profile_photo_path');
            $table->boolean('is_customer')->default(false)->after('is_admin');
            //
            $table->unsignedBigInteger('admin_id')->nullable()->after('is_customer');
            $table->unsignedBigInteger('customer_id')->nullable()->after('admin_id');
            //
            $table->timestamp('last_login_at')->nullable()->after('customer_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('name')->nullable()->after('id');
            //
            $table->dropColumn('first_name');
            $table->dropColumn('last_name');
            $table->dropColumn('is_admin');
            $table->dropColumn('is_customer');
            $table->dropColumn('admin_id');
            $table->dropColumn('customer_id');
            $table->dropColumn('last_login_at');
        });
    }
};
