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
    	Schema::table('user_missions', function (Blueprint $table) {
        	$table->timestamp('claimed_at')->nullable()->after('completed_at');
    	});
	}

	public function down(): void
	{
    		Schema::table('user_missions', function (Blueprint $table) {
        	$table->dropColumn('claimed_at');
   	 });
	}
    /**
     * Reverse the migrations.
     */


};
