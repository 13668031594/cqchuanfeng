<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\AdminController;
use Illuminate\Support\Facades\Input;

class MySqlSelectGroup extends AdminController
{
    public function select_group($model, $ajax=null,$asd = [])
    {
        //获取筛选条件数组
        $arrays = Input::get('theSelectGroups');

        $ajax = is_null($ajax) ? 1 : $ajax;

        //用翻页信息确定是否实在翻页
        $is_page = Input::get('is_page');

        //获取模型数组
        $self_arrays = self::group_arrays();

        //若获取失败,直接返回模型
        if (is_null($arrays)) return self::returns($model, $self_arrays);

        if ($ajax || !is_null(Input::get('ajax'))) {

            if (!is_array($arrays))$arrays = parent::compile_json($arrays);

        }

        //循环条件数组,根据筛选类型进行sql语句组合
        foreach ($arrays as $k => $v) {

            //条件数组为空,跳转至下一条
            if (empty($v)) continue;

            //判断条件数组类型,并进行相应sql语句组合工作
            switch ($k) {
                case 'between':
                    $self_arrays['between'] = $v;
                    $model = self::group_between($model, $v);
                    break;
                case 'select_vague':
                    if (!empty($asd) || $is_page) {
                        $self_arrays['select_vague'] = $v;
                        $model = self::group_select_vague($model, $v);
                    } else {

                        $between = self::not_ajax_select_vague_groups($v);
                        $self_arrays['select_vague'] = $between;
                        $model = self::group_select_vague($model, $between);
                    }
                    break;
                case 'select_exact':
                    if (!empty($asd) || $is_page) {
                        $self_arrays['select_exact'] = $v;
                        $model = self::group_select_exact($model, $v);
                    } else {
                        $between = self::not_ajax_select_exact_groups($v);
                        $self_arrays['select_exact'] = $between;
                        $model = self::group_select_exact($model, $between);
                    }
                    break;
                case 'filter':
                    $self_arrays['filter'] = $v;
                    $model = self::group_filter($model, $v);
                    break;
                case 'orderBy':
                    $self_arrays['orderBy'] = $v;
                    $model = self::group_orderBy($model, $v);
                    break;
                default:
                    break;
            }
        }

        //返回最终模型及筛选条件数组
        return self::returns($model, $self_arrays);
    }

    /**
     * 反馈数组方法
     *
     * @param $model
     * @param $where
     * @return array
     */
    private function returns($model, $where)
    {
        return [
            'model' => $model,
            'where' => $where,
        ];
    }

    /**
     * 格式数组,无刷新模式
     *
     * @return array
     */
    private function group_arrays()
    {
        return [
            //区间查询
            'between' => [

                /*'time' => [//搜索字段为key
                    'begin' => '1991.03.15',//起始条件
                    'end' => '2017.10.19',//结束条件
                ],*/
            ],

            //模糊查询
            'select_vague' => [

                /*'nickname' => 'yang',//搜索字段为key,条件为value
                'phone' => '136',*/
            ],

            //精确查询
            'select_exact' => [

                /*
                'nickname' => 'yangyang',//搜索字段为key,条件为value
                'phone' => '13668031594',//搜索字段为key,条件为value
                */
            ],

            //筛选
            'filter' => [

                /**
                 * 多条件筛选
                 */
                /*'state' => [
                    'dealer',
                    'member',
                ],
                'status' => [
                    '0',
                    '1',
                ],*/
            ],

            //排序
            'orderBy' => [

                /*'id' => 'desc',
                'created_at' => 'desc',
                'updated_at' => 'asc',*/
            ],

        ];
    }

    /**
     * 嵌套方式中,模糊查询格式重组
     *
     * @param $select_vague
     * @return array
     */
    private function not_ajax_select_vague_groups($select_vague)
    {
        $arrays = [];

        if (is_array($select_vague)) {

            foreach ($select_vague as $v) {

                if (!is_array($v)) continue;

                $keys = array_keys($v);

                if (in_array('key', $keys)
                    && in_array('value', $keys)
                    && is_string($v['key'])
                    && is_string($v['value'])) {

                    $arrays[$v['key']] = $v['value'];
                }
            }
        }

        return $arrays;
    }

    /**
     * 嵌套方式中,模糊查询格式重组
     *
     * @param $select_vague
     * @return array
     */
    private function not_ajax_select_exact_groups($select_vague)
    {
        $arrays = [];

        if (is_array($select_vague)) {

            foreach ($select_vague as $v) {

                if (!is_array($v)) continue;

                $keys = array_keys($v);

                if (in_array('key', $keys)
                    && in_array('value', $keys)
                    && is_string($v['key'])
                    && is_string($v['value'])) {

                    $arrays[$v['key']] = $v['value'];
                }
            }
        }

        return $arrays;
    }

    /**
     * 区间筛选sql组合
     *
     * @param $model
     * @param $where
     * @return mixed
     */
    private function group_between($model, $where)
    {
        //若条件格式为数组,开始sql组合循环
        if (is_array($where)) {

            //循环条件数组,进行sql组合
            foreach ($where as $k => $v) {

                //若条件数组中数据为空,进行下一个循环
                if (!is_array($v) || empty($v)) continue;

                //获取条件数组key
                $v_keys = array_keys($v);


                //若存在起始条件且为字符串,组合sql
                if (in_array('begin', $v_keys) && is_string($v['begin'])) {

                    $model = $model->where(self::add_prefix($k), '>=', $v['begin']);
                }

                //若存在终止条件且为字符串,组合sql
                if (in_array('end', $v_keys) && is_string($v['end'])) {

                    $model = $model->where(self::add_prefix($k), '<=', $v['end']);
                }
            }
        }

        //返回新的模型
        return $model;
    }

    /**
     * 模糊查询sql组合
     *
     * @param $model
     * @param $where
     * @return mixed
     */
    private function group_select_vague($model, $where)
    {
        //判断条件数组格式
        if (is_array($where)) {

            //开始sql组合循环
            foreach ($where as $k => $v) {

                //若是空的键值对或非字符串,进行下一次循环
                if (is_null($v) || !is_string($v)) continue;

                //组合模糊查询sql
                $model = $model->where(self::add_prefix($k), 'like', '%' . $v . '%');
            }
        }

        return $model;
    }

    /**
     * 精确查询sql组合
     *
     * @param $model
     * @param $where
     * @return mixed
     */
    private function group_select_exact($model, $where)
    {
        //判断条件数组格式
        if (is_array($where)) {

            //开始sql组合循环
            foreach ($where as $k => $v) {

                //若是空的键值对或非字符串,进行下一次循环
                if (is_null($v) || !is_string($v)) continue;

                //组合模糊查询sql
                $model = $model->where(self::add_prefix($k), '=', $v);
            }
        }

        return $model;
    }

    /**
     * 筛选(包含多条件)sql组合
     *
     * @param $model
     * @param $where
     * @return mixed
     */
    private function group_filter($model, $where)
    {
        //判断条件数组格式
        if (is_array($where)) {

            //开始sql组合循环
            foreach ($where as $k => $v) {

                //若是非数组,进行下一次循环
                if (!is_array($v)) continue;


                if (count($v) == 1) {

                    //单条件筛选
                    $model = $model->where(self::add_prefix($k), '=', $v);
                } elseif (count($v) > 1) {

                    //多条件筛选
                    $model = $model->whereIn(self::add_prefix($k), $v);
                }

            }
        }

        return $model;
    }

    /**
     * 排序sql组合
     *
     * @param $model
     * @param $where
     * @return mixed
     */
    private function group_orderBy($model, $where)
    {
        //判断条件数组格式
        if (is_array($where)) {

            //开始sql组合循环
            foreach ($where as $k => $v) {

                //若是非字符串,进行下一次循环
                if (!is_string($v)) continue;

                //根据排序条件组合sql
                switch ($v) {
                    case 'ascending':
                        $model = $model->orderBy(self::add_prefix($k), 'asc');
                        break;
                    case 'descending':
                        $model = $model->orderBy(self::add_prefix($k), 'desc');
                        break;
                    default:
                        break;
                }
            }
        }

        return $model;
    }

    private function add_prefix($k)
    {
        $exception = parent::delete_prefix_exception();

        $keys = explode('_', $k);

        return (in_array($k, $exception) || in_array('id', $keys) || in_array('list', $keys)) ? $k : 'young_' . $k;
    }
}
