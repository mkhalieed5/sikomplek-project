<?php

namespace Tests\Feature;

use App\Models\KartuKeluarga;
use App\Models\KategoriIuran;
use App\Models\PembayaranIuran;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class IuranAuthorizationTest extends TestCase
{
    use RefreshDatabase;

    public function test_only_admin_roles_can_access_iuran_management(): void
    {
        $tenant = Tenant::create([
            'name' => 'Komplek Uji',
            'code' => 'RT-IURAN1',
            'status' => 'active',
        ]);
        $resident = User::create([
            'tenant_id' => $tenant->id,
            'name' => 'Warga Uji',
            'email' => 'warga-iuran@example.com',
            'password' => 'password',
            'role' => 'warga',
        ]);
        $bendahara = User::create([
            'tenant_id' => $tenant->id,
            'name' => 'Bendahara Uji',
            'email' => 'bendahara-iuran@example.com',
            'password' => 'password',
            'role' => 'bendahara',
        ]);
        $admin = User::create([
            'tenant_id' => $tenant->id,
            'name' => 'Admin Uji',
            'email' => 'admin-iuran@example.com',
            'password' => 'password',
            'role' => 'tenant_admin',
        ]);
        $superAdmin = User::create([
            'name' => 'Super Admin Uji',
            'email' => 'super-admin-iuran@example.com',
            'password' => 'password',
            'role' => 'super_admin',
        ]);
        $family = KartuKeluarga::create([
            'tenant_id' => $tenant->id,
            'nomor_kk' => '1234567890123456',
            'nama_kepala_keluarga' => 'Keluarga Uji',
            'alamat' => 'Jalan Uji',
            'rt' => '01',
            'rw' => '02',
        ]);
        $category = KategoriIuran::create([
            'tenant_id' => $tenant->id,
            'nama_kategori' => 'Keamanan',
            'nominal_default' => 100000,
        ]);
        $payment = PembayaranIuran::create([
            'tenant_id' => $tenant->id,
            'kartu_keluarga_id' => $family->id,
            'kategori_iuran_id' => $category->id,
            'bulan' => 1,
            'tahun' => 2026,
            'jumlah_bayar' => 100000,
            'tanggal_bayar' => '2026-01-10',
            'status' => 'lunas',
        ]);

        foreach ([$resident, $bendahara] as $user) {
            $this->actingAs($user)
                ->get(route('iuran'))
                ->assertForbidden();
            $this->get(route('kategori-iuran.create'))->assertForbidden();
            $this->post(route('kategori-iuran.store'), [])->assertForbidden();
            $this->get(route('kategori-iuran.edit', 1))->assertForbidden();
            $this->put(route('kategori-iuran.update', 1), [])->assertForbidden();
            $this->delete(route('kategori-iuran.destroy', 1))->assertForbidden();
            $this->get(route('pembayaran-iuran'))->assertForbidden();
            $this->get(route('pembayaran-iuran.create'))->assertForbidden();
            $this->post(route('pembayaran-iuran.store'), [])->assertForbidden();
            $this->get(route('pembayaran-iuran.edit', 1))->assertForbidden();
            $this->put(route('pembayaran-iuran.update', 1), [])->assertForbidden();
            $this->delete(route('pembayaran-iuran.destroy', 1))->assertForbidden();

            $this->actingAs($user, 'sanctum')
                ->getJson('/api/kategori-iuran')
                ->assertForbidden();
            $this->getJson('/api/pembayaran-iuran')->assertForbidden();
            $this->postJson('/api/kategori-iuran', [])->assertForbidden();
            $this->putJson("/api/kategori-iuran/{$category->id}", [])->assertForbidden();
            $this->deleteJson("/api/kategori-iuran/{$category->id}")->assertForbidden();
            $this->postJson('/api/pembayaran-iuran', [])->assertForbidden();
            $this->putJson("/api/pembayaran-iuran/{$payment->id}", [])->assertForbidden();
            $this->deleteJson("/api/pembayaran-iuran/{$payment->id}")->assertForbidden();
        }

        foreach ([$admin, $superAdmin] as $user) {
            $this->actingAs($user)
                ->get(route('iuran'))
                ->assertOk();
            $this->actingAs($user, 'sanctum')
                ->getJson('/api/kategori-iuran')
                ->assertOk();
        }
    }
}
