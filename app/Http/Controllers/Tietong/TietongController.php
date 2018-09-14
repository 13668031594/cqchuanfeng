<?php

namespace App\Http\Controllers\Tietong;

use App\Http\Controllers\Admin\MySqlSelectGroup;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class TietongController extends Controller
{
    /**
     * 寻找登录这模型
     *
     * @return array
     */
    public function get_user()
    {
        //获取登录人实例
        $user = Auth::guard('tietongmaster')->user();

        if (is_null($user))return null;

        //返回登陆人员实例
        return $user->toArray();
    }

    /**
     * 返回上一层,并携带错误代码与表单内容
     *
     * @param array $errors
     * @return $this
     */
    protected function return_back($errors = [])
    {
        return back()->withErrors($errors)->withInput();
    }

    /**
     * 返回数据库操作时的错误代码之类
     *
     * @param array $result
     * @param string $url
     * @param string $button
     * @param bool $again
     * @return string
     */
    protected function return_save($result = [], $url = '', $button = '', $again = false)
    {
        if (is_array($result) && isset($result['status']) && isset($result['test'])) {

            if ($result['status'] == 'success') {

                return self::return_ajax(true, $result['test'], $url, $button, $again);
            } elseif ($result['status'] == 'fails') {

                return self::return_ajax(false, $result['test']);
            }
        }

        return self::return_ajax(false, ['请刷新重试(ajax)']);
    }

    /**
     * 返回ajax字符串
     *
     * @param $state
     * @param $text
     * @param string $url
     * @param string $button
     * @param bool $again
     * @return string
     */
    public function return_ajax($state, $text, $url = '', $button = '', $again = false)
    {
        if (!is_array($text)) $text = [$text];

        $result = [
            'state' => $state,
            'text' => $text,
            'url' => $url,
            'buttonText' => $button,
            'again' => $again,
        ];

        return json_encode($result);
    }

    /**
     * 根据数组情况反馈ajax信息
     *
     * @param $array
     * @return string
     */
    protected function return_ajax_array($array, $url = '', $button = '', $again = null)
    {
        /**
         * 条件判断
         */
        if (!is_array($array)) {

            //参数不是数组

            return self::return_ajax(false, ['请刷新重试(001001)']);
        } elseif (!isset($array['status'])) {

            //状态码未定义

            return self::return_ajax(false, ['请刷新重试(001002)']);
        } elseif ($array['status'] == 'fails') {

            //错误

            return self::return_ajax(false, $array['test']);
        } elseif ($array['status'] == 'success') {

            //成功

            return self::return_ajax(true, $array['test'], $url, $button, empty($again) ? false : true);
        } else {

            //未知状态码

            return self::return_ajax(false, ['请刷新重试(001003)']);
        }
    }

    /**
     * 根据来访设备信息,删除相应页面
     *
     * @param $location
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    protected function return_view($location, $array = [])
    {
        $add = 'Tietong.';
        $css = '/css/tietong';

        //加入css路径
        $array['css'] = $css;

        return view($add . $location, $array);
    }

    /**
     * 判断是否为手机端访问
     * true手机端
     * false非手机端
     *
     * @return bool
     */
    protected function isMobile()
    {
        // 如果有HTTP_X_WAP_PROFILE则一定是移动设备
        if (isset ($_SERVER['HTTP_X_WAP_PROFILE'])) {
            return TRUE;
        }
        // 如果via信息含有wap则一定是移动设备,部分服务商会屏蔽该信息
        if (isset ($_SERVER['HTTP_VIA'])) {
            return stristr($_SERVER['HTTP_VIA'], "wap") ? TRUE : FALSE;// 找不到为flase,否则为TRUE
        }
        // 判断手机发送的客户端标志,兼容性有待提高
        if (isset ($_SERVER['HTTP_USER_AGENT'])) {
            $clientkeywords = array(
                'mobile',
                'nokia',
                'sony',
                'ericsson',
                'mot',
                'samsung',
                'htc',
                'sgh',
                'lg',
                'sharp',
                'sie-',
                'philips',
                'panasonic',
                'alcatel',
                'lenovo',
                'iphone',
                'ipod',
                'blackberry',
                'meizu',
                'android',
                'netfront',
                'symbian',
                'ucweb',
                'windowsce',
                'palm',
                'operamini',
                'operamobi',
                'openwave',
                'nexusone',
                'cldc',
                'midp',
                'wap'
            );
            // 从HTTP_USER_AGENT中查找手机浏览器的关键字
            if (preg_match("/(" . implode('|', $clientkeywords) . ")/i", strtolower($_SERVER['HTTP_USER_AGENT']))) {
                return TRUE;
            }
        }

        if (isset ($_SERVER['HTTP_ACCEPT'])) { // 协议法，因为有可能不准确，放到最后判断
            // 如果只支持wml并且不支持html那一定是移动设备
            // 如果支持wml和html但是wml在html之前则是移动设备
            if ((strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') !== FALSE) && (strpos($_SERVER['HTTP_ACCEPT'], 'text/html') === FALSE || (strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') < strpos($_SERVER['HTTP_ACCEPT'], 'text/html')))) {
                return TRUE;
            }
        }

        return FALSE;
    }

    /**
     * 返回翻页数组
     *
     * @param $model
     * @param array $where
     * @param array $whereIn
     * @return array
     */
    protected function return_list($model, $where = [], $whereIn = [], $ajax = false)
    {
        /**
         * 新建筛选方法,sql组合
         */
        $sql_groups = new MySqlSelectGroup();
        if ($ajax) {

            $result = $sql_groups->select_group($model);
        } else {

            $result = $sql_groups->select_group($model, '2');

        }
        $model = $result['model'];
        $sql = $result['where'];
        /**
         * sql组合结束
         */

        $request = \request();
        $order_name = is_null($request->get('order_name')) ? 'id' : $request->get('order_name');
        $order_type = is_null($request->get('order_type')) ? 'desc' : $request->get('order_type');
        if ($order_type === 0 || $order_type === '0') $order_type = 'asc';

        $name = $request->get('name');
        $nickname = $request->get('nickname');
        $number = (int)$request->get('number');

        $array = $model->orderBy($order_name, $order_type);

        if (!empty($name)) $array = $array->where('name', 'like', '%' . $name . '%');

        if (!empty($nickname)) $array = $array->where('nickname', 'like', '%' . $nickname . '%');

        $appends = [
            'name' => $name,
            'nickname' => $nickname,
            'number' => $number,
            'order_type' => $order_type,
            'order_name' => $order_name,
            'theSelectGroups' => $sql,
            'is_page' => '1',
        ];

        if (!empty($where)) {

            $array = $array->where($where);

            foreach ($where as $k => $v) {

                $appends[$k] = $v;

            }
        }

        if (!empty($whereIn)) {

            foreach ($whereIn as $k => $v) {

                $array = $array->whereIn($v['name'], $v['value']);

                $appends[$v['name']] = $v['value'];
            }
        }

        $array = $array->paginate(empty($number) ? 20 : $number);

        $page = self::return_page($array->appends($appends)->toArray());

        $a = [
            'list' => $array,
            'page' => $page,
            'name' => $name,
            'nickname' => $name,
            'number' => $number,
            'order_name' => $order_name,
            'order_type' => $order_type,
            'theSelectGroups' => $sql,
        ];

        return $a;
    }

    /**
     * 返回翻页字符串
     *
     * @param array $array
     * @return int|mixed|string
     */
    protected function return_page($array = [], $wheres = [])
    {
        $path = $array['path'] . '?page=';
        $currentPage = $array['current_page'];
        $lastPage = $array['last_page'];

        if (empty($wheres)) {

            $where = '';

        } else {

            $where = '&';

            foreach ($wheres as $k => $v) {

                $where .= '&' . $k . '=' . $v;

            }

        }

        /*$page = '<div class="table-page">
                <a class="page-cell" href="' . $path . '1' . $where . '">首页</a>
                <a class="page-cell" href="' . $path . ($currentPage == 1 ? 1 : ($currentPage - 1)) . $where . '">上一页</a>
                <span>当前：' . $currentPage . '/' . $lastPage . '</span>
                <a class="page-cell" href="' . $path . ($currentPage == $lastPage ? $lastPage : ($currentPage + 1)) . $where . '">下一页</a>
                <a class="page-cell" href="' . $path . $lastPage . $where . '">尾页</a>
            </div>';*/

        $page = '<div class="table-page">
                    <input class="last_page" type="hidden" value="' . $lastPage . '"/>
                    <input class="current_page" type="hidden" value="' . $currentPage . '"/>
                    <input class="pages" type="hidden" name="page" value=""/>
                    <button id="firstPage" class="page-cell" type="submit" name="" value="">首页</button>
                    <button id="prevPage" class="page-cell" type="submit" name="" value="">上一页</button>
                    <span>当前：' . $currentPage . '/' . $lastPage . '</span>
                    <button id="nextPage" class="page-cell" type="submit" name="" value="">下一页</button>
                    <button id="lastPage" class="page-cell" type="submit" name="" value="">尾页</button>
                </div>';

        return $page;
    }

    /**
     * 手机端翻页
     *
     * @param $array
     * @return mixed
     */
    protected function mobile_page($array)
    {
        //判断是否由手机端翻页
        if (!is_null(\request()->get('mobile'))) {

            $return = $array->toArray();
            return $return['data'];
        } else {

            return false;
        }
    }
}
