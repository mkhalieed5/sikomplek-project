<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $columns = [];

        foreach ([
            'alamat_jalan' => fn (Blueprint $table) => $table->string('alamat_jalan', 500)->nullable(),
            'province_id' => fn (Blueprint $table) => $table->char('province_id', 2)->nullable(),
            'regency_id' => fn (Blueprint $table) => $table->char('regency_id', 4)->nullable(),
            'district_id' => fn (Blueprint $table) => $table->char('district_id', 7)->nullable(),
            'village_id' => fn (Blueprint $table) => $table->char('village_id', 10)->nullable(),
            'kode_pos' => fn (Blueprint $table) => $table->string('kode_pos', 5)->nullable(),
        ] as $column => $definition) {
            if (! Schema::hasColumn('tenants', $column)) {
                $columns[] = $definition;
            }
        }

        if ($columns !== []) {
            Schema::table('tenants', function (Blueprint $table) use ($columns): void {
                foreach ($columns as $definition) {
                    $definition($table);
                }
            });
        }

        if (Schema::hasColumn('tenants', 'address')) {
            DB::table('tenants')
                ->whereNull('alamat_jalan')
                ->whereNotNull('address')
                ->update(['alamat_jalan' => DB::raw('address')]);
        }
    }

    public function down(): void
    {
        $columns = array_filter(
            ['alamat_jalan', 'province_id', 'regency_id', 'district_id', 'village_id', 'kode_pos'],
            fn (string $column): bool => Schema::hasColumn('tenants', $column)
        );

        if ($columns !== []) {
            Schema::table('tenants', function (Blueprint $table) use ($columns): void {
                $table->dropColumn($columns);
            });
        }
    }
};
