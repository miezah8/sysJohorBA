<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('schools', function (Blueprint $table) {
            $table->integer('id_school')->primary();
            $table->string('school_name', 200);
            $table->string('sch_code', 10);
            $table->text('sc_address');
            $table->string('postcode', 10);
            $table->integer('district_id');
            $table->integer('state_id');
            $table->string('no_tel', 15);
            $table->string('no_fax', 15);
            $table->string('email_sch', 50);
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('modified_on')->useCurrent()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schools');
    }
};
