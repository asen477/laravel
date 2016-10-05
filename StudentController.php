<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/10/4 0004
 * Time: 上午 10:38
 */

namespace App\Http\Controllers;

use App\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;


class StudentController extends Controller
{

    public function test1()
    {
        $student = DB::select('select * from articles');
        dd($student);


        $bool = DB::insert('insert into articles(title,body) values(?,?)',
            ['asen',32]);
        var_dump($bool);


        $num = DB::update('update articles set title = ? where title = ?',
            ['5555555','asen']);
        var_dump($num);

        $del = DB::delete('delete from articles where id= ?',[12]);
        var_dump($del);
    }

    public function query1(){

        $bool = DB::table('articles')->insert(
            ['title'=>'标题','body'=>'内容','created_at'=>date('Y-m-d H:i:s')]
        );
        var_dump($bool);

        $id = DB::table('articles')->insertGetId(
            ['title'=>'1','body'=>2]
        );
        var_dump($id);

         $bool2 = DB::table('articles')->insert([
             ['title'=>'t1','body'=>'b1'],
             ['title'=>'t2','body'=>'b2'],
             ['title'=>'t3','body'=>'b3']
         ]);
        var_dump($bool2);
    }


    public function query2(){
        $num = db::table('articles')
            ->where('id',11)
            ->update(['title'=>1111111]);
        var_dump($num);

        //自增  自减
        $num2 = DB::table('articles')->increment('title',3);
        $num2 = DB::table('articles')->increment('title');
        $num3 = DB::table('articles')->decrement('title',3);
        $num3 = DB::table('articles')->decrement('title');
        var_dump($num2);

        //删除数据
        $num4 = dB::table('articles')
            ->where('id',15)
            ->delete();

        $num4 = dB::table('articles')
              ->where('id','>=',15)
              ->delete();
        //删除所有数据
//        DB::table('articles')->truncate();
    }

    public function query3(){
        $num = DB::table('student')->insert([
            ['id'=>1001,'name'=>'name1','age'=>18],
            ['id'=>1002,'name'=>'name2','age'=>18],
            ['id'=>1003,'name'=>'name3','age'=>19],
            ['id'=>1004,'name'=>'name4','age'=>20],
            ['id'=>1005,'name'=>'name5','age'=>21],
        ]);
        var_dump($num);

        $students = DB::table('student')->get();
        $students2 = DB::table('student')
            ->orderBy('id','desc')
            ->first();
        dd($students2);

        //where
        $students3 = DB::table('student')
            ->where('id','>=',1002)
           // ->orderBy('id','desc')
            ->get();
        dd($students3);
        //多条件

        $students4 = DB::table('student')
            ->whereRaw('id > ? and age > ?',[1001,18])
            ->get();
       // dd($students4);

        //pluck
        $names = DB::table('student')->pluck('name');
        dd($names);

        //lists
        $names2 = DB::table('student')->lists('name','id');
        dd($names2);

        //select
        $list = DB::table('student')->select( 'name','age')->get();
        dd($list);

        // chunk

        DB::table('student')->chunk(4,function($students){
            var_dump($students);
            if ('满足你的条件'){
                return false;
            }
        });

    }

    // 聚合函数
    public function query5(){
        $num = DB::table('student')->count();
       // dd($num);
        $max = DB::table('student')->max('age');
        $min = DB::table('student')->min('age');
        $avg = DB::table('student')->avg('age');
        $sum = DB::table('student')->sum('age');
        var_dump("max:".$max);
        var_dump("min:".$min);
        var_dump("avg:".$avg);
        var_dump("sum:".$sum);
    }

    //
    public function orm1(){

        // all() 查询所有
        $students = Student::all();
//        dd($students);

        // find() 查询一条
        $students2 = Student::find(1001);
        //dd($students2);
//        var_dump($students2);

        // findOrFail()  条件不满足就失败
        //$students3 = Student::findOrFail(1006);
     //   var_dump($students3);

        $students4 = Student::get();
        $students4 = Student::where('id','>=',1001)->orderBy('id','desc')->first();

        Student::chunk(2,function($students4){
           // var_dump($students4);
        });
//        dd($students4);

        //聚合函数
        $num = Student::count();
        $max = Student::max('age');
        var_dump($max);
    }

    public function orm2(){

        // 试用模型新增数据
        $student = new Student();
        $student->name = 'Trunks2';
        $student->age = 15;
        $bool = $student->save();
        dd($bool);

        $student = Student::find(1008);
        $updated_at = $student->updated_at;
        echo date('Y.m.d H.i.s',$updated_at);

        // 试用模型的Create 方法新增数据
        $student3 = Student::create(
            ['name' => 'asen', 'age' => 199]
        );

        dd($student3);
        //firstOrCreate()  没有自动创建
       $studets =  Student::firstOrCreate(
            ['name' => 'asensss']
        );
        dd($studets);

        // firstOrNew() 没有找到自己创建实例，如需保存，自己调用save；
        $studets = Student::firstOrNew(
            ['name' => 'asensss']
        );
        $bool = $studets->save();
        dd($bool);
    }

    public function orm3(){

        // 通过模型更新数据
        $student = Student::find(1002);
        $student->name = 'kitty';
        $bool = $student->save();
        var_dump($bool);

        // 通过条件更新；
        $num = Student::where('id','>',1008)->update(
            ['age' => 41]
        );
        var_dump($num);
    }

    public function orm4(){

        // 通过模型删除
//        $student = Student::find(1001);
//        $bool = $student->delete();
//        var_dump($bool);

        // 通过组件删除
//        $num = Student::destroy([
//            1008,1009
//        ]);
//        $num = Student::destroy(1008,1009);
//        var_dump($num);

        $num = Student::where('id','>',1004)->delete();
        var_dump($num);
    }

    //模板调用
    public function section1(){
        $studets = Student::get();
        $studets = [];
        $name = 'asen';
        $arr = ['asen','imooc'];

        return view('student.section1',[
            'name'      => $name,
            'arr'       => $arr,
            'studets'   => $studets,
        ]);
    }

    //URL
    public function urlTest(){
        return 'urltest';
    }

    //Request  请求
    public function request1(Request $request){

//        // 1 取值
//        echo $request->input('name');
//        echo $request->input('sex','未知');   //默认值
//
//        if ($request->has('name')){
//            echo $request->input('name');
//        } else {
//            echo '无该参数';
//        }
//
//        $res = $request->all();
//      //  dd($res);
//
//        // 2. 判断请求类型
//        echo $request->method();
//        echo "<br>";
//        if ($request->isMethod('POST')){
//            echo 'yes';
//        } else {
//            echo 'no';
//        }
//        echo "<br>";
//        $res = $request->ajax();
//        var_dump($res);                                                   x
//       // echo "<br>";
//
//       // $res2 = $request->is('student/*');
//       // var_dump($res2);
//
//        echo $request->url();   //输出当前的URL

    }

    // session
    /**
     * @param Request $request
     */
    public function session1(Request $request)
    {
        // 1 HTTP request session();
        $request->session()->put('key1', 'value1');
        echo $request->session()->get('key1');

        // 2 session()
        session()->put('key2', 'value2');
        echo session()->get('key2');

        // 3 Session class
        // put 存取数据  get 获取数据
        Session::put('key3', 'value3');
        echo Session::get('key3');
        echo Session::get('key43', 'default');

        // 把数据放到session数组里
        Session::put(['key4' => 'value4']);
        echo Session::get('key4');

        Session::push('student', 'Trunks');
        Session::push('student', 'imooc');
        $res = Session::get('student', 'default');
        var_dump($res);

        //取出数据并删除
        $res = Session::pull('student', 'default');
        var_dump($res);
        // 取出所有的值
//        $res = Session::all();
//        dd($res);
        // 判断session种某个key 是否存在
//        if (Session::has('key14')) {
//            $res = Session::all();
//            dd($res);
//        } else {
//            echo 'sessionkey 不存在';
//        }
//
//        // 获取session所有数据
//        $res = Session::all();
//        var_dump($res);
//        //删除 session key
//        //    Session::forget('key2');
//
//        $res = Session::all();
//        var_dump($res);
//        // 清空所有session
//        Session::flush();
//        $res = Session::all();
//        dd($res);

        // session 暂存数据 第一次访问又，第二次就没了
        Session::flash('key-flash','value-flash');
        echo Session::get('key-flash');

    }

    public function session2(Request $request){
        return  Session::get('message','暂无信息');
       // return 'session2';
    }

    // Controller 之 redirect 跳转
    public function response(){

//        // 响应json
//        $data = [
//            'errCode'   => 0,
//            'errMsg'    => 'success',
//            'data'      => 'trunks',
//        ];
//        return response()->json($data);

        // 4 重定向
//        return redirect('session2');
        //return redirect('session2')->with('message','没有成功');

        // action()
 //       return redirect()->action('StudentController@session2')->with('message','没有成功');

        // route() 别名跳转
 //       return redirect()->route('session2')->with('message','aaaaaaaa');

        //返回上一个页面
        return redirect()->back();
    }

    // 活动的宣传页面
    public function activity0(){

        return '活动就要快开始了。';

    }

    // 活动的宣传页面
    public function activity1(){

        return '活动进行中';

    }

    // 活动的宣传页面
    public function activity2(){

        return '活动结束了';

    }






}