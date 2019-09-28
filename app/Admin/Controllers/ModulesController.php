<?php
#app/Http/Admin/Controllers/ModulesController.php
namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ModulesController extends Controller
{
    public $namespaceGroup;
    /**
     * Index interface.
     *
     * @return Content
     */
    public function __construct()
    {
        $this->namespaceGroup = [
            'Cms' => '\App\Modules\Cms\Controllers',
            'Other' => '\App\Modules\Other\Controllers',
            'Block' => '\App\Modules\Block\Controllers',
        ];

    }
    public function index($group)
    {
        $body = $this->modulesGroup($group);
        return $body;
    }

    protected function modulesGroup($group)
    {
        $group = sc_word_format_class($group);
        $modulesInstalled = sc_get_extension($group, $onlyActive = false);
        $modules = \FindClass::classNames('Modules', $group);
        $namespace = $this->namespaceGroup[$group];
        $title = trans('Modules/language.' . $group);
        return $this->render($modulesInstalled, $modules, $namespace, $title, $group);
    }

    public function render($modulesInstalled, $modules, $namespace, $title, $group)
    {
        return view('admin.screen.module')->with(
            [
                "title" => $title,
                "namespace" => $namespace,
                "modulesInstalled" => $modulesInstalled,
                "modules" => $modules,
                "group" => $group,
            ]);
    }

    public function install()
    {
        $key = request('key');
        $group = request('group');
        $group = sc_word_format_class($group);
        $namespace = $this->namespaceGroup[$group];
        $class = $namespace . '\\' . $key;
        $response = (new $class)->install();
        return json_encode($response);
    }
    public function uninstall()
    {
        $key = request('key');
        $group = request('group');
        $group = sc_word_format_class($group);
        $namespace = $this->namespaceGroup[$group];
        $class = $namespace . '\\' . $key;
        $response = (new $class)->uninstall();
        return json_encode($response);
    }
    public function enable()
    {
        $key = request('key');
        $group = request('group');
        $group = sc_word_format_class($group);
        $namespace = $this->namespaceGroup[$group];
        $class = $namespace . '\\' . $key;
        $response = (new $class)->enable();
        return json_encode($response);
    }
    public function disable()
    {
        $key = request('key');
        $group = request('group');
        $group = sc_word_format_class($group);
        $namespace = $this->namespaceGroup[$group];
        $class = $namespace . '\\' . $key;
        $response = (new $class)->disable();
        return json_encode($response);
    }
    public function process($group, $key)
    {
        $data = request()->all();
        $group = sc_word_format_class($group);
        $namespace = $this->namespaceGroup[$group];
        $class = $namespace . '\\' . $key;
        $response = (new $class)->processConfig($data);
        return json_encode($response);
    }
}
