<?php

namespace App\Http\Controllers\Tietong;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;

class TietongLoginController extends TietongController
{
    /**
     * 登录页面
     *
     * @return $this|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function login()
    {
        $is_login = parent::get_user();

        if (is_null($is_login)) {

            $account = \Illuminate\Support\Facades\Cookie::get('tietongmaster_account_number');

            $login_files_times = session('login_files_times');

            if (is_null($login_files_times)) {

                $login_files_times = 0;

                session(['login_files_times' => 0]);
            }

            return parent::return_view('tietongMasterLogin', [
                'account_number' => $account,
                'login_files_times' => $login_files_times,
            ]);
        } else {

            return redirect('tietong-man');
        }
    }

    /**
     * 登录工作
     *
     * @param Request $request
     * @return $this|bool|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        //获取验证条件
        $rules = self::index_login_rules();

        //验证失败错误数组
        $messages = [
            'account_number.required' => '请输入账号',
            'account_number.alpha_dash' => '账号中含有无法识别的字符',
            'account_number.between' => '请输入6-24位的账号',
            'password.required' => '请输入密码',
            'password.alpha_dash' => '密码中含有无法识别的字符',
            'password.between' => '请输入6-30位的密码',
            'code.required' => '请输入验证码',
            'code.captcha' => '验证码输入错误',
        ];

        $try = parent::return_validator($request->all(), $rules, $messages);
        if ($try['status'] === 'fails') return parent::return_back($try['test']);

        $remember = $request->get('remember') ? 1 : 0;

        if (Auth::guard('tietongmaster')->attempt([
            'young_account_number' => $request->account_number,
            'password' => $request->password],
            $remember)) {

            if ($remember) {

                Cookie::queue('tietongmaster_account_number', $request->account_number, 60 * 24 * 3);
            } else {

                Cookie::queue('tietongmaster_account_number', null, -1);
            }

            $request->session()->forget('login_files_times');

            self::tietongmaster_change();

            return redirect('/tietong-man');
        } else {

            self::login_files();

            return parent::return_back(['账号密码错误']);
        }
    }

    /**
     * 判断是否需要验证验证码
     *
     * @return array
     */
    private function index_login_rules()
    {
        $rules = [
            'account_number' => 'required|alpha_dash|between:6,24',
            'password' => 'required|alpha_dash|between:6,24',
            'remember' => 'nullable|boolean',
        ];

        $login_files_times = session('login_files_times');

        //未获取到session
        if (is_null($login_files_times)) {

            //将session设定为3
            session(['login_files_times' => 3]);

            //需验证验证码
            $rules['code'] = 'required|captcha';

            //session大于等于3
        } elseif ($login_files_times >= 3) {

            //需验证验证码
            $rules['code'] = 'required|captcha';

            //session小于3
        } else {

            //无需验证验证码
            $rules['code'] = 'nullable|captcha';

        }

        return $rules;
    }

    /**
     * 登录失败,登录失败次数+1
     */
    private function login_files()
    {
        $files = session('login_files_times');

        if (is_null($files)) $files = 0;

        session(['login_files_times' => ($files + 1)]);
    }

    private function tietongmaster_change()
    {
        $tietongmaster = Auth::guard('tietongmaster')->user();

        //修改会员登录资料
        $tietongmaster->young_login_times += 1;
        $tietongmaster->young_last_login_time = $tietongmaster->young_this_login_time;
        $tietongmaster->young_this_login_time = parent::return_date();
        $tietongmaster->young_last_login_ip = $tietongmaster->young_this_login_ip;
        $tietongmaster->young_this_login_ip = $tietongmaster["REMOTE_ADDR"];
        $tietongmaster->save();
    }
}
