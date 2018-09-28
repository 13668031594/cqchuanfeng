<?php

namespace App\Http\Controllers\Tietong;

use App\Models\Tietong\TietongArea;
use App\Models\Tietong\TietongMan;
use App\Vendor\Excel\ExcelClass;
use App\Vendor\Excel\ExcelException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TietongManFileController extends TietongController
{
    //------导出功能---------------------------------------------------------------------------------------//

    public function down()
    {
        //验证导出间隔
        self::test_down_time();

        //获取所有数据
        $man = TietongMan::all();

        if (count($man) <= 0) throw new ExcelException('没有员工资料');

        //获取导出标题
        $title = self::down_list_title();

        //组合数据
        $array = self::down_load_array($title, $man->toArray());

        //初始化excel类
        $class = new ExcelClass();

        //生成并下载
        $class->download($array, '员工信息' . date('Y-m-d H:i:s'));
    }

    //验证下载时间
    public function test_down_time($time = 60)
    {
        $result = 0;

        $name = $_SERVER["REMOTE_ADDR"] . 'family';

        //获取上一次下载文件时间戳
        $session_time = cache($name, null);

        //获取成功
        if (!is_null($session_time)) {

            //获取当前时间戳
            $test_time = time();

            //比较上次下载间隔时间
            $diff_time = $test_time - $session_time;

            //间隔时间小于60S
            if ($diff_time < $time) {

                //返回上一层,提示间隔时间到达后再试
                $result = $time - $diff_time;
            }

            return $result;
        }

        //上传本次下载文件时间戳
        cache([$name => time()], 1);

        if ($result > 0) throw new ExcelException('请等待' . $result . '秒后重试');
    }

    //下载列表标题
    public function down_list_title()
    {
        return [
            'young_area_name' => '分中心',
            'young_hall_name' => '网格',
            'young_company_name' => '所属公司',
            'young_order' => '编号',
            'young_orgcode' => 'orgcode',
            'young_name' => '员工名称',
            'young_nation_name' => '民族',
            'young_school_record' => '学历',
            'young_join_time' => '入职时间',
            'young_id_card' => '身份证',
            'young_birthday' => '生日',
            'young_age' => '年龄',
            'young_bank_number' => '银行卡号',
            'young_bank_name' => '开户行',
            'young_bank_address' => '开户网点',
            'young_file_number' => '档案号',
            'young_hukou_address' => '户口所在地',
            'young_address' => '地址',
            'young_school_name' => '学校',
            'young_sos_man' => '紧急联系人',
            'young_sos_phone' => '紧急联系电话',
            'young_contract_begin_time' => '合同开始时间',
            'young_contract_end_time' => '合同结束时间',
            'young_team_safe_total' => '团意险',
            'young_team_safe_end_time' => '团意险结束时间',
            'young_height' => '身高',
            'young_weight' => '体重',
            'young_t_shirt' => 'T恤',
            'young_work_clothes' => '工装',
            'young_shoe_size' => '鞋码',
            'young_sex' => '性别',
            'young_marry' => '婚姻状态',
            'young_communist' => '党员',
            'young_contract' => '合同类型',
            'young_job' => '工种',
            'young_hukou_type' => '户口类型',
            'young_note' => '备注',
            'created_at' => '创建时间',
        ];
    }

    //组合数据
    public function down_load_array($title, $list)
    {
        //初始化数组
        $array[] = array_values($title);

        //键
        $keys = array_keys($title);

        //对比数组类
        $arrays = self::arrays();
        $sex = $arrays['sex'];
        $marry = $arrays['marry'];
        $communist = $arrays['communist'];
        $contract = $arrays['contract'];
        $job = $arrays['job'];
        $hukou_type = $arrays['hukou_type'];


        //循环提取数据
        foreach ($list as $k => $v) {

            //初始化一个容器数组
            $a = [];

            //循环键，进行组合
            foreach ($keys as $ke => $va) {

                switch ($va) {
                    case 'young_sex':
                        $a[$ke] = $sex[$v[$va]];
                        break;
                    case 'young_marry':
                        $a[$ke] = $marry[$v[$va]];
                        break;
                    case 'young_communist':
                        $a[$ke] = $communist[$v[$va]];
                        break;
                    case 'young_contract':
                        $a[$ke] = $contract[$v[$va]];
                        break;
                    case 'young_job':
                        $a[$ke] = $job[$v[$va]];
                        break;
                    case 'young_hukou_type':
                        $a[$ke] = $hukou_type[$v[$va]];
                        break;
                    default:
                        $a[$ke] = $v[$va];
                        break;
                }
            }

            //放入结果数组
            $array[] = $a;
        }

//        dd($array);
        return $array;
    }

    //------导入功能---------------------------------------------------------------------------------------//

    //导入页面
    public function file_view()
    {
        return parent::return_view('ManFiles');
    }

    //导入入口
    public function file()
    {
        $class = new ExcelClass();

        $data = $class->file('excel', 'man_file');

        $array = self::data_test($data[0]);//测试字段

        $group = array_chunk($array, 100);

        foreach ($group as $v)
            TietongMan::insert($v);

        dd('导入成功');
    }

    //测试数据并组合
    private function data_test($data)
    {
        $array = [];

        $area = self::area();

        $date = date('Y-m-d H:i:s');

        foreach ($data as $k => $v) {

            $result = self::data_test_column($v);

            if ($result !== true) {

                dd('第' . ($k + 1) . '条记录', $result);
            }

            foreach ($v as $ke => $va) {

                $array[$k]['young_' . $ke] = $va;

                if ($ke == 'area_name' && isset($area[$va])) $array[$k]['young_area_id'] = $area[$va];
                if ($ke == 'birthday' && !is_null($va)) $array[$k]['young_age'] = self::age($va);
            }

            $array[$k]['created_at'] = $date;
            $array[$k]['updated_at'] = $date;
        }

        return $array;
    }

    //测试数据方法
    private function data_test_column($array)
    {
        $term = [
            'order' => 'nullable|string|max:20',
            'orgcode' => 'nullable|string|max:20',
            'area_name' => 'nullable|exists:tietong_areas,young_name',
            'hall_name' => 'nullable|string|max:20',
            'company_name' => 'nullable|string|max:20',
            'name' => 'nullable|string|max:20',
            'phone' => 'nullable|string|max:20',
            'sex' => 'required',
            'nation_name' => 'nullable|string|max:20',
            'marry' => 'required',
            'communist' => 'required',
            'school_record' => 'nullable|string|max:20',
            'join_time' => 'nullable|date',
            'id_card' => 'nullable|string|max:20',
            'birthday' => 'nullable|date',
            'contract' => 'required',
            'job' => 'required',
            'hukou_type' => 'required',
            'bank_number' => 'nullable|string|max:20',
            'bank_name' => 'nullable|string|max:20',
            'bank_address' => 'nullable|string|max:60',
            'file_number' => 'nullable|string|max:20',
            'hukou_address' => 'nullable|string|max:60',
            'address' => 'nullable|string|max:60',
            'school_name' => 'nullable|string|max:20',
            'school_major' => 'nullable|string|max:20',
            'sos_man' => 'nullable|string|max:20',
            'sos_phone' => 'nullable|string|max:20',
            'safe_base' => 'nullable|numeric|between:0,100000000',
            'note' => 'nullable|string|max:60',
            'contract_begin_time' => 'nullable|date',
            'contract_end_time' => 'nullable|date',
            'team_safe_total' => 'nullable|numeric|between:0,100000000',
            'team_safe_end_time' => 'nullable|date',
            'height' => 'nullable|integer|between:0,1000',
            'weight' => 'nullable|integer|between:0,1000',
            't_shirt' => 'nullable|integer|between:0,1000',
            'work_clothes' => 'nullable|integer|between:0,1000',
            'sho_size' => 'nullable|integer|between:0,1000',
        ];

        $errors = [
            'order.max' => '编号至多20个字符',
            'orgcode.max' => 'orgcode至多20个字符',
            'area_name.exists' => '分公司不存在',
            'hall_name.max' => '网格名至多20个字符',
            'company_name.max' => '公司名至多20个字符',
            'name.max' => '员工名称至多20个字符',
            'phone.max' => '员工电话至多20个字符',
            'nation_name.max' => '民族至多20个字符',
            'school_record.max' => '学历至多20个字符',
            'id_card.max' => '身份证号至多20个字符',
            'bank_number.max' => '银行卡号至多20个字符',
            'bank_name.max' => '开户行至多20个字符',
            'bank_address.max' => '开户网点至多60个字符',
            'file_number.max' => '档案号至多20个字符',
            'hukou_address.max' => '户口所在地至多60个字符',
            'address.max' => '地址至多60个字符',
            'school_name.max' => '毕业学校至多20个字符',
            'school_major.max' => '专业至多20个字符',
            'sos_man.max' => '紧急联系人至多20个字符',
            'sos_phone.max' => '紧急联系电话至多20个字符',
            'safe_base.numeric' => '社保基数请输入数字',
            'safe_base.between' => '社保基数应介于0-1亿',
            'note.max' => '备注至多60个字符',
            'team_safe_total.numeric' => '团意险请输入数字',
            'team_safe_total.between' => '团意险应介于0-1亿',
            'height.integer' => '身份高请输入整数',
            'height.between' => '身高应介于0-1000cm',
            'weight.integer' => '体重应输入整数',
            'weight.between' => '体重应介于0-1000kg',
            't_shirt.integer' => 'T恤应输入整数',
            't_shirt.between' => 'T恤应介于0-1000',
            'work_clothes.integer' => '工装请输入整数',
            'work_clothes.between' => '工装应介于0-1000',
            'sho_size.integer' => '鞋码请输入整数',
            'sho_size.between' => '鞋码应介于0-1000',
        ];

        $validator = parent::return_validator($array, $term, $errors);

        //判断表单验证是否通过
        if ($validator['status'] === 'fails') {

            //反馈错误信息给前台
            return $validator['test'];
        }

        $arrays = self::arrays();

        if (!in_array($array['sex'], array_keys($arrays['sex']))) return '性别错误';
        if (!in_array($array['marry'], array_keys($arrays['marry']))) return '婚配错误';
        if (!in_array($array['communist'], array_keys($arrays['communist']))) return '党员状态错误';
        if (!in_array($array['contract'], array_keys($arrays['contract']))) return '合同类型错误';
        if (!in_array($array['job'], array_keys($arrays['job']))) return '工种错误';
        if (!in_array($array['hukou_type'], array_keys($arrays['hukou_type']))) return '户口状态错误';

        return true;
    }

    //对比数组
    private function arrays()
    {
        $class = new TietongManController();

        return $class->arrays();
    }

    //分钟寺
    private function area()
    {
        $areas = [];

        $area = TietongArea::all();

        foreach ($area as $v) {

            $areas[$v->young_name] = $v->id;
        }

        return $areas;
    }

    //计算年龄
    private function age($birthday)
    {
        $age = 0;

        if (!is_null($birthday)) {

            $age = strtotime($birthday);
            list($y1, $m1, $d1) = explode("-", date("Y-m-d", $age));
            $now = strtotime("now");
            list($y2, $m2, $d2) = explode("-", date("Y-m-d", $now));
            $age = $y2 - $y1;
            if ((int)($m2 . $d2) < (int)($m1 . $d1)) {

                $age -= 1;
            }
        }

        return $age;
    }
}
