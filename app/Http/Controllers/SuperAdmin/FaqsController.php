<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Faq;
use App\Models\FaqTopic;

class FaqsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $topics = FaqTopic::all();
        $faqs = Faq::select("tbl_acp_faqs.*", "tbl_acp_faq_topics.topic_name")->join("tbl_acp_faq_topics","tbl_acp_faq_topics.id", "tbl_acp_faqs.id")->get();
        return view('superadmin.faqs.index')->with("topics", $topics)->with("faqs",$faqs);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            "topic_id" => "required",
            "question" => "required",
            "answer" => "required"
        ]);
        try{
            $faq = new Faq();
            $faq->topic_id = $request->topic_id;
            $faq->question = $request->question;
            $faq->answer = $request->answer;
            if($faq->save()){
                return back()->withSuccess("Faq added Successfully")->withInput();
            }else{
                return back()->withError("Something went wrong :(")->withInput();
            }
        }catch(Exception $ex){
            return back()->withError($ex->getMessage())->withInput();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
       
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        $request->validate([
            "topic_id" => "required",
            "question" => "required",
            "answer" => "required"
        ]);
        try{
            $faq = Faq::where("id", $id)->first();
            $faq->topic_id = $request->topic_id;
            $faq->question = $request->question;
            $faq->answer = $request->answer;
            if($faq->save()){
                return back()->withSuccess("Faq Updated Successfully")->withInput();
            }else{
                return back()->withError("Something went wrong :(")->withInput();
            }
        }catch(Exception $ex){
            return back()->withError($ex->getMessage())->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeTopic(Request $request)
    {
        $request->validate([
            "topic_name" => "required",
            "target_group" => "required"
        ]);
        try{
            $faq_topic = new FaqTopic();
            $faq_topic->topic_name = $request->topic_name;
            $faq_topic->target_group = $request->target_group;
            if($faq_topic->save()){
                return back()->withSuccess("Topic added Successfully")->withInput();
            }else{
                return back()->withError("Something went wrong :(")->withInput();
            }
        }catch(Exception $ex){
            return back()->withError($ex->getMessage())->withInput();
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateTopic(Request $request, $id)
    {
        $request->validate([
            "topic_name" => "required",
            "target_group" => "required"
        ]);
        try{
            $faq_topic = FaqTopic::where("id", $id)->first();
            $faq_topic->topic_name = $request->topic_name;
            $faq_topic->target_group = $request->target_group;
            if($faq_topic->save()){
                return back()->withSuccess("Topic updated Successfully")->withInput();
            }else{
                return back()->withError("Something went wrong :(")->withInput();
            }
        }catch(Exception $ex){
            return back()->withError($ex->getMessage())->withInput();
        }
    }

}
