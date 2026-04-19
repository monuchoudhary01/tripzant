<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAuthFieldsToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'created_by')) {
                $table->string('created_by')->default('self')->after('status');
            }
            if (!Schema::hasColumn('users', 'company_name')) {
                $table->string('company_name')->nullable()->after('created_by');
            }
            if (!Schema::hasColumn('users', 'gst_number')) {
                $table->string('gst_number')->nullable()->after('company_name');
            }
            if (!Schema::hasColumn('users', 'agency_name')) {
                $table->string('agency_name')->nullable()->after('gst_number');
            }
            if (!Schema::hasColumn('users', 'address')) {
                $table->text('address')->nullable()->after('agency_name');
            }
            if (!Schema::hasColumn('users', 'contact_person')) {
                $table->string('contact_person')->nullable()->after('address');
            }
            if (!Schema::hasColumn('users', 'otp')) {
                $table->string('otp')->nullable()->after('contact_person');
            }
            if (!Schema::hasColumn('users', 'is_verified')) {
                $table->boolean('is_verified')->default(false)->after('otp');
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['created_by', 'company_name', 'gst_number', 'agency_name', 'address', 'contact_person']);
        });
    }
}
