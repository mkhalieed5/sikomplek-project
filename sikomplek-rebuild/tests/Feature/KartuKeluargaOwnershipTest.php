<?php

namespace Tests\Feature;

use App\Models\KartuKeluarga;
use App\Models\Tenant;
use App\Models\User;
use App\Models\Warga;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class KartuKeluargaOwnershipTest extends TestCase
{
    use RefreshDatabase;

    public function test_resident_can_only_view_and_manage_their_own_family(): void
    {
        [$tenant, $owner, $otherUser] = $this->createResidents();
        $ownFamily = $this->createFamily($tenant, $owner, '1111111111111111');
        $otherFamily = $this->createFamily($tenant, $otherUser, '2222222222222222');

        $this->actingAs($owner)
            ->get(route('kartu-keluarga'))
            ->assertOk()
            ->assertSee($ownFamily->nomor_kk)
            ->assertDontSee($otherFamily->nomor_kk);

        $this->get(route('kartu-keluarga.edit', $otherFamily->id))->assertNotFound();
        $this->put(route('kartu-keluarga.update', $otherFamily->id), [
            'nomor_kk' => '3333333333333333',
            'nama_kepala_keluarga' => 'Tidak berhak',
            'alamat' => 'Alamat',
            'rt' => '01',
            'rw' => '02',
        ])->assertNotFound();
        $this->delete(route('kartu-keluarga.destroy', $otherFamily->id))->assertNotFound();

        $response = $this->from(route('kartu-keluarga'))->post(route('kartu-keluarga.store'), [
            'owner_user_id' => $otherUser->id,
            'nomor_kk' => '4444444444444444',
            'nama_kepala_keluarga' => 'Keluarga Sendiri',
            'alamat' => 'Alamat Baru',
            'rt' => '01',
            'rw' => '02',
        ]);
        $response->assertSessionHasNoErrors();

        $this->assertDatabaseHas('kartu_keluargas', [
            'nomor_kk' => '4444444444444444',
            'owner_user_id' => $owner->id,
        ]);

        $treasurer = User::create([
            'tenant_id' => $tenant->id,
            'name' => 'Bendahara',
            'email' => 'bendahara@example.com',
            'password' => 'password',
            'role' => 'bendahara',
        ]);
        $treasurerFamily = $this->createFamily($tenant, $treasurer, '5555555555555555');

        $this->actingAs($treasurer)
            ->get(route('kartu-keluarga'))
            ->assertOk()
            ->assertSee($treasurerFamily->nomor_kk)
            ->assertDontSee($ownFamily->nomor_kk)
            ->assertDontSee($otherFamily->nomor_kk);
    }

    public function test_resident_can_only_view_and_add_members_to_their_own_family(): void
    {
        [$tenant, $owner, $otherUser] = $this->createResidents();
        $ownFamily = $this->createFamily($tenant, $owner, '1111111111111111');
        $otherFamily = $this->createFamily($tenant, $otherUser, '2222222222222222');

        $ownResident = $this->createResident($tenant, $ownFamily, '1111111111111112');
        $otherResident = $this->createResident($tenant, $otherFamily, '2222222222222223');

        $this->actingAs($owner)
            ->get(route('warga'))
            ->assertOk()
            ->assertSee($ownResident->nama_lengkap)
            ->assertDontSee($otherResident->nama_lengkap);

        $this->get(route('warga.edit', $otherResident->id))->assertNotFound();

        $response = $this->post(route('warga.store'), [
            'kartu_keluarga_id' => $otherFamily->id,
            'nik' => '1111111111111113',
            'nama_lengkap' => 'Anggota Tidak Sah',
            'jenis_kelamin' => 'L',
            'tempat_lahir' => 'Pekanbaru',
            'tanggal_lahir' => '1990-01-01',
            'status_pernikahan' => 'Menikah',
            'status_keluarga' => 'Anak',
        ]);
        $response->assertSessionHasErrors('kartu_keluarga_id');

        $this->assertDatabaseMissing('wargas', ['nik' => '1111111111111113']);
    }

    public function test_resident_api_is_scoped_to_owned_families_and_members(): void
    {
        [$tenant, $owner, $otherUser] = $this->createResidents();
        $ownFamily = $this->createFamily($tenant, $owner, '1111111111111111');
        $otherFamily = $this->createFamily($tenant, $otherUser, '2222222222222222');
        $otherResident = $this->createResident($tenant, $otherFamily, '2222222222222223');

        $this->actingAs($owner, 'sanctum')
            ->getJson('/api/kartu-keluarga')
            ->assertOk()
            ->assertJsonFragment(['nomor_kk' => $ownFamily->nomor_kk])
            ->assertJsonMissing(['nomor_kk' => $otherFamily->nomor_kk]);

        $this->getJson("/api/kartu-keluarga/{$otherFamily->id}")->assertNotFound();
        $this->getJson('/api/warga')->assertOk()->assertJsonMissing(['nik' => $otherResident->nik]);
        $this->getJson("/api/warga/{$otherResident->id}")->assertNotFound();
    }

    public function test_tenant_admin_can_assign_existing_family_data_to_its_resident_owner(): void
    {
        [$tenant, $owner] = $this->createResidents();
        $family = KartuKeluarga::create([
            'tenant_id' => $tenant->id,
            'nomor_kk' => '1111111111111111',
            'nama_kepala_keluarga' => $owner->name,
            'alamat' => 'Jalan Merdeka',
            'rt' => '01',
            'rw' => '02',
        ]);
        $admin = User::create([
            'tenant_id' => $tenant->id,
            'name' => 'Admin RT',
            'email' => 'admin@example.com',
            'password' => 'password',
            'role' => 'tenant_admin',
        ]);

        $this->actingAs($admin);
        $this->assertAuthenticatedAs($admin);
        $response = $this->put(route('kartu-keluarga.update', $family->id), [
                'nomor_kk' => $family->nomor_kk,
                'nama_kepala_keluarga' => $owner->name,
                'alamat' => $family->alamat,
                'rt' => $family->rt,
                'rw' => $family->rw,
                'owner_user_id' => $owner->id,
            ]);
        $response->assertRedirect(route('kartu-keluarga'));
        $response->assertSessionHasNoErrors();

        $this->assertDatabaseHas('kartu_keluargas', [
            'id' => $family->id,
            'owner_user_id' => $owner->id,
        ]);

        $this->actingAs($owner)
            ->get(route('kartu-keluarga'))
            ->assertOk()
            ->assertSee($family->nomor_kk);
    }

    private function createResidents(): array
    {
        $tenant = Tenant::create([
            'name' => 'Komplek Test',
            'code' => 'RT-TEST01',
            'status' => 'active',
        ]);

        $owner = User::create([
            'tenant_id' => $tenant->id,
            'name' => 'Warga Satu',
            'email' => 'warga1@example.com',
            'password' => 'password',
            'role' => 'warga',
        ]);

        $otherUser = User::create([
            'tenant_id' => $tenant->id,
            'name' => 'Warga Dua',
            'email' => 'warga2@example.com',
            'password' => 'password',
            'role' => 'warga',
        ]);

        return [$tenant, $owner, $otherUser];
    }

    private function createFamily(Tenant $tenant, User $owner, string $number): KartuKeluarga
    {
        return KartuKeluarga::create([
            'tenant_id' => $tenant->id,
            'owner_user_id' => $owner->id,
            'nomor_kk' => $number,
            'nama_kepala_keluarga' => $owner->name,
            'alamat' => 'Jalan Merdeka',
            'rt' => '01',
            'rw' => '02',
        ]);
    }

    private function createResident(Tenant $tenant, KartuKeluarga $family, string $nik): Warga
    {
        return Warga::create([
            'tenant_id' => $tenant->id,
            'kartu_keluarga_id' => $family->id,
            'nik' => $nik,
            'nama_lengkap' => $family->nama_kepala_keluarga,
            'jenis_kelamin' => 'L',
            'tempat_lahir' => 'Pekanbaru',
            'tanggal_lahir' => '1980-01-01',
            'status_pernikahan' => 'Menikah',
            'status_keluarga' => 'Kepala Keluarga',
        ]);
    }
}
