<?php
/**
 * Created by PhpStorm.
 * User: yangyang
 * Date: 2018/8/25
 * Time: 上午11:36
 */

namespace App\Vendor\Excel;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class ExcelClass extends Controller
{
    private $name;

    private $dir = 'exports';

    private function export($cellData = [], $name = 'excel', $title = 'score')
    {
        $this->name = $name . time();

        //获取excel对象
        return Excel::create($this->name, function ($excel) use ($cellData, $title) {
            $excel->sheet($title, function ($sheet) use ($cellData) {
                $sheet->rows($cellData);
            });
        });
    }

    /**
     * 下载方法
     *
     * @param array $cellData
     * @param string $name
     * @param string $title
     * @param string $type
     */
    public function download($cellData = [], $name = '', $title = '', $type = 'xls')
    {
        self::export($cellData, $name, $title)->export($type);
    }

    /**
     * 添加到服务器默认文件夹
     *
     * @param array $cellData
     * @param string $name
     * @param string $title
     * @param string $type
     * @return string
     */
    public function store($cellData = [], $name = '', $title = '', $type = 'xls')
    {
        self::delete_old_excel();

        self::export($cellData, $name, $title)->store($type, $this->dir);

        return env('EXCEL_LOCATION') . '/' . $this->dir . '/' . $this->name . '.' . $type;
    }

    /**
     * 添加到服务器默认文件夹,并返回详细信息(json)
     *
     * @param array $cellData
     * @param string $name
     * @param string $title
     * @param string $type
     * @return mixed
     */
    public function storeAndReturn($cellData = [], $name = '', $title = '', $type = 'xls')
    {
        self::delete_old_excel();

        return self::export($cellData, $name, $title)->store($type, false, true);
    }

    private function delete_old_excel($keep_time = '60')
    {
        //获取所有excel文件信息
        $excels = self::select_old_excel();

        //判断现有excel文件数量
        if (count($excels['location']) <= 0) return true;

        //计算删除时间线
        $delete_time = time() - (60 * $keep_time);

        //循环数组,删除文件
        foreach ($excels['location'] as $k => $v) {

            //判断文件时候出于删除时间线内
            if ($excels['time_string'][$k] < $delete_time) {

                //文件达到删除时间线,删除文件
                self::un_link($v);
            }
        }
    }

    private function select_old_excel()
    {
        return self::read_dir($this->dir . '/');
    }

    /**
     * 遍历目录
     * 获取dir所有目录
     * 获取name所有文件路径
     * 获取ctime文件的创建时间
     *
     * @param string $dir
     * @return array
     */
    private function read_dir($dir = '')
    {
        if (!is_dir($dir)) return false;

        $file = scandir($dir);

        $location = array(
            'location' => array(),
            'dir' => array(),
            'ctime' => array(),
            'time_string' => array(),
        );

        if (count($file) > 2) foreach ($file as $k => $v) {
            $loc = $dir . $v;
            if ($v == '.' || $v == '..') continue;
            else if (is_dir($loc)) {

                $loca = self::read_dir($loc . '/');

                $location['dir'][] = $loc;
                if (!empty($loca['dir'])) $location['dir'] = array_merge($loca['dir'], $location['dir']);;
                if (!empty($loca['location'])) $location['location'] = array_merge($loca['location'], $location['location']);
                if (!empty($loca['ctime'])) $location['ctime'] = array_merge($loca['ctime'], $location['ctime']);
                if (!empty($loca['time_string'])) $location['time_string'] = array_merge($loca['time_string'], $location['time_string']);
            } else {
                $location['location'][] = '/' . $loc;
                $ctime = filectime($loc);
                $location['ctime'][] = "创建时间：" . date("Y年m月d日 H点i分", $ctime);
                $location['time_string'][] = $ctime;
            }

        }

        return $location;
    }

    //导入excel
    public function file($file_column, $file_name = null)
    {
        if (is_null($file_column)) self::error(['请传入导入字段']);

        $file = request()->file($file_column);

        //验证传入文件
        if (is_null($file)) self::error(['请传入excel文件']);

        //拆分文件后缀
        list($name, $postfix) = explode('.', $file->getClientOriginalName());

        //判断后缀是否合法
        if (!in_array($postfix, ['xls', 'xlsx'])) self::error(['文件格式错误（xls或xlsx）']);

        //选取保存的文件名
        $name = is_null($file_name) ? $name : $file_name;

        //组合文件名与后缀
        $name = $name . '.' . $postfix;

        //文件另存为
        $url = $file->storeAs('public/exports', $name);

        //去掉路径前的/
        $filePath = substr(Storage::url($url), 1);

        //读取文件内容
        $a = Excel::load($filePath)->all()->toArray();

        //判断文件内容
        if (count($a) <= 0) self::error(['未接受到数据']);

        //返回文件内容
        return $a;
    }

    private function un_link($link)
    {
        unlink(substr($link, 1));
    }

    private function error(array $error)
    {
        throw new ExcelException($error);
    }
}