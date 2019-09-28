<?php
use App\Library\Helper;
use App\Models\AdminConfig;
use App\Models\AdminStore;
use App\Models\ShopBlockContent;
use App\Models\ShopLanguage;
use App\Models\ShopLink;

/*
Get extension in group
 */
if (!function_exists('sc_get_extension')) {
    function sc_get_extension($group, $onlyActive = true)
    {
        return AdminConfig::getExtensionsGroup($group, $onlyActive);
    }
}

/*
Get all block content
 */
if (!function_exists('sc_link')) {
    function sc_link()
    {
        if (Helper::$layoutsUrl !== null) {
            return Helper::$layoutsUrl;
        }
        Helper::$layoutsUrl = ShopLink::getGroup();
        return Helper::$layoutsUrl;
    }
}

/*
Get all layouts
 */
if (!function_exists('sc_block_content')) {
    function sc_block_content()
    {
        if (Helper::$layouts !== null) {
            return Helper::$layouts;
        }
        Helper::$layouts = ShopBlockContent::getLayout();
        return Helper::$layouts;
    }
}

/*
String to Url
 */
if (!function_exists('sc_word_format_url')) {
    function sc_word_format_url($str)
    {
        $unicode = array(
            'a' => 'á|à|ả|ã|ạ|ă|ắ|ặ|ằ|ẳ|ẵ|â|ấ|ầ|ẩ|ẫ|ậ',
            'd' => 'đ',
            'e' => 'é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ',
            'i' => 'í|ì|ỉ|ĩ|ị',
            'o' => 'ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ',
            'u' => 'ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự',
            'y' => 'ý|ỳ|ỷ|ỹ|ỵ',
            'A' => 'Á|À|Ả|Ã|Ạ|Ă|Ắ|Ặ|Ằ|Ẳ|Ẵ|Â|Ấ|Ầ|Ẩ|Ẫ|Ậ',
            'D' => 'Đ',
            'E' => 'É|È|Ẻ|Ẽ|Ẹ|Ê|Ế|Ề|Ể|Ễ|Ệ',
            'I' => 'Í|Ì|Ỉ|Ĩ|Ị',
            'O' => 'Ó|Ò|Ỏ|Õ|Ọ|Ô|Ố|Ồ|Ổ|Ỗ|Ộ|Ơ|Ớ|Ờ|Ở|Ỡ|Ợ',
            'U' => 'Ú|Ù|Ủ|Ũ|Ụ|Ư|Ứ|Ừ|Ử|Ữ|Ự',
            'Y' => 'Ý|Ỳ|Ỷ|Ỹ|Ỵ',
        );

        foreach ($unicode as $nonUnicode => $uni) {
            $str = preg_replace("/($uni)/i", $nonUnicode, $str);
        }
        return strtolower(preg_replace(
            array('/[\'\/~`\!@#\$%\^&\*\(\)\+=\{\}\[\]\|;:"\<\>,\.\?\\\]/', '/[\s-]+|[-\s]+|[--]+/', '/^[-\s_]|[-_\s]$/'),
            array('', '-', ''),
            strtolower($str)));
    }
}

/*
Config info
 */
if (!function_exists('sc_config')) {
    function sc_config($key = null, $default = null)
    {
        $allConfig = AdminConfig::getAll();
        if ($key == null) {
            return $allConfig;
        }
        if (!array_key_exists($key, $allConfig)) {
            return $default;
        } else {
            return trim($allConfig[$key]);
        }
    }
}

/*
Store info
 */
if (!function_exists('sc_store')) {
    function sc_store($key = null, $default = null)
    {
        $allStoreInfo = AdminStore::getData()->toArray();
        $lang = app()->getLocale();
        $descriptions = $allStoreInfo['descriptions'];
        foreach ($descriptions as $row) {
            if ($lang == $row['lang']) {
                $allStoreInfo += $row;
            }
        }
        if ($key == null) {
            return $allStoreInfo;
        }
        if (!array_key_exists($key, $allStoreInfo)) {
            return $default;
        } else {
            return is_array($allStoreInfo[$key]) ?: trim($allStoreInfo[$key]);
        }
    }
}

/*
url render
 */
if (!function_exists('sc_url_render')) {
    function sc_url_render($string)
    {
        $arrCheckRoute = explode('route::', $string);
        $arrCheckUrl = explode('admin::', $string);

        if (count($arrCheckRoute) == 2) {
            $arrRoute = explode('::', $string);
            if (isset($arrRoute[2])) {
                return route($arrRoute[1], $arrRoute[2]);
            } else {
                return route($arrRoute[1]);
            }
        }

        if (count($arrCheckUrl) == 2) {
            $string = \Illuminate\Support\Str::start($arrCheckUrl[1], '/');
            $string = config('app.admin_prefix') . $string;
            return url($string);
        }
        return url($string);
    }
}

//Get all language
if (!function_exists('sc_language_all')) {
    function sc_language_all()
    {
        if (Helper::$languages !== null) {
            return Helper::$languages;
        }
        Helper::$languages = ShopLanguage::getList();
        return Helper::$languages;
    }
}

/*
Render language
 */
if (!function_exists('sc_language_render')) {
    function sc_language_render($string)
    {
        $arrCheck = explode('lang::', $string);
        if (count($arrCheck) == 2) {
            return trans($arrCheck[1]);
        } else {
            return trans($string);
        }
    }
}
/*
Create random token
 */
if (!function_exists('sc_html_render')) {
    function sc_html_render($string)
    {
        $string = htmlspecialchars_decode($string);
        return $string;
    }
}

/*
Format class name
 */
if (!function_exists('sc_word_format_class')) {
    function sc_word_format_class($word)
    {
        $word = strtolower($word);
        $arr = explode('_', $word);
        $arr = array_map(function ($v) {
            return ucfirst($v);
        }, $arr);
        $word = implode('', $arr);
        return $word;
    }
}

/*
Truncates words
 */
if (!function_exists('sc_word_limit')) {
    function sc_word_limit($word, $limit = 20, $arg = '')
    {
        $word = \Illuminate\Support\Str::limit($word, $limit, $arg);
        return $word;
    }
}

/**
 * Clear data
 */
if (!function_exists('sc_clean')) {
    function sc_clean($data = null, $exclude = [], $level_hight = null)
    {
        if ($level_hight) {
            if (is_array($data)) {
                $data = array_map(function ($v) {
                    return strip_tags($v);
                }, $data);
            } else {
                $data = strip_tags($data);
            }
        }
        if (is_array($data)) {
            array_walk($data, function (&$v, $k) use ($exclude, $level_hight) {
                if (is_array($v)) {
                    $v = sc_clean($v, $exclude, $level_hight);
                } else {
                    if ((is_array($exclude) && in_array($k, $exclude)) || (!is_array($exclude) && $k == $exclude)) {
                        $v = $v;
                    } else {
                        $v = htmlspecialchars_decode($v);
                        $v = htmlspecialchars($v, ENT_COMPAT, 'UTF-8');
                    }
                }
            });
        } else {
            $data = htmlspecialchars_decode($data);
            $data = htmlspecialchars($data, ENT_COMPAT, 'UTF-8');
        }
        return $data;
    }
}

/*
Create random token
 */
if (!function_exists('sc_token')) {
    function sc_token($length = 32)
    {
        $token = \Illuminate\Support\Str::random($length);
        return $token;
    }
}

/*
Create write log
 */
if (!function_exists('sc_log')) {
    function sc_log($msg, $action = null)
    {
        \Illuminate\Support\Facades\Log::error($msg);
    }
}

/*
Render block
 */
if (!function_exists('sc_block_render')) {
    function sc_block_render($nameSpace)
    {
        return \App\Library\FindClass::renderClass($nameSpace);
    }
}
