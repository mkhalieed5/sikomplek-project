<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasColumn('tenants', 'code')) {
            Schema::table('tenants', function (Blueprint $table) {
                $table->string('code')->nullable()->unique()->after('name');
            });

            DB::table('tenants')->orderBy('id')->get(['id'])->each(function (object $tenant): void {
                DB::table('tenants')
                    ->where('id', $tenant->id)
                    ->update(['code' => 'TENANT-'.$tenant->id]);
            });

            Schema::table('tenants', function (Blueprint $table) {
                $table->string('code')->nullable(false)->change();
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('tenants', 'code')) {
            Schema::table('tenants', function (Blueprint $table) {
                $table->dropUnique(['code']);
                $table->dropColumn('code');
            });
        }
    }
};
