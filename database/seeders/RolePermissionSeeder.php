<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {

        $admin = Role::findByName('Admin');

        $admin->givePermissionTo(
            Permission::all()
        );


        $kepala = Role::findByName(
            'Kepala TVRI Stasiun NTB'
        );

        $kepala->givePermissionTo([

            'dashboard.view',

            'surat.view',

            'approval.view',
            'approval.approve',
            'approval.reject',

            'disposisi.view',

            'arsip.view',

            'grafik.view',

        ]);


        $pegawaiRoles = [

            'Humas',
            'Dokpus',
            'Produser',

        ];


        foreach ($pegawaiRoles as $roleName) {

            $role = Role::findByName($roleName);


            $role->givePermissionTo([

                'dashboard.view',

                'surat.view',

                'surat.create',

                'surat.edit',

                'disposisi.view',

                'arsip.view',

            ]);

        }

    }
}