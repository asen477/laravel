<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

/*Route::get('/', function () {
    return view('welcome');
});
*/

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/
/*
Route::group(['middleware' => ['web']], function () {
    //
});*/

Route::get('asen', function () {
    return 'Hello World----route';
});

Route::post('foo/bar', function () {
    return 'Hello World';
});

Route::put('foo/bar', function () {
    //
});

Route::delete('foo/bar', function () {
    //
});

Route::match(['get', 'post'], 'foo/bar', function () {
    return 'match：多个方法的路由配置';
});

Route::any('foo', function () {
    return 'any：支持任何方法路由配置';
});

//配置参数固定的  一个参数
Route::get('user/{id}', function ($id) {
    return 'User '.$id;
});
// 多个参数
Route::get('a/{a}/b/{b}', function ($postId, $commentId) {
    return $postId."-----".$commentId;
});


Route::get('user1/{name?}', function ($name = null) {
    return $name;
});

Route::get('user2/{name?}', function ($name = 'John') {
    return $name;
});
Route::get('age/{age}', function ($age = 3) {
    return $age;
});

//正则表达式约束
/*
Route::get('user/{name}', function ($name) {
    //
})->where('name', '[A-Za-z]+');

Route::get('user/{id}', function ($id) {
    //
})->where('id', '[0-9]+');

Route::get('user/{id}/{name}', function ($id, $name) {
    //
})->where(['id' => '[0-9]+', 'name' => '[a-z]+']);

*/

Route::get('kid/{id}', 'UserController@showinfo');

Route::resource('photo', 'PhotoController');

Route::resource('photo', 'PhotoController',
                ['only' => ['index', 'show']]);

Route::resource('photo', 'PhotoController',
                ['except' => ['create', 'store', 'update', 'destroy']]);

Route::resource('photo', 'PhotoController',
                ['names' => ['create' => 'photo.build']]);

Route::resource('photos.comments', 'PhotoCommentController');

Route::controller('users', 'UserController');


Route::controller('users', 'UserController', [
    'getShow' => 'user.show',
]);


Route::any('user3/{id}', 'UserController@update');


Route::get('/', function ()    {
    return view('a', ['name' => 'James','age' => 18]);
});

Route::any('example/a1',function(){
	$data = array("a"=>1);
	if (view()->exists("example.a1")) {
		echo ("+++++++++++++");
	} else {
		echo ("-------------");
	}
	return view('example.a1',['name' => 'James']);
});
Route::group(['middleware' => 'web'], function () {
    Route::auth();

    Route::get('/home', 'HomeController@index');
});


Route::get('now', function () {  
    return date("Y-m-d H:i:s");
});

Route::get('blog', 'BlogController@index');

Route::group(['middleware' => 'auth', 'namespace' => 'Admin', 'prefix' => 'admin'], function() {
    Route::get('/', 'BlogController@index');
});

// DBcaozuo

Route::any('test1','StudentController@test1');
Route::any('query1',['uses' =>'StudentController@query1',
                    'as'    =>'abcd'
]);
Route::any('query2','StudentController@query2');
Route::any('query3','StudentController@query3');
Route::any('query5','StudentController@query5');
Route::any('orm1','StudentController@orm1');
Route::any('orm2','StudentController@orm2');
Route::any('orm3','StudentController@orm3');
Route::any('orm4','StudentController@orm4');
Route::any('section1','StudentController@section1');

Route::any('url',['uses' =>'StudentController@urlTest',
    'as'    =>'url'
]);

Route::any('student/request1',['uses' => 'StudentController@request1']);

Route::group(['middleware' => ['web']],function(){
    Route::any('session1',['uses' => 'StudentController@session1']);
    Route::any('session2',['uses' => 'StudentController@session2','as' => 'session2']);
});

Route::any('response',['uses' => 'StudentController@response']);


// 宣传页面
Route::any('activity0',['uses' => 'StudentController@activity0']);

//活动页面
Route::group(['middleware' => ['activity']],function(){
    Route::any('activity1',['uses' => 'StudentController@activity1']);
    Route::any('activity2',['uses' => 'StudentController@activity2']);
});




