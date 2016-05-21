<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;


class Category extends Model
{
    //
    protected $table = 'category';
    protected $primaryKey = 'cate_id';
    public $timestamps = false;

    //$guarded = [];空的代表所有的新增欄位都可以儲存
    protected $guarded = [];//insert須增加 fillable 或是 guarded 來保護Mass Assignment

    //第1,2種方法
//    public function tree(){
//        $categorys = $this->all();
//        return $this->getTree($categorys, 'cate_name', 'cate_id', 'cate_pid');
//    }

    //第3種方法
    public static function tree(){
        $categorys = Category::orderBy('cate_order','asc')->get();//預設為asc
        return (new Category)->getTree($categorys, 'cate_name', 'cate_id', 'cate_pid');
    }

    //二層階層
    public function getTree($data, $field_name, $field_id="id", $field_pid="pid", $pid=0){
        $arr = array();
        foreach($data as $k => $v){
            if($v->$field_pid == $pid){
                $data[$k]['_cate_name'] = $data[$k][$field_name];
                $arr[] = $data[$k];
                foreach($data as $m => $n){
                    if($v->$field_id == $n->$field_pid){
                        $data[$m]['_'.$field_name] = '├─ '.$data[$m]['cate_name'];
                        $arr[] = $data[$m];
                    }
                }
            }
        }
        return $arr;
    }

}
