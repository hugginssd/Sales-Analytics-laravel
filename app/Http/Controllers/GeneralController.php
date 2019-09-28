<?php
#app/Http/Controller/GeneralController.php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Subscribe;
use Illuminate\Http\Request;
use Mail;
use View;

class GeneralController extends Controller
{

    public function __construct()
    {
        $languages = sc_language_all();
        $currencies = sc_currency_all();
        $blocksContent = sc_block_content();
        $layoutsUrl = sc_link();
        view()->share('languages', $languages);
        view()->share('currencies', $currencies);
        view()->share('blocksContent', $blocksContent);
        view()->share('layoutsUrl', $layoutsUrl);

        if (sc_config('SITE_STATUS') != 'on') {
            $maintain_content = sc_store('maintain_content') ?? '';
            echo <<<HTML
 <section>
    <div class="container">
      <div class="row">
        <div id="columns" class="container">
          $maintain_content
        </div>
      </div>
    </div>
  </section>
HTML;
            exit;
        }
    }

/**
 * [emailSubscribe description]
 * @param  Request $request [description]
 * @return [type]           [description]
 */
    public function emailSubscribe(Request $request)
    {
        $data = $request->all();
        $validator = $request->validate([
            'subscribe_email' => 'required|email',
        ], [
            'subscribe_email.required' => trans('validation.required'),
            'subscribe_email.email' => trans('validation.email'),
        ]);

        $checkEmail = Subscribe::where('email', $data['subscribe_email'])->first();
        if (!$checkEmail) {
            Subscribe::insert(['email' => $data['subscribe_email']]);
        }
        return redirect()->back()->with(['message' => trans('front.subscribe.subscribe_success')]);
    }

    public function pageNotFound()
    {
        return view('templates.' . sc_store('template') . '.notfound',
            array(
                'title' => '404 - Page not found',
                'msg' => trans('front.page_not_found'),
                'description' => '',
                'keyword' => '',

            )
        );
    }
    public function itemNotFound()
    {
        return view('templates.' . sc_store('template') . '.notfound',
            array(
                'title' => '404 - Item not found',
                'msg' => trans('front.item_not_found'),
                'description' => '',
                'keyword' => '',

            )
        );
    }

}
