<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Config;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class ConfigController extends CommonController
{
    //get admin/config
    public function index(){
        $data = Config::orderBy('conf_order', 'asc')->get();

        foreach($data as $k => $v){
            //echo $v->field_type;
            switch($v->field_type){
                case 'input':
                    $data[$k]->_html = '<input type="text" class="lg" name="conf_content[]" value="'.$v->conf_content.'">';
                    break;
                case 'textarea':
                    $data[$k]->_html = '<textarea name="conf_content[]">'.$v->conf_content.'</textarea>';
                    break;
            }
        }

        return view('admin.conf.index', compact('data'));
    }

    //get admin/config/create
    public function changecontent(){
        $input = Input::except('_token');//除了token之外全部的值保存
        foreach($input['conf_id'] as $k => $v){
            Config::where('conf_id', $v)->update(['conf_content'=>$input['conf_content'][$k]]);// update 特別要注意 where判斷
        }
        $this->putFile();
        return back()->with('errors','配置項更新成功');
    }

    public function putFile()
    {
        //echo \Illuminate\Support\Facades\Config::get('web.web_conut');
        $config = Config::pluck('conf_content','conf_name')->all();
        $path = base_path().'\config\web.php';
        $str = '<?php return '.var_export($config,true).';';
        file_put_contents($path,$str);
    }
    
    //get admin/config/create
    public function create(){
         return view('admin.conf.add');
    }

    //post admin/config
    public function store(){
        $input = Input::except('_token');//除了token之外全部的值保存
        $validator = $this->checkValidator($input);
        if ($validator->passes()) {
            //https://laravel.com/docs/5.2/eloquent#mass-assignment
            //insert須在Model增加 fillable 或是 guarded 來保護Mass Assignment
            $re = Config::create($input);
            if($re){
                return redirect('admin/config');
            }else{
                return back()->with('errors','新增失敗');
            }
        } else{
            return back()->withErrors($validator);//回傳錯誤訊息給上頁變數為$errors
        }
    }

    //get admin/config/{config}/edit
    public function edit($config_id){
        $data = Config::find($config_id);//find()找主鍵的值
        return view('admin.conf.add')->with('data', $data);
    }

    //put admin/config/{config}
    public function update($conf_id){
        $input = Input::except('_token', '_method');//除了token之外全部的值保存
        $validator = $this->checkValidator($input);
        if ($validator->passes()) {
            $re = Config::where('conf_id', $conf_id)->update($input);// update 特別要注意 where判斷
            if($re){
                $this->putFile();
                return redirect('admin/config');
            }else{
                return back()->with('errors','修改失敗');
            }
        }else{
            return back()->withErrors($validator);//回傳錯誤訊息給上頁變數為$errors
        }
    }

    //delete admin/config/{conf_id}
    public function destroy($conf_id){
        $re = Config::where('conf_id', $conf_id)->delete();
        if($re){
            $data = [
                'status' => 0,
                'message' => '刪除成功',
            ];
        }else{
            $data = [
                'status' => 1,
                'message' => '刪除失敗,請稍後再試',
            ];
        }
        return $data;
    }

    //ajax 配置項目排序
    public function changeOrder()
    {
        $input = Input::all();
        $link = Config::find($input['conf_id']);
        $link->conf_order = $input['conf_order'];
        $re = $link->update();
        if($re){
            $data = [
                'status' => 0,
                'message' => '儲存成功',
            ];
        }else{
            $data = [
                'status' => 1,
                'message' => '儲存失敗,請稍後再試',
            ];
        }
        return $data;
    }
    
    //判斷 input 裡的 Validator::make
    private function checkValidator($input){
        $rules = [
            'conf_title' => 'required',
            'conf_name' => 'required',
        ];

        $messages = [
            'conf_title.required' => '配置項標題必須填寫',
            'conf_name.required' => '配置項名稱必須填寫',
        ];
        return Validator::make($input, $rules, $messages);
    }

}
