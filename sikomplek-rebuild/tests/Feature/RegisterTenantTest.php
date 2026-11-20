<?php

namespace Tests\Feature;

use App\Models\Tenant;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegisterTenantTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration_form_renders_the_cascading_region_fields(): void
    {
        $this->get(route('register-rt'))
            ->assertOk()
            ->assertSee('Alamat Jalan / Blok / Nomor')
            ->assertSee('Kabupaten / Kota')
            ->assertSee('Kelurahan / Desa')
            ->assertSee('minlength="8"', false)
            ->assertSee('Password harus memiliki minimal 8 karakter.');
    }

    public function test_tenant_admin_can_register_with_a_complete_address(): void
    {
        $response = $this->post(route('register-rt'), [
            'name' => 'Budi Santoso',
            'email' => 'budi@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'nama_komplek' => 'Perumahan Mawar RT 03',
            'alamat_jalan' => 'Jl. Mawar No. 12-B',
            'province_id' => '14',
            'regency_id' => '1401',
            'district_id' => '1401010',
            'village_id' => '1401010001',
            'kode_pos' => '28282',
        ]);

        $response->assertRedirect(route('register-rt.success'));
        $response->assertSessionHas('success');
        $response->assertSessionHas('tenant_code');
        $this->assertAuthenticated();

        $tenant = Tenant::where('name', 'Perumahan Mawar RT 03')->firstOrFail();
        $this->get(route('register-rt.success'))
            ->assertOk()
            ->assertSee($tenant->code);

        $this->assertDatabaseHas('tenants', [
            'id' => $tenant->id,
            'address' => 'Jl. Mawar No. 12-B',
            'alamat_jalan' => 'Jl. Mawar No. 12-B',
            'province_id' => '14',
            'regency_id' => '1401',
            'district_id' => '1401010',
            'village_id' => '1401010001',
            'kode_pos' => '28282',
        ]);
        $this->assertDatabaseHas('users', [
            'tenant_id' => $tenant->id,
            'role' => 'tenant_admin',
            'email' => 'budi@example.com',
        ]);
    }

    public function test_region_fields_must_be_complete_and_have_expected_id_lengths(): void
    {
        $response = $this->from(route('register-rt'))->post(route('register-rt'), [
            'name' => 'Budi Santoso',
            'email' => 'budi@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'nama_komplek' => 'Perumahan Mawar RT 03',
            'alamat_jalan' => 'Jl. Mawar No. 12-B',
            'province_id' => '14',
            'regency_id' => '1401',
            'district_id' => '1401010',
            'village_id' => '1',
        ]);

        $response->assertRedirect(route('register-rt'));
        $response->assertSessionHasErrors('village_id');
        $this->assertDatabaseCount('tenants', 0);
    }

    public function test_registration_rejects_a_password_shorter_than_eight_characters(): void
    {
        $response = $this->from(route('register-rt'))->post(route('register-rt'), [
            'name' => 'Budi Santoso',
            'email' => 'budi@example.com',
            'password' => 'short',
            'password_confirmation' => 'short',
            'nama_komplek' => 'Perumahan Mawar RT 03',
            'alamat_jalan' => 'Jl. Mawar No. 12-B',
            'province_id' => '14',
            'regency_id' => '1401',
            'district_id' => '1401010',
            'village_id' => '1401010001',
        ]);

        $response->assertRedirect(route('register-rt'));
        $response->assertSessionHasErrors('password');
        $this->assertDatabaseCount('tenants', 0);
        $this->assertDatabaseCount('users', 0);
    }

    public function test_bendahara_keeps_the_source_dashboard_routing_behavior(): void
    {
        $tenant = Tenant::create([
            'name' => 'Komplek Uji',
            'code' => 'RT-TEST02',
            'status' => 'active',
        ]);

        $bendahara = User::create([
            'tenant_id' => $tenant->id,
            'name' => 'Bendahara Uji',
            'email' => 'bendahara-dashboard@example.com',
            'password' => 'password',
            'role' => 'bendahara',
        ]);

        $this->actingAs($bendahara)
            ->get('/home')
            ->assertOk()
            ->assertViewIs('home.warga');
    }

    public function test_only_tenant_admin_portal_displays_the_tenant_code(): void
    {
        $tenant = Tenant::create([
            'name' => 'Perumahan Mawar RT 03',
            'code' => 'RT-SECRET1',
            'status' => 'active',
        ]);

        foreach (['warga', 'bendahara'] as $role) {
            $user = User::create([
                'tenant_id' => $tenant->id,
                'name' => ucfirst($role),
                'email' => "{$role}@example.com",
                'password' => 'password',
                'role' => $role,
            ]);

            $this->actingAs($user)
                ->get('/home')
                ->assertOk()
                ->assertDontSee($tenant->code);
        }

        $admin = User::create([
            'tenant_id' => $tenant->id,
            'name' => 'Admin RT',
            'email' => 'admin-rt@example.com',
            'password' => 'password',
            'role' => 'tenant_admin',
        ]);

        $this->actingAs($admin)
            ->get('/home')
            ->assertOk()
            ->assertSee($tenant->code);
    }

    public function test_existing_api_clients_can_still_register_using_the_legacy_address_field(): void
    {
        $response = $this->postJson('/api/register-rt', [
            'name' => 'Budi Santoso',
            'email' => 'budi@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'nama_komplek' => 'Perumahan Mawar RT 03',
            'alamat' => 'Jalan Mawar No. 12',
        ]);

        $response->assertCreated();
        $response->assertJsonPath('tenant.address', 'Jalan Mawar No. 12');
        $this->assertDatabaseHas('tenants', [
            'name' => 'Perumahan Mawar RT 03',
            'alamat_jalan' => 'Jalan Mawar No. 12',
        ]);
    }
}
