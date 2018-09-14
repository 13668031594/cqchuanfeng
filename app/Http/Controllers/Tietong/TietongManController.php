<?php

namespace App\Http\Controllers\Tietong;

use App\Models\Tietong\TietongArea;
use App\Models\Tietong\TietongCompany;
use App\Models\Tietong\TietongMan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TietongManController extends TietongController implements ListInterface
{
    private $model;

    public function __construct()
    {
        $this->model = new TietongMan();
    }

    public function index()
    {
        $user = parent::get_user();

        $result = parent::return_list($this->model);

        $result['user'] = $user;

        $result = array_merge($result, self::arrays());
//        dd($result);

        return parent::return_view('manList', $result);
    }

    public function show($id)
    {
        $self = $this->model->find($id);

        if (is_null($self)) dd('error');

        $array = self::arrays();

        $array['self'] = $self;

        return parent::return_view('manInfo', $array);
    }

    public function create()
    {
        $array = self::arrays();

        $array['area'] = self::areas();

        return parent::return_view('manAdd', $array);
    }

    public function store(Request $request)
    {
        $user = parent::get_user();

        if ($user['young_power'] != '20') return parent::return_ajax(false, ['没有权限']);

        $test = self::test($request);

        if ($test !== true) return $test;

        self::save_man($this->model, $request);

        return parent::return_ajax(true, ['操作成功']);
    }

    public function edit($id)
    {
        $self = $this->model->find($id);

        if (is_null($self)) dd('error');

        $array = self::arrays();

        $array['area'] = self::areas();
        $array['self'] = $self;

        return parent::return_view('manEdit', $array);
    }

    public function update($id, Request $request)
    {
        $user = parent::get_user();

        if ($user['young_power'] != '20') return parent::return_ajax(false, ['没有权限']);

        $test = self::test($request);

        if ($test !== true) return $test;

        $model = $this->model->find($id);

        if (is_null($model)) dd('error');

        self::save_man($model, $request);

        return parent::return_ajax(true, ['操作成功']);
    }

    public function destroy($id)
    {
        $ids = explode(',', $id);

        $this->model->destroy($ids);

        return parent::return_ajax(true, ['操作成功']);
    }

    private function arrays()
    {
        return [
            'sex' => [
                10 => '未知',
                20 => '男',
                30 => '女',
            ],
            'marry' => [
                10 => '未知',
                20 => '已婚',
                30 => '未婚',
            ],
            //党员
            'communist' => [
                10 => '未知',
                20 => '是',
                30 => '否',
            ],
            //合同类型
            'contract' => [
                10 => '未知',
                20 => '固定期限',
            ],
            //工种
            'job' => [
                10 => '未知',
                20 => '线务员',
                30 => '市场',
                40 => '后台',
            ],
            //户口类型
            'hukou_type' => [
                10 => '未知',
                20 => '农村',
                30 => '城镇',
            ],

        ];
    }

    private function areas()
    {
        $area = TietongArea::orderBy('young_sort', 'asc')->get();

        $areas = parent::delete_prefix_more($area->toArray(), 'id');

        return $areas;
    }

    private function test(Request $request)
    {
        $term = [
            'order' => 'nullable|string|max:20',
            'orgcode' => 'nullable|string|max:20',
            'area_id' => 'nullable|exists:tietong_areas,id',
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
            'area.exists' => '分公司不存在',
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

        $validator = parent::return_validator($request->all(), $term, $errors);

        //判断表单验证是否通过
        if ($validator['status'] === 'fails') {

            //反馈错误信息给前台
            return parent::return_ajax_array($validator);
        }

        $arrays = self::arrays();

        if (!in_array($request->sex, array_keys($arrays['sex']))) return parent::return_ajax(false, ['sex_errors']);
        if (!in_array($request->marry, array_keys($arrays['marry']))) return parent::return_ajax(false, ['marry_errors']);
        if (!in_array($request->communist, array_keys($arrays['communist']))) return parent::return_ajax(false, ['communist_errors']);
        if (!in_array($request->contract, array_keys($arrays['contract']))) return parent::return_ajax(false, ['contract_errors']);
        if (!in_array($request->job, array_keys($arrays['job']))) return parent::return_ajax(false, ['job_errors']);
        if (!in_array($request->hukou_type, array_keys($arrays['hukou_type']))) return parent::return_ajax(false, ['hukou_type_errors']);

        return true;
    }

    private function save_man($model, Request $request)
    {
        $model->young_order = $request->order;
        $model->young_orgcode = $request->orgcode;
        $model->young_hall_name = $request->hall_name;
        $model->young_company_name = $request->company_name;
        $model->young_name = $request->name;
        $model->young_phone = $request->phone;
        $model->young_sex = $request->sex;
        $model->young_nation_name = $request->nation_name;
        $model->young_marry = $request->marry;
        $model->young_communist = $request->communist;
        $model->young_school_record = $request->school_record;
        $model->young_join_time = $request->join_time;
        $model->young_id_card = $request->id_card;
        $model->young_birthday = $request->birthday;
        $model->young_contract = $request->contract;
        $model->young_job = $request->job;
        $model->young_hukou_type = $request->hukou_type;
        $model->young_bank_number = $request->bank_number;
        $model->young_bank_name = $request->bank_name;
        $model->young_bank_address = $request->bank_address;
        $model->young_hukou_address = $request->hukou_address;
        $model->young_file_number = $request->file_number;
        $model->young_address = $request->address;
        $model->young_school_name = $request->school_name;
        $model->young_school_major = $request->school_major;
        $model->young_sos_man = $request->sos_man;
        $model->young_sos_phone = $request->sos_phone;
        $model->young_safe_base = $request->safe_base;
        $model->young_note = $request->note;
        $model->young_contract_begin_time = $request->contract_begin_time;
        $model->young_contract_end_time = $request->contract_end_time;
        $model->young_team_safe_total = $request->team_safe_total;
        $model->young_team_safe_end_time = $request->team_safe_end_time;
        $model->young_height = $request->height;
        $model->young_weight = $request->weight;
        $model->young_t_shirt = $request->t_shirt;
        $model->young_work_clothes = $request->work_clothes;
        $model->young_shoe_size = $request->shoe_size;

        $model = self::area($model, $request);
        $model = self::age($model);
        $model->save();
    }

    private function area($model, Request $request)
    {
        $area_id = $request->area_id;

        if (!is_null($area_id)) {

            $area = TietongArea::find($area_id);
            $model->young_area_id = $area->id;
            $model->young_area_name = $area->young_name;
        }

        return $model;
    }

    private function age($model)
    {
        if (!is_null($model->young_birthday)) {

            $age = strtotime($model->young_birthday);
            list($y1, $m1, $d1) = explode("-", date("Y-m-d", $age));
            $now = strtotime("now");
            list($y2, $m2, $d2) = explode("-", date("Y-m-d", $now));
            $age = $y2 - $y1;
            if ((int)($m2 . $d2) < (int)($m1 . $d1)) {

                $age -= 1;
            }

            $model->young_age = $age;
        }

        return $model;
    }


}
