<?php
#app/Http/Controller/ContentFront.php
namespace App\Http\Controllers;

use App\Models\EmailTemplate;
use App\Models\ShopNews;
use App\Models\ShopPage;
use Illuminate\Http\Request;

class ContentFront extends GeneralController
{
    public function __construct()
    {
        parent::__construct();
    }

/**
 * [getContact description]
 * @return [type] [description]
 */
    public function getContact()
    {
        $page = $this->getPage('contact');
        return view('templates.' . sc_store('template') . '.shop_contact',
            array(
                'title' => trans('front.contact'),
                'description' => '',
                'page' => $page,
                'keyword' => '',
                'og_image' => '',
            )
        );
    }

/**
 * [postContact description]
 * @param  Request $request [description]
 * @return [type]           [description]
 */
    public function postContact(Request $request)
    {
        $validator = $request->validate([
            'name' => 'required',
            'title' => 'required',
            'content' => 'required',
            'email' => 'required|email',
            'phone' => 'required|regex:/^0[^0][0-9\-]{7,13}$/',
        ], [
            'name.required' => trans('validation.required'),
            'content.required' => trans('validation.required'),
            'title.required' => trans('validation.required'),
            'email.required' => trans('validation.required'),
            'email.email' => trans('validation.email'),
            'phone.required' => trans('validation.required'),
            'phone.regex' => trans('validation.phone'),
        ]);
        //Send email
        $data = $request->all();
        $data['content'] = str_replace("\n", "<br>", $data['content']);

        if (sc_config('contact_to_admin')) {
            $checkContent = (new EmailTemplate)->where('group', 'contact_to_admin')->where('status', 1)->first();
            if ($checkContent) {
                $content = $checkContent->text;
                $dataFind = [
                    '/\{\{\$title\}\}/',
                    '/\{\{\$name\}\}/',
                    '/\{\{\$email\}\}/',
                    '/\{\{\$phone\}\}/',
                    '/\{\{\$content\}\}/',
                ];
                $dataReplace = [
                    $data['title'],
                    $data['name'],
                    $data['email'],
                    $data['phone'],
                    $data['content'],
                ];
                $content = preg_replace($dataFind, $dataReplace, $content);
                $data_email = [
                    'content' => $content,
                ];

                $config = [
                    'to' => sc_store('email'),
                    'replyTo' => $data['email'],
                    'subject' => $data['title'],
                ];
                sc_send_mail('mail.contact_to_admin', $data_email, $config, []);
            }

        }

        return redirect()->route('contact')->with('success', trans('front.thank_contact'));

    }

/**
 * [pages description]
 * @param  [type] $key [description]
 * @return [type]      [description]
 */
    public function pages($key = null)
    {
        $page = $this->getPage($key);
        if ($page) {
            return view('templates.' . sc_store('template') . '.shop_page',
                array(
                    'title' => $page->title,
                    'description' => '',
                    'keyword' => '',
                    'page' => $page,
                ));
        } else {
            return $this->pageNotFound();
        }
    }

/**
 * [getPage description]
 * @param  [type] $key [description]
 * @return [type]      [description]
 */
    public function getPage($key = null)
    {
        return ShopPage::where('key', $key)->where('status', 1)->first();
    }

/**
 * [news description]
 * @return [type] [description]
 */
    public function news()
    {
        $news = (new ShopNews)->getItemsNews($limit = sc_config('product_new'), $opt = 'paginate');
        return view('templates.' . sc_store('template') . '.shop_news',
            array(
                'title' => trans('front.blog'),
                'description' => sc_store('description'),
                'keyword' => sc_store('keyword'),
                'news' => $news,
            )
        );
    }

    public function newsDetail($name, $id)
    {
        $news_currently = ShopNews::find($id);
        if ($news_currently) {
            $title = ($news_currently) ? $news_currently->title : trans('front.not_found');
            return view('templates.' . sc_store('template') . '.shop_news_detail',
                array(
                    'title' => $title,
                    'news_currently' => $news_currently,
                    'description' => sc_store('description'),
                    'keyword' => sc_store('keyword'),
                    'blogs' => (new ShopNews)->getItemsNews($limit = 4),
                    'og_image' => $news_currently->getImage(),
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
