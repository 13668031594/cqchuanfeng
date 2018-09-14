<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class AdminController extends Controller
{
    /**
     * 反馈给前端数据,综合方法
     *
     * @param array $result
     * @return string
     */
    protected function return_html($result = [])
    {
        //判断两个关键值是否被定义
        if (isset($result['status']) && isset($result['test'])) {

            //判断状态码
            switch ($result['status']) {

                case 'success'://成功
                    $return = self::success_html($result['test']);
                    break;
                case 'fails'://失败
                    $return = self::fails_html($result['test']);
                    break;
                case 'error'://报错
                    $return = self::error_html($result['test']);
                    break;
                default://状态吗不符合预期
                    return '状态码错误';
                    break;
            }

        } else {

            //状态码或者反馈信息未被定义
            return '格式错误';
        }

        return $return;
    }

    /**
     * 返回前端成功数据
     *
     * @param $result
     * @return string
     */
    protected function success_html($result = ['操作成功'])
    {
        $array = parent::return_array('success', $result);

        return parent::to_json($array);
    }

    /**
     * 返回前端失败数据
     *
     * @param $result
     * @return string
     */
    protected function fails_html($result = ['操作失败'])
    {
        $array = parent::return_array('fails', $result);

        return parent::to_json($array);
    }

    /**
     * 返回前端错误数据
     *
     * @param array $errors
     * @return string
     */
    protected function error_html($errors = ['未知错误'])
    {
        $array = parent::return_array('error', $errors);

        return parent::to_json($array);
    }

    /**
     * 返回去除前缀后的数组
     *
     * @param $lists
     * @return array
     */
    public function return_list_array($lists)
    {
        $list = $lists->toArray();

        $list['data'] = self::delete_prefix_more($list['data']);

        return $list;
    }

    /**
     * 返回超级管理员类
     *
     * @return SuperMaster
     */
    protected function super_master()
    {

        return new SuperMaster();
    }

    /**
     * 反馈保存数据库信息
     *
     * @param bool $status
     * @return string
     */
    protected function return_save($status = false)
    {
        if ($status) {

            return self::success_html(['操作成功']);
        } else {

            return self::fails_html(['请刷新重试']);
        }
    }

    /**
     * 返回翻页数组
     *
     * @param $model
     * @param array $where
     * @param array $whereIn
     * @return array
     */
    public function index_list($model, $where = [], $whereIn = [], $orderBy = [])
    {
        /**
         * 新建筛选方法,sql组合
         */
        $sql_groups = new MySqlSelectGroup();
        $result = $sql_groups->select_group($model, 1, ['123123']);
        $model = $result['model'];
//        $sql = $result['where'];
        /**
         * sql组合结束
         */

        $request = \request();
        $order_name = is_null($request->get('order_name')) ? (isset($orderBy['order_name']) ? $orderBy['order_name'] : 'id') : $request->get('order_name');
        $order_type = is_null($request->get('order_type')) ? (isset($orderBy['order_type']) ? $orderBy['order_type'] : 'desc') : $request->get('order_type');
        if ($order_type === 0 || $order_type === '0') $order_type = 'asc';

        $number = (int)$request->get('number');

        $array = $model->orderBy($order_name, $order_type);

        if (!empty($where)) {

            $array = $array->where($where);

        }

        if (!empty($whereIn)) {

            foreach ($whereIn as $k => $v) {

                $array = $array->whereIn($v['name'], $v['value']);

            }
        }

        return $array->paginate(empty($number) ? 20 : $number);
    }

    /**
     * 无筛选的列表
     *
     * @param $model
     * @param array $where
     * @param array $whereIn
     * @param array $orderBy
     * @return mixed
     */
    protected function index_list_not_select($model, $where = [], $whereIn = [], $orderBy = [])
    {
        $request = \request();
        $order_name = is_null($request->get('order_name')) ? (isset($orderBy['order_name']) ? $orderBy['order_name'] : 'id') : $request->get('order_name');
        $order_type = is_null($request->get('order_type')) ? (isset($orderBy['order_type']) ? $orderBy['order_type'] : 'desc') : $request->get('order_type');
        if ($order_type === 0 || $order_type === '0') $order_type = 'asc';

        $number = (int)$request->get('number');

        $array = $model->orderBy($order_name, $order_type);

        if (!empty($where)) {

            $array = $array->where($where);

        }

        if (!empty($whereIn)) {

            foreach ($whereIn as $k => $v) {

                $array = $array->whereIn($v['name'], $v['value']);

            }
        }

        return $array->paginate(empty($number) ? 20 : $number);
    }

    /**
     * 反馈列表信息
     *
     * @param $model
     * @param $where
     * @param $whereIn
     * @param $orderBy
     * @return string
     */
    protected function return_list($model, $where = [], $whereIn = [], $orderBy = [])
    {
        //获取列表信息(含翻页等信息)
        $array = self::index_list($model, $where, $whereIn, $orderBy);

        //去前缀
        $list = self::return_list_array($array);

        //反馈给前台
        return self::success_html($list);
    }

    /**
     * 返回管理员模型
     *
     * @return mixed
     */
    protected function return_master()
    {
        return request()->user('api');
    }

    protected function get_user()
    {
        return request()->user('api');
    }
}
