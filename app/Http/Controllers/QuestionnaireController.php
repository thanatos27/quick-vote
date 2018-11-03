<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Questionnaire;
use App\Http\Resources\Questionnaire as QuestionnaireResource;

class QuestionnaireController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Get Questionnaires
        $questionnaire = Questionnaire::paginate(5);

        return QuestionnaireResource::collection($questionnaire);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $questionnaire = $request->isMethod('put') ? 
            Questionnaire::findOrFail($request->questionnaire_id) : new Questionnaire;

            $questionnaire->id = $request->input('questionnaire_id');
            $questionnaire->title = $request->input('title');
            $questionnaire->description = $request->input('description');
            $questionnaire->choice_1 = $request->input('choice_1');
            $questionnaire->choice_2 = $request->input('choice_2');

            if($questionnaire->save()) {
                return new QuestionnaireResource($questionnaire);
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
        // Get questionnaire
        $questionnaire = Questionnaire::findOrFail($id);

        // Return Questionnaire as a resource
        return new QuestionnaireResource($questionnaire);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Get questionnaire
        $questionnaire = Questionnaire::findOrFail($id);

        // Return Questionnaire as a resource
        if ($questionnaire->delete()) {
            return new QuestionnaireResource($questionnaire);
        }
    }
}
