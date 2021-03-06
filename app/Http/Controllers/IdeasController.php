<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Challenges;
use App\Ideas;
use App\IdeasElements;
use App\User;
use DB;
use Auth;
use Log;

class IdeasController extends Controller
{

    protected $ideas;

    public function detail($challenge, $idea)
    {
      $ideaElement = DB::table('ideas_elements')->where('ideas_elements.IDIdea', $idea)->join('ideas', 'ideas_elements.IDIdea', '=', 'ideas.IDIdea')->get();
      return $ideaElement;
      // return view('idea.detail', ['idea' => $idea]);
    }

    //retourne l'interface de création d'une nouvelle idée
    //manque: function "showStore"

    //sauvegarde d'un nouveau challenge
    /*En cours*/
    public function storeIdea(Request $request, $challenge)
    {

      $user = Auth::user();

      $challengeUrl = Challenges::where('id', $challenge)->value('url');

      $this->validate($request, [
          'title' => 'required|max:255',
          'content' => 'required|max:2500',
      ]);
      $idea = new Ideas;
      $idea->title = $request->title;
      $idea->content = $request->content;
      $idea->IDChallenge = $challenge;
      $idea->IDUser = $user->id;
      $idea->save();

      if($request->rebound == 'false')
      {
        $ideaelements = new IdeasElements;
        $ideaelements->IDIdea = $idea->IDIdea;
        $ideaelements->character = $request->character;
        $ideaelements->place = $request->place;
        $ideaelements->ressource = $request->ressource;
        $ideaelements->quest = $request->quest;
        $ideaelements->warning = $request->warning;
        $ideaelements->treasure = $request->treasure;
        $ideaelements->disruptive = $request->disruptive;
        $ideaelements->save();
        $idea->IDElements = $ideaelements->id;

      }else{
        $first = Ideas::where('IDIdea', $request->rebound)->first();
        $first->rebounds = $first->rebounds + 1;
        $idea->IDElements = $first->IDElements;
        $idea->ideaOrigin = $first->title;
        $first->save();
      }
      $idea->save();



      return redirect(route('challenge_detail', $challengeUrl));
    }

    // public function upvote(Ideas $idea){
    //   DB::table('ideas_elements')->where('id', $IDIdea->id)->increment('votes');
    //   return redirect('/task/'.$task->id);
    // }

    public function rebound (Request $request){
      if(Auth::Check()){

        $idea = Ideas::where('IDIdea', $request->get('id'))->first();
        if(!$idea){
          return 'false';
        }

      //nouvelle idée et éléments
      $newIdea = new Ideas;
      $this->validate($request, [
          'title' => 'required|max:255',
          'content' => 'required|max:2500',
      ]);

      $newIdea->title = $request->title;
      $newIdea->content = $request->content;
      $newIdea->IDChallenge = $idea->IDChallenge;
      $newIdea->IDUser = Auth::user()->id;
      $newIdea->save();

      $ideaElements = IdeasElements::where('IDIdea', $idea->IDIdea)->first()->replicate();
      $ideaElements->save();
      return IdeasElements::where('IDIdea', $idea->IDIdea)->count() - 1;

      }
      else return false;
    }
}
