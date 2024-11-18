<?php

namespace App\Services\Models;

use App\Http\Resources\QuestionResource;
use App\Models\Question;
use App\Services\Utils\Imageable;
use App\Services\Utils\paginatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class QuestionModel extends Model
{
    use paginatable, Imageable;

    public $dataImage = [
        'title' => '',
        'image' => '',
        'dir' => Question::DIR
    ];
    public $dataModel = [
        'model' => '',
        'relation' => 'mediaFirst'
    ];

    public function getAllQuestion()
    {
        $questions = Question::with('exam')->latest()->paginate();
        return response()->json([
            'Status' => Response::HTTP_OK,
            'data' => QuestionResource::collection($questions),
            'meta' => $this->getPaginatable($questions)
        ]);
    }

    public function storeQuestion(Request $request)
    {
        $data = $request->validated();
        $data['question'] = json_encode($request->question);
        $question = Question::create($data);

        if($request->file('image')){
            $this->dataImage['title'] = $question->id;
            $this->dataImage['image'] = $request->image;
            $this->dataModel['model'] = $question;
            $this->handleImageNameAndInsertInDb($this->dataImage, $this->dataModel);
        }
        return response()->json([
            'status' => Response::HTTP_CREATED,
            'data' => new QuestionResource($question)
        ],Response::HTTP_CREATED);
    }

    public function showQuestion(Question $question)
    {
        $question = $question->load(['exam','mediaFirst']);
        return response()->json([
            'data' => new QuestionResource($question)
        ]);
    }

    public function updateQuestion(Request $request, Question $question)
    {
        $data = $request->validated();
        $data['question'] = json_encode($request->question);
        $question->update($data);
        if($request->file('image')){
            $this->dataImage['title'] = $request->type;
            $this->dataImage['image'] = $request->image;
            $this->dataModel['model'] = $question;
            $this->deleteImage(Question::DISK_NAME,$question->mediaFirst);
            $this->handleImageNameAndInsertInDb($this->dataImage, $this->dataModel);
            $question->update($request->except(['image']));
        }
        return response()->json([
            'status' => Response::HTTP_ACCEPTED,
            'data' => new QuestionResource($question)
        ], Response::HTTP_ACCEPTED);
    }

    public function destoryQuestion($question)
    {
        if($question->mediaFirst){
            $this->deleteImage(Question::DISK_NAME, $question->mediaFirst);
        }
        $question->delete();
        return response()->json([],Response::HTTP_NO_CONTENT);
    }

}
