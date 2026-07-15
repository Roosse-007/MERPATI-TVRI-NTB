<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [

            // Dashboard
            'dashboard.view',

            // Surat
            'surat.view',
            'surat.create',
            'surat.edit',
            'surat.delete',

            // Approval
            'approval.view',
            'approval.approve',
            'approval.reject',

            // Disposisi
            'disposisi.view',
            'disposisi.create',

            // Arsip
            'arsip.view',
            'arsip.create',

            // Notifikasi
            'notifikasi.view',

            // User
            'user.view',
            'user.create',
            'user.edit',
            'user.delete',

            // Master
            'master.view',
            'master.create',
            'master.edit',
            'master.delete',

            // Target
            'target.view',
            'target.create',
            'target.edit',

            // Grafik
            'grafik.view',

            // Log
            'activity.view',

        ];

        foreach ($permissions as $permission) {

            Permission::firstOrCreate([
                'name' => $permission,
                'guard_name' => 'web'
            ]);

        }
    }
}