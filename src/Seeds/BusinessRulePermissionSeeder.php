<?php

namespace ProcessMaker\Package\BusinessRules\Seeds;

use Illuminate\Database\Seeder;
use ProcessMaker\Models\Permission;
use ProcessMaker\Models\Script;

class BusinessRulePermissionSeeder extends Seeder
{

    const IMPLEMENTATION_ID = 'package-demo/package-demo-code';
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

        $this->updateScripts();
    }

    private function getCode()
    {
        clearstatcache(false, __DIR__ . '/code/BusinessRules.php.php');
        return file_get_contents(__DIR__ . '/code/BusinessRules.php');
    }

    public function updateScripts()
    {
        //Definition script send an email
        $definition = [
            'key' => self::IMPLEMENTATION_ID,
            'title' => 'Evaluate rules',
            'description' => 'Evaluate rules registered',
            'language' => 'PHP',
            'run_as_user_id' => Script::defaultRunAsUser()->id,
            'code' => $this->getCode(),
        ];
        $exists = Script::where('key', self::IMPLEMENTATION_ID)->first();
        if ($exists) {
            $exists->fill($definition);
            $exists->saveOrFail();
        } else {
            $script = factory(Script::class)->make($definition);
            $script->saveOrFail();
        }
    }


    /**
     * Delete the permissions of Data Connector.
     */
    public function delete()
    {
        Permission::where('group', self::group)
            ->delete();
    }
}
