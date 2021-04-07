<?php

namespace App\Http\Controllers;

use App\Searcher;
use App\Submission;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Spatie\Searchable\Search;


class SearchController extends Controller
{
    public function index(Request $request){
        // return view('search');
        $search = $request->q;
        $sql = array(
            DB::raw('t_submissions.submisi_judul'),
            DB::raw('t_submissions.submisi_id'),
            DB::raw('m_user.user_name as author'),
            DB::raw('t_submissions.submisi_foto as src'),
        );
        $data = DB::table('t_submissions')
                ->select($sql)
                ->join('m_user', 't_submissions.user_id', '=', 'm_user.user_id')
                ->where('submisi_judul', 'like', '%'.$search.'%')->get();

            if ($data->isEmpty()){
                return response(['response' => 'failed', 'message' => 'Maaf submisi tidak ada.']);
            } else {
                return response(['response' => 'success', 'data' => $data]);
            }
    }

    public function popular(){

        $max = DB::table('t_submissions')
            ->select(DB::raw('count(submisi_id) as total'))
            ->where('submisi_is_active', '=', 1)
            ->get();
        
        $random = rand(1, $max[0]->total);

        $sql = array(
            DB::raw('t_submissions.submisi_judul'),
            DB::raw('t_submissions.submisi_id'),
            DB::raw('m_user.user_name as author'),
            DB::raw('t_submissions.submisi_foto as src'),
        );
        $data = DB::table('t_submissions')
                ->select($sql)
                ->join('m_user', 't_submissions.user_id', '=', 'm_user.user_id')
                ->where('submisi_id', $random)->get();

        return $data;
        
    }


}
