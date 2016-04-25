<?php
namespace App\Http\Ideas;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Challenges;
use App\User;
use DB;
use Auth;
use Log;

class IdeasController extends Controller
{

    protected $ideas;

    //RESTE A FAIRE: recuperer le challenge vu par l'user dans $challenge, pour recuperer ses idees
    //$challenge = Challenges::find($id);
    $user = Auth::user();
    if (isset($user)){
      $isAdmin = $user->isAdmin;
    }
    else{
      $isAdmin = false;
    }

    //retourne la liste des idées d'un challenge
    public function index(Request $request)
    {
        $ideas = Ideas::orderBy('created_at', 'desc')->get($challenge);

        return view('ideas.list', [
            'ideas' => $ideas,
            'isAuth' => $user,
            'isAdmin' => $isAdmin
        ]);
    }

    //retourne le detail d'une idée
    public function detail($idIdea)
    {
      $idea = Ideas::where('id', $idIdea)->get();
      Log::info($idea);
      return view('idea.detail',
      ['idea' => $idea,
      'isAuth' => $user,
      'isAdmin' => $isAdmin
      ]);
    }

    //retourne l'interface de création d'une nouvelle idée
    //manque: function "showStore"
    /*
    *
    public function showStore ($challenge, $idIdea=false){

  }

    */

    //sauvegarde d'un nouveau challenge
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:255',
            'description' => 'required|max:500',
            'content' => 'required|max:20000',
            //6 éléments array?
        ]);

        $idea = new Ideas;
        $idea->name = $request->name;
        $idea->description = $request->description;
        $idea->content = $request->content;
        $idea->save();

        Log::info($idea);
      return redirect(/*liste des idees*/);
    }
}
