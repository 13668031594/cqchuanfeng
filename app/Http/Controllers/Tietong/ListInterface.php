<?php
/**
 * Created by PhpStorm.
 * User: yangyang
 * Date: 2018/9/10
 * Time: 下午6:06
 */

namespace App\Http\Controllers\Tietong;


use Illuminate\Http\Request;

interface ListInterface
{
    public function __construct();

    public function index();

    public function show($id);

    public function create();

    public function store(Request $request);

    public function edit($id);

    public function update($id,Request $request);

    public function destroy($id);
}