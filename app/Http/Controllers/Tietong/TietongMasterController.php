<?php

namespace App\Http\Controllers\Tietong;

use App\Models\Tietong\TietongMaster;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class TietongMasterController extends TietongController implements ListInterface
{
    private $model;

    public function __construct()
    {
        $this->model = new TietongMaster();
    }

    public function index()
    {
        $user = parent::get_user();

        if ($user['young_account_number'] != 'admins') return parent::return_ajax(false, ['没有权限']);

        $result = parent::return_list($this->model);

        $result['power'] = self::power();

        return parent::return_view('masterList', $result);
    }

    public function show($id)
    {
        // TODO: Implement show() method.
    }

    public function create()
    {
        return parent::return_view('masterAdd');
    }

    public function store(Request $request)
    {
        $user = parent::get_user();

        if ($user['young_account_number'] != 'admins') return parent::return_ajax(false, ['没有权限']);

        $term = [
            'nickname' => 'required|string|max:10',
            'account_number' => 'required|string|unique:tietong_masters,young_account_number|between:6,20',
            'password' => 'required|string|between:6,12',
            'power' => 'required',
        ];

        $errors = [
            'nickname.required' => '请输入昵称',
            'nickname.max' => '昵称至多10个字符',
            'account_number.required' => '请输入账号',
            'account_number.unique' => '账号被占用',
            'account_number.between' => '账号应6-20个字符',
            'password.required' => '请输入密码',
            'password.between' => '密码应6-12个字符'
        ];

        $validator = parent::return_validator($request->all(), $term, $errors);

        //判断表单验证是否通过
        if ($validator['status'] === 'fails') {

            //反馈错误信息给前台
            return parent::return_ajax_array($validator);
        }

        if (!in_array($request->power,array_keys(self::power())))return parent::return_ajax(false, ['状态错误']);

        $master = $this->model;
        $master->young_nickname = $request->nickname;
        $master->young_account_number = $request->account_number;
        $master->password = Hash::make($request->password);
        $master->young_power = $request->power;
        $master->save();

        return parent::return_ajax(true, ['操作成功']);
    }

    public function edit($id)
    {
        $result = $this->model->find($id);
        if (is_null($result)) dd('错误edit');

        return parent::return_view('masterEdit', ['self' => $result]);
    }

    public function update($id, Request $request)
    {
        $user = parent::get_user();

        if ($user['young_account_number'] != 'admins') return parent::return_ajax(false, ['没有权限']);

        $term = [
            'id' => 'required|exists:tietong_masters,id',
            'nickname' => 'required|string|max:10',
            'password' => 'nullable|string|between:6,12',
            'power' => 'required',
        ];

        $errors = [
            'nickname.required' => '请输入昵称',
            'nickname.max' => '昵称至多10个字符',
            'password.between' => '密码应6-12个字符'
        ];

        $request->request->add(['id' => $id]);

        $validator = parent::return_validator($request->all(), $term, $errors);

        //判断表单验证是否通过
        if ($validator['status'] === 'fails') {

            //反馈错误信息给前台
            return parent::return_ajax_array($validator);
        }

        if (!in_array($request->power,array_keys(self::power())))return parent::return_ajax(false, ['状态错误']);

        $master = $this->model->find($id);

        $master->young_nickname = $request->nickname;
        $master->young_power = $request->power;
        if (!is_null($request->password)) $master->password = Hash::make($request->password);
        $master->save();

        return parent::return_ajax(true, ['操作成功']);
    }

    public function destroy($id)
    {
        $user = parent::get_user();

        if ($user['young_account_number'] != 'admins') return parent::return_ajax(false, ['没有权限']);

        $ids = explode(',', $id);

        if (in_array($user['id'], $ids)) return parent::return_ajax(false, ['无法删除' . $user['young_nickname']]);

        $this->model->destroy($ids);

        return parent::return_ajax(true, ['操作成功']);
    }

    private function power()
    {
        return [
            10 => '查看',
            20 => '编辑',
        ];
    }
}
