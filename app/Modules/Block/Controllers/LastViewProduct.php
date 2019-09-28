<?php
#app/Modules/Block/Controllers/LastViewProduct.php
namespace App\Modules\Block\Controllers;

use App\Models\AdminConfig;
use App\Models\ShopBlockContent;
use App\Models\ShopProduct;
use App\Modules\ModuleDefault;

class LastViewProduct extends \App\Http\Controllers\GeneralController
{
    use ModuleDefault;

    protected $configType = 'Modules';
    protected $configCode = 'Block';
    protected $configKey = 'LastViewProduct';
    protected $namespace = '';

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
        $this->namespace = '\App\\' . $this->configType . '\\' . $this->configCode . '\\Controllers\\' . $this->configKey;
        $this->title = trans($this->configType . '/' . $this->configCode . '/' . $this->configKey . '.title');
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
            $this->processDefault();
            if (!$process) {
                $return = ['error' => 1, 'msg' => 'Error when install'];
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
        (new ShopBlockContent)->where('text', $this->namespace)->delete();
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

    public function render()
    {
        if (!empty(sc_config($this->configKey))) {
            $arrProductsLastView = array();
            $lastView = empty(\Cookie::get('productsLastView')) ? [] : json_decode(\Cookie::get('productsLastView'), true);
            if ($lastView) {
                arsort($lastView);
            }

            if (count($lastView)) {
                $lastView = array_slice($lastView, 0, 5, true);
                $productsLastView = ShopProduct::whereIn('id', array_keys($lastView))->get();
                foreach ($lastView as $pId => $time) {
                    foreach ($productsLastView as $key => $product) {
                        if ($product['id'] == $pId) {
                            $product['timelastview'] = $time;
                            $arrProductsLastView[] = $product;
                        }
                    }
                }
            }
            return view($this->configKey . '::' . $this->configKey, ['arrProductsLastView' => $arrProductsLastView]);
        }
    }

    public function processDefault()
    {
        return $process = ShopBlockContent::insert(
            [
                'name' => $this->title,
                'position' => 'left',
                'page' => '',
                'type' => 'module',
                'text' => $this->namespace,
                'status' => self::ON, //1- Enable extension; 0 - Disable
                'sort' => 0,
            ]
        );

    }

}
