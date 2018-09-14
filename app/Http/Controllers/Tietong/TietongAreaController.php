<?php

namespace App\Http\Controllers\Tietong;

use App\Models\Tietong\TietongArea;
use App\Models\Tietong\TietongMan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TietongAreaController extends TietongController implements ListInterface
{
    private $model;

    public function __construct()
    {
        $this->model = new TietongArea();
    }

    public function index()
    {
        $user = parent::get_user();

        if ($user['young_account_number'] != 'admins') return parent::return_ajax(false, ['没有权限']);

        $result = parent::return_list($this->model->orderBy('young_sort', 'asc'));

        return parent::return_view('areaList', $result);
    }

    public function show($id)
    {
        // TODO: Implement show() method.
    }

    public function create()
    {
        return parent::return_view('areaAdd');
    }

    public function store(Request $request)
    {
        $user = parent::get_user();

        if ($user['young_account_number'] != 'admins') return parent::return_ajax(false, ['没有权限']);

        $term = [
            'name' => 'required|string|max:10|unique:tietong_areas,young_name',
            'sort' => 'required|integer|between:0,999',
        ];

        $errors = [
            'name.required' => '请输入分中心名称',
            'name.max' => '分中心名称至多10个字符',
            'name.unique' => '名称被占用',
            'sort.required' => '请输入排序',
            'sort.integer' => '排序必须是数字',
            'sort.between' => '排序应介于0-999',
        ];

        $validator = parent::return_validator($request->all(), $term, $errors);

        //判断表单验证是否通过
        if ($validator['status'] === 'fails') {

            //反馈错误信息给前台
            return parent::return_ajax_array($validator);
        }

        $area = $this->model;
        $area->young_name = $request->name;
        $area->young_sort = $request->sort;
        $area->save();

        return parent::return_ajax(true, ['操作成功']);
    }

    public function edit($id)
    {
        $result = $this->model->find($id);
        if (is_null($result)) dd('错误edit');

        return parent::return_view('areaEdit', ['self' => $result]);
    }

    public function update($id, Request $request)
    {
        $user = parent::get_user();

        if ($user['young_account_number'] != 'admins') return parent::return_ajax(false, ['没有权限']);

        $term = [
            'id' => 'required|exists:tietong_areas,id',
            'name' => 'required|string|max:10|unique:tietong_areas,young_name,' . $id . ',id',
            'sort' => 'required|integer|between:0,999',
        ];

        $errors = [
            'name.required' => '请输入分中心名称',
            'name.max' => '分中心名称至多10个字符',
            'name.unique' => '名称被占用',
            'sort.required' => '请输入排序',
            'sort.integer' => '排序必须是数字',
            'sort.between' => '排序应介于0-999',
        ];

        $request->request->add(['id' => $id]);

        $validator = parent::return_validator($request->all(), $term, $errors);

        //判断表单验证是否通过
        if ($validator['status'] === 'fails') {

            //反馈错误信息给前台
            return parent::return_ajax_array($validator);
        }

        $area = $this->model->find($id);

        $area->young_name = $request->name;
        $area->young_sort = $request->sort;
        $area->save();

        TietongMan::where('young_area_id', '=', $id)->update(['young_area_name' => $request->name]);

        return parent::return_ajax(true, ['操作成功']);
    }

    public function destroy($id)
    {
        $user = parent::get_user();

        if ($user['young_account_number'] != 'admins') return parent::return_ajax(false, ['没有权限']);

        $ids = explode(',', $id);

        $test = TietongMan::whereIn('young_area_id', $ids)->first();
        if (!is_null($test)) return parent::return_ajax(false, ['不能删除使用中的分中心']);

        $this->model->destroy($ids);

        return parent::return_ajax(true, ['操作成功']);
    }
}
