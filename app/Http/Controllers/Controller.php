<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\MySqlSelectGroup;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * 传入任意内容,传回json字符串
     *
     * @param $result
     * @return string
     */
    protected function to_json($result)
    {
        return json_encode($result);
    }

    /**
     * 传入json字符串,传回反编译后内容
     *
     * @param $result
     * @param $assoc
     * @return mixed
     */
    protected function compile_json($result,$assoc = true)
    {
        return json_decode($result, $assoc);
    }

    /**
     * 返回数组内容
     *
     * @param $status
     * @param $result
     * @return array
     */
    protected function return_array($status, $result = [])
    {
        return [
            'status' => $status,
            'test' => $result,
        ];
    }

    /**
     * 表单验证方法
     *
     * @param array $request
     * @param array $term
     * @param array $errors
     * @return array
     */
    protected function return_validator($request = [], $term = [], $errors = [])
    {
        //进行表单验证
        $validator = Validator::make($request, $term, $errors);

        //判断是否有错误提示
        if ($validator->fails()) {

            //有错误提示

            //账号或密码错误,反馈错误信息
            return self::return_array('fails', $validator->errors()->all());
        } else {

            //无错误提示

            //反馈正确串码
            return self::return_array('success', ['验证通过']);
        }
    }

    /**
     * 返回时间字符串
     *
     * @param null $time
     * @param string $style
     * @return false|string
     */
    protected function return_date($time = null, $style = 'Y-m-d H:i:s')
    {
        if (is_null($time)) {

            $date = date($style);
        } else {

            $date = date($style, $time);
        }

        return $date;
    }

    /**
     * 返回时间戳
     *
     * @param null $date
     * @return false|int
     */
    protected function return_time($date = null)
    {
        if (is_null($date)) {

            $time = time();
        } else {

            $time = strtotime($date);
        }

        return $time;
    }

    /**
     * 同时更新多个记录，参数，表名，数组（别忘了在一开始use DB;）
     */
    public function updateBatch($tableName = "", $multipleData = array())
    {
        if ($tableName && !empty($multipleData)) {

            $tableName = 'young_' . $tableName;

            // column or fields to update
            $updateColumn = array_keys($multipleData[0]);
            $referenceColumn = $updateColumn[0]; //e.g id
            unset($updateColumn[0]);
            $whereIn = "";

            $q = "UPDATE " . $tableName . " SET ";
            foreach ($updateColumn as $uColumn) {
                $q .= $uColumn . " = CASE ";

                foreach ($multipleData as $data) {
                    $q .= "WHEN " . $referenceColumn . " = " . $data[$referenceColumn] . " THEN '" . $data[$uColumn] . "' ";
                }
                $q .= "ELSE " . $uColumn . " END, ";
            }
            foreach ($multipleData as $data) {
                $whereIn .= "'" . $data[$referenceColumn] . "', ";
            }
            $q = rtrim($q, ", ") . " WHERE " . $referenceColumn . " IN (" . rtrim($whereIn, ', ') . ")";

            // Update
            return DB::update(DB::raw($q));

        } else {
            return false;
        }
    }

    /**
     * 保留前3位后2位的账号字符串加密
     *
     * @param $account_number
     * @return string
     */
    public function string_encrypt($account_number)
    {
        if (empty($account_number)) return '';

        $first = substr($account_number, 0, 3);
        $last = substr($account_number, -2, 2);

        return $first . '****' . $last;
    }

    /**
     * 批量去除数组前缀
     *
     * @param array $array
     * @return array
     */
    protected function delete_prefix_more($array = [], $type = null)
    {
        $arrays = [];

        if (count($array) > 0) {

            foreach ($array as $k => $v) {

                $key = is_null($type) ? $k : $v[$type];

                $arrays[$key] = self::delete_prefix_one($v);
            }
        }

        return $arrays;
    }

    /**
     * 循环去除数组每个键前缀
     *
     * @param array $array
     * @return array
     */
    protected function delete_prefix_one($array = [])
    {
        $arrays = [];

        $exception = self::delete_prefix_exception();

        foreach ($array as $k => $v) {

            if (in_array($k, $exception)) {

                $arrays[$k] = $v;
            } elseif (substr($k, 0, 6) === 'young_') {

                $arrays[substr($k, 6)] = $v;
            } else {

                $arrays[$k] = $v;
            }

        }

        return $arrays;
    }

    /**
     * 不计入前缀消除的字段
     *
     * @return array
     */
    protected function delete_prefix_exception()
    {
        return [
            'id', 'password', 'created_at', 'updated_at', 'deleted_at', 'remember_token','package_new_order_number'
        ];
    }

    /**
     * 返回四舍五入后的两位小数
     *
     * @param $number
     * @param $num
     * @return float|int
     */
    protected function return_round($number, $num = 2)
    {
        //若不是数值,直接返回0
        if (!is_numeric($number)) return 0;

        //返回四舍五入到量为小数
        return round($number, $num);
    }

    protected function return_floor($number, $num = 100)
    {
        //若不是数值,直接返回0
        if (!is_numeric($number)) return 0;

        //舍去小数点
        return floor(($number * $num)) / $num;
    }

    /**
     * 保留前3位后2位的账号字符串加密
     *
     * @param $account_number
     * @return string
     */
    public function account_number_encrypt($account_number)
    {
        if (empty($account_number)) return '';

        $first = substr($account_number, 0, 3);
        $last = substr($account_number, -2, 2);

        return $first . '****' . $last;
    }
}
