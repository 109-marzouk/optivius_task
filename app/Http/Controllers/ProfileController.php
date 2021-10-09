<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

use App\Http\Resources\ProfileResource;
use App\Http\Resources\ArticleResource;

use App\Models\Profile;
use App\Models\Article;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;


class ProfileController extends Controller
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

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @param $id
     * @return JsonResponse
     */
    public function show(Request $request, $id): JsonResponse
    {
        $number_of_articles_per_page = 6;
        $pageNumber = $request->has("page") ? $request->get("page") : 1;
        $lang = $request->has("lang") ? $request->get("lang") : "en";

        try{
            $profile = Profile::findOrFail($id);

            $profile->name = json_decode($profile->name)->$lang;

            $all_profile_articles = Article::select('title', 'content', 'created_at')
                ->where('user_id', $profile->id)->get();

            $number_of_articles = $all_profile_articles->count();

            $profile->number_of_articles = $number_of_articles;

            $profile->last_page = ceil($number_of_articles/ $number_of_articles_per_page);

            $articles_per_page = $all_profile_articles
                ->forPage($pageNumber, $number_of_articles_per_page)->values();

            foreach ($articles_per_page as $article){
                $article->title = json_decode($article->title)->$lang;
                $article->content = json_decode($article->content)->$lang;
            }

            $profile->articles = $articles_per_page;

            return response()->json(
                [
                    'has_error' => false,
                    'error_message' => "YEAH! No errors are exist!",
                    'results' => $profile
                ],
                200);

        }catch (\Exception $e){
            return response()->json(
                [
                    'has_error' => true,
                    'error_message' => "Error: the requested user is not exist!",
                    'results' => array()
                ],
                404);
        }
    }
}
