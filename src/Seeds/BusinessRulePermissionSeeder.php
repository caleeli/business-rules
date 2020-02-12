<?php

namespace ProcessMaker\Package\BusinessRules\Seeds;

use Illuminate\Database\Seeder;
use ProcessMaker\Models\Permission;

class BusinessRulePermissionSeeder extends Seeder
{
    const group = 'Business Rules';

    /**
     * Permissions handled by the package
     *
     * @var string
     */
    protected $permissions = [
        'create-business-rules' => 'Create Business Rules',
        'view-business-rules' => 'View Business Rules',
        'edit-business-rules' => 'Edit Business Rules',
        'delete-business-rules' => 'Delete Business Rules',
    ];

    /**
     * Seed Permissions
     */
    public function run()
    {
        $this->update();
    }

    /**
     * update the permissions of Data Connector.
     *
     * @return void
     */
    public function update()
    {
        foreach ($this->permissions as $name => $title) {
            Permission::updateOrCreate([
                'title' => $title,
                'name' => $name,
                'group' => self::group

            ]);
        }
    }

    /**
     * Update the permissions of Data Connector.
     */
    public function delete()
    {
        Permission::where('group', self::group)
            ->delete();
    }
}
