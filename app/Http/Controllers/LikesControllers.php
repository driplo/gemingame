<?php
namespace App\Http\Votes;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Ideas;
use App\User;
use DB;
use Auth;

class VotesControllers extends Controller{
  public function like($idea, $user)
    {
      if (Auth::check())
      {
    // ++ sur les votes
    }
    }

    public function dislike($idea, $user){
      if (Auth::check())
      {
    // -- sur les votes
    }
    }
  }
