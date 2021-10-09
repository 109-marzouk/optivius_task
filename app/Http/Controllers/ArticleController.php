<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Exception;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    /**
     * Instantiate a new UserController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function create(Request $request){

        $this->validate($request, [
            'title' => 'bail|required|json',
            'content' => 'bail|required|json',
        ]);

        $article = new Article();
        $article->title = $request->get('title');
        $article->content = $request->get('content');
        $article->user_id =$request->id;
        $article->save();

        return response()->json([
            "has_error" => false,
            "message" => "Article was created successfully!"
        ]);
    }

    public function update($id, Request $request){

        $this->validate($request, [
            'title' => 'bail|required|json',
            'content' => 'bail|required|json',
        ]);

        try{
            $article = Article::findOrFail($id);
        }catch (Exception $e){
            return response()->json([
                "has_error" => true,
                "message" => $e->getMessage()
            ]);
        }

        if($article->user_id != $request->id){
            return response()->json([
                "has_error" => true,
                "message" => "You do not have the right to update this article!"
            ]);
        }

        $article->title = $request->get('title');
        $article->content = $request->get('content');
        $article->user_id =$request->id;
        $article->save();

        return response()->json([
            "has_error" => false,
            "message" => "Article was updated successfully!"
        ]);
    }

    public function delete($id, Request $request){

        try{
            $article = Article::findOrFail($id);
        }catch (Exception $e){
            return response()->json([
                "has_error" => true,
                "message" => $e->getMessage()
            ]);
        }

        if($article->user_id != $request->id){
            return response()->json([
                "has_error" => true,
                "message" => "You do not have the right to delete this article!"
            ]);
        }

        $article->delete();

        return response()->json([
            "has_error" => false,
            "message" => "Article was deleted successfully!"
        ]);
    }
}
