<?php
#app/Modules/Cms/Controllers/Content.php
namespace App\Modules\Cms\Controllers;

use App\Admin\Models\AdminMenu;
use App\Models\AdminConfig;
use App\Modules\Cms\Models\CmsCategory;
use App\Modules\Cms\Models\CmsCategoryDescription;
use App\Modules\Cms\Models\CmsContent;
use App\Modules\Cms\Models\CmsContentDescription;
use App\Modules\Cms\Models\CmsImage;
use App\Modules\ModuleDefault;

class Content extends \App\Http\Controllers\GeneralController
{
    use ModuleDefault;

    protected $configType = 'Modules';
    protected $configCode = 'Cms';
    protected $configKey = 'Content';

    public $title;
    public $version;
    public $auth;
    public $link;
    public $image;
    const ON = 1;
    const OFF = 0;
    public function __construct()
    {
        parent::__construct();
        $this->title = trans($this->configType . '/' . $this->configCode . '/' . $this->configKey . '.title');
        $this->image = 'images/' . $this->configType . '/' . $this->configCode . '/' . $this->configKey . '.png';
        $this->version = '1.0';
        $this->auth = 'Naruto';
        $this->link = 'https://s-cart.org';
        view()->addNamespace($this->configKey, app_path($this->configType . '/' . $this->configCode . '/Views'));

    }

    public function processData()
    {
        $arrData = [
            'title' => $this->title,
            'code' => $this->configKey,
            'version' => $this->version,
            'auth' => $this->auth,
            'link' => $this->link,
        ];
        return $arrData;
    }

    public function install()
    {
        $return = ['error' => 0, 'msg' => ''];
        $check = AdminConfig::where('key', $this->configKey)->first();
        if ($check) {
            $return = ['error' => 1, 'msg' => 'Module exist'];
        } else {
            $process = AdminConfig::insert(
                [
                    'code' => $this->configCode,
                    'key' => $this->configKey,
                    'type' => $this->configType,
                    'value' => self::ON, //1- Enable extension; 0 - Disable
                    'detail' => 'lang::' . $this->configType . '/' . $this->configCode . '/' . $this->configKey . '.title',
                ]
            );
            if (!$process) {
                $return = ['error' => 1, 'msg' => 'Error when install'];
            } else {
                $checkMenu = AdminMenu::find('100');
                if (!$checkMenu) {
                    AdminMenu::insert([
                        'id' => 100,
                        'sort' => 102,
                        'parent_id' => 0,
                        'title' => 'lang::Modules/language.cms_manager',
                        'icon' => 'fa-coffee',
                    ]);
                }
                (new CmsCategory)->installExtension();
                (new CmsCategoryDescription)->installExtension();
                (new CmsContent)->installExtension();
                (new CmsContentDescription)->installExtension();
                (new CmsImage)->installExtension();
                AdminMenu::insert(
                    [
                        'parent_id' => 100,
                        'title' => 'lang::Modules/language.cms_category',
                        'icon' => 'fa-folder-open-o',
                        'uri' => 'route::admin_cms_category.index',
                    ]);
                AdminMenu::insert(
                    [
                        'parent_id' => 100,
                        'title' => 'lang::Modules/language.cms_content',
                        'icon' => 'fa-copy',
                        'uri' => 'route::admin_cms_content.index',
                    ]
                );
            }
        }
        return $return;
    }

    public function uninstall()
    {
        $return = ['error' => 0, 'msg' => ''];
        $process = (new AdminConfig)->where('key', $this->configKey)->delete();
        if (!$process) {
            $return = ['error' => 1, 'msg' => 'Error when uninstall'];
        }
        (new CmsCategory)->uninstallExtension();
        (new CmsCategoryDescription)->uninstallExtension();
        (new CmsContent)->uninstallExtension();
        (new CmsContentDescription)->uninstallExtension();
        (new CmsImage)->uninstallExtension();
        //Remove menu
        (new AdminMenu)->where('uri', 'route::admin_cms_category.index')->delete();
        (new AdminMenu)->where('uri', 'route::admin_cms_content.index')->delete();
        if (!(new AdminMenu)->where('parent_id', 100)->count()) {
            (new AdminMenu)->find(100)->delete();
        }

        return $return;
    }
    public function enable()
    {
        $return = ['error' => 0, 'msg' => ''];
        $process = (new AdminConfig)->where('key', $this->configKey)->update(['value' => self::ON]);
        if (!$process) {
            $return = ['error' => 1, 'msg' => 'Error enable'];
        }
        return $return;
    }
    public function disable()
    {
        $return = ['error' => 0, 'msg' => ''];
        $process = (new AdminConfig)->where('key', $this->configKey)->update(['value' => self::OFF]);
        if (!$process) {
            $return = ['error' => 1, 'msg' => 'Error disable'];
        }
        return $return;
    }

//=======================

/**
 * [news description]
 * @return [type] [description]
 */
    public function category($name, $id)
    {
        $category_currently = CmsCategory::find($id);
        $entries = (new CmsCategory)->getContentsToCategory($id, $limit = sc_config('product_new'), $opt = 'paginate');
        return view($this->configKey . '::' . 'cms_category',
            array(
                'title' => $category_currently['title'],
                'description' => $category_currently['description'],
                'keyword' => $category_currently['keyword'],
                'entries' => $entries,
            )
        );
    }

    public function content($name, $id)
    {
        $entry_currently = CmsContent::find($id);
        if ($entry_currently) {
            $title = ($entry_currently) ? $entry_currently->title : trans('front.not_found');
            return view($this->configKey . '::' . 'cms_entry_detail',
                array(
                    'title' => $title,
                    'entry_currently' => $entry_currently,
                    'description' => $entry_currently['description'],
                    'keyword' => $entry_currently['keyword'],
                    'og_image' => $entry_currently->getImage(),
                )
            );
        } else {
            return view('templates.' . sc_store('template') . '.notfound',
                array(
                    'title' => trans('front.not_found'),
                    'description' => '',
                    'keyword' => sc_store('keyword'),
                )
            );
        }

    }
}
