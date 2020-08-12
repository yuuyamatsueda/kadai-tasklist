<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Task;

class TasksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tasks = Task::all();
        
        return view('tasks.index', [
            'tasks' => $tasks,
        ]);
        
         $data = [];
        if (\Auth::check()) { // 認証済みの場合
            // 認証済みユーザを取得
            $user = \Auth::user();
            // ユーザの投稿の一覧を作成日時の降順で取得
            $taskls = $user->tasks()->orderBy('created_at', 'desc')->paginate(10);

            $data = [
                'user' => $user,
                'tasks' => $tasks,
            ];
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $task = new Task;
        
        return view('tasks.create', [
            'task' => $task,
        ]);    
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            // 'user_id' => 'required|max:10',
            'status' => 'required|max:10',
            'content' => 'required|max:255',
            ]);
        
        $request->user()->tasks()->create([
            // $task = new Task,
            // 'user_id' => $request->user_id,
            'content' => $request->content,
            'status' => $request->status,
            // $task->save(),
            ]);
        // $task = new Task;
        // $task->user_id = $request->user_id;
        // $task->status = $request->status;
        // $task->content = $request->content;
        // $task->save();
        return redirect('/');
        // // バリデーション
        // $request->validate([
        //     'content' => 'required|max:255',
        // ]);

        // // 認証済みユーザ（閲覧者）の投稿として作成（リクエストされた値をもとに作成）
        // $request->user()->microposts()->create([
        //     'content' => $request->content,
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $task = Task::findOrFail($id);
        if (\Auth::id() === $task->user_id){
        return view('tasks.show', [
            'task' => $task,
        ]);    }
        else{
            return redirect('/');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $task = Task::findOrFail($id);
        
        return view('tasks.edit', [
            'task' => $task,
        ]);    
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'status' => 'required|max:10',
            'content' => 'required|max:10',
            ]);
        
        $task = Task::findOrFail($id);
        $task->status = $request->status;
        $task->content = $request->content;
        $task->save();
        return redirect('/');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $task = Task::findOrFail($id);
        if (\Auth::id() === $task->user_id) {
            $task->delete();
        }
        
        return redirect('/');
       
    }
}

//  // 認証済みユーザ（閲覧者）がその投稿の所有者である場合は、投稿を削除
//         if (\Auth::id() === $micropost->user_id) {
//             $micropost->delete();
//         }
