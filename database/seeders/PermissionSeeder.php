<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            // Posts
            ['name' => 'posts.view', 'display_name' => 'View Posts', 'group' => 'Posts'],
            ['name' => 'posts.create', 'display_name' => 'Create Posts', 'group' => 'Posts'],
            ['name' => 'posts.edit', 'display_name' => 'Edit Posts', 'group' => 'Posts'],
            ['name' => 'posts.delete', 'display_name' => 'Delete Posts', 'group' => 'Posts'],

            // Registrations
            ['name' => 'registrations.view', 'display_name' => 'View Registrations', 'group' => 'Registrations'],
            ['name' => 'registrations.edit', 'display_name' => 'Edit Registrations', 'group' => 'Registrations'],
            ['name' => 'registrations.delete', 'display_name' => 'Delete Registrations', 'group' => 'Registrations'],
            ['name' => 'registrations.export', 'display_name' => 'Export Registrations CSV', 'group' => 'Registrations'],

            // Higher Secondary Registrations
            ['name' => 'hs_registrations.view', 'display_name' => 'View HS Registrations', 'group' => 'HS Registrations'],
            ['name' => 'hs_registrations.edit', 'display_name' => 'Edit HS Registrations', 'group' => 'HS Registrations'],
            ['name' => 'hs_registrations.export', 'display_name' => 'Export HS Registrations CSV', 'group' => 'HS Registrations'],

            // Notifications
            ['name' => 'notifications.view', 'display_name' => 'View Notifications', 'group' => 'Notifications'],
            ['name' => 'notifications.create', 'display_name' => 'Create Notifications', 'group' => 'Notifications'],
            ['name' => 'notifications.edit', 'display_name' => 'Edit Notifications', 'group' => 'Notifications'],
            ['name' => 'notifications.delete', 'display_name' => 'Delete Notifications', 'group' => 'Notifications'],

            // Staff Profiles
            ['name' => 'profiles.view', 'display_name' => 'View Profiles', 'group' => 'Staff Profiles'],
            ['name' => 'profiles.create', 'display_name' => 'Create Profiles', 'group' => 'Staff Profiles'],
            ['name' => 'profiles.edit', 'display_name' => 'Edit Profiles', 'group' => 'Staff Profiles'],
            ['name' => 'profiles.delete', 'display_name' => 'Delete Profiles', 'group' => 'Staff Profiles'],

            // Departments
            ['name' => 'departments.view', 'display_name' => 'View Departments', 'group' => 'Departments'],
            ['name' => 'departments.create', 'display_name' => 'Create Departments', 'group' => 'Departments'],
            ['name' => 'departments.edit', 'display_name' => 'Edit Departments', 'group' => 'Departments'],
            ['name' => 'departments.delete', 'display_name' => 'Delete Departments', 'group' => 'Departments'],

            // Settings & Site Modules
            ['name' => 'settings.manage', 'display_name' => 'Manage Settings', 'group' => 'Settings'],
            ['name' => 'site_modules.manage', 'display_name' => 'Manage Site Modules', 'group' => 'Site Modules'],
            ['name' => 'users.manage', 'display_name' => 'Manage User Permissions', 'group' => 'User Management'],
        ];

        foreach ($permissions as $perm) {
            Permission::updateOrCreate(['name' => $perm['name']], $perm);
        }
    }
}
