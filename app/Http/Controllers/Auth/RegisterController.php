<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\GeneralController;
use App\Models\EmailTemplate;
use App\Models\ShopUser;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RegisterController extends GeneralController
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
     */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    // protected $redirectTo = '/home';
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'reg_first_name' => 'required|string|max:100',
            'reg_last_name' => 'required|string|max:100',
            'reg_email' => 'required|string|email|max:255|unique:' . (new ShopUser)->getTable() . ',email',
            'reg_password' => 'required|string|min:6|confirmed',
            'reg_phone' => 'required|regex:/^0[^0][0-9\-]{7,13}$/',
            'reg_address1' => 'required|string|max:255',
            'reg_address2' => 'required|string|max:255',
            'reg_country' => 'required',
        ]
        );
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {

        $user = ShopUser::createCustomer([
            'first_name' => $data['reg_first_name'],
            'last_name' => $data['reg_last_name'],
            'email' => $data['reg_email'],
            'password' => bcrypt($data['reg_password']),
            'phone' => $data['reg_phone'],
            'address1' => $data['reg_address1'],
            'address2' => $data['reg_address2'],
            'country' => $data['reg_country'],
        ]);
        if ($user) {
            if (sc_config('welcome_customer')) {

                $checkContent = (new EmailTemplate)->where('group', 'welcome_customer')->where('status', 1)->first();
                if ($checkContent) {
                    $content = $checkContent->text;
                    $dataFind = [
                        '/\{\{\$title\}\}/',
                    ];
                    $dataReplace = [
                        trans('email.welcome_customer.title'),
                    ];
                    $content = preg_replace($dataFind, $dataReplace, $content);
                    $data_mail = [
                        'content' => $content,
                    ];

                    $config = [
                        'to' => $data['reg_email'],
                        'subject' => trans('email.welcome_customer.title'),
                    ];

                    sc_send_mail('mail.welcome_customer', $data_mail, $config, []);
                }

            }
        } else {

        }
        return $user;
    }
    public function showRegistrationForm()
    {
        return redirect()->route('register');
        // return view('auth.register');
    }

    protected function registered(Request $request, $user)
    {
        redirect()->route('home')->with(['message' => trans('account.register_success')]);
    }
}
