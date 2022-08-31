<?php

namespace App\Http\Controllers;

use App\Models\Team;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ListController extends Controller
{
    public function index()
    {
        $data = [];
        $teams=Team::get();
         foreach($teams as $key => $team){
            $subteams = User::where('team_id', $team->id)->where('department_id', 14)->count();
            // $subteams = User::distinct()->where([
            //     ['team_id', $team->id],
            //     ['department_id', 14]
            // ])->get(['sub_team_id']);
            $subteams = DB::select(" SELECT DISTINCT(sub_team_id) FROM users WHERE team_id = $team->id AND department_id = 14 ");
            $data[$key]['teams'] = $team;

                foreach($subteams as $sub_key => $subteam){
                if ($subteam->sub_team_id == 0) {
                    continue;
                }
                
                $users = User::where([
                    ['team_id', $team->id],
                    ['sub_team_id', $subteam->sub_team_id],
                    ['department_id', 14]
                    ])->get();

                $data[$key]['subteams'][$sub_key]['sub'] = User::where('department_id', 14)->find($subteam->sub_team_id);
                    
                    if (empty($data[$key]['subteams'][$sub_key]['sub'])) {
                        $data[$key]['subteams'][$sub_key]['sub'] = User::where('department_id', 14)->where('team_id', $team->id)->where('sub_team_id', $subteam->sub_team_id)->first();
                    }
                   
                    $data[$key]['subteams'][$sub_key]['users'] = $users;
                }

         }
        //dd($data);
        return view('list',['data' => $data]);
    }

    public function loadData(Request $request)
    {

        $teams = Team::get();
        $data = [];
        $z=0;
       
        if ($request->ajax()) {
            if ($request->id>0) {
                $data_teams = Team::get();
            }else{
                $data_teams = Team::get();
               

            }
            $output = '';
            $last_id='';
            if (!$teams->isEmpty()) {
                foreach($data_teams as $key => $item)
                {

                    $output.= '
                <tr class="clickable " data-toggle="collapse" data-target=".group-of-rows-'. $key. '" aria-expanded="false" aria-controls="group-of-rows-'.$key.'">
                <td><i class="fas fa-plus"></i></td>
                <td colspan="4">'. $item->name.'</td>
                </tr>';
                  
                }


            }else{

            }
            return $output;
        }
        // if ($request->ajax()) {
        //     if ($request->id > 0) {
        //         $data_teams = Team::where('id', '>', $request->id)->orderBY('id', 'ASC')->paginate(5);
        //     } else {
        //         $data_teams = Team::orderBY('id', 'ASC')->paginate(5);
        //     }
        //     $output = '';
        //     $last_id = '';
        //     if (!$data_teams->isEmpty()) {
        //         foreach ($data_teams as $row) {
        //             $output .= '
        //             <div class="row">
        //                 <div class="col-md-12">
        //                 <h3 class="text-info"><b>[' . $row->id . ']</b> ' . $row->name . '</h3>
        //                 </div>         
        //             </div>';
        //             $last_id = $row->id;
        //         }
        //         $output .= ' 
        //         <div id="load_more">
        //             <button type="button" name="load_more_button" class="btn btn-success form-control" data-id="' . $last_id . '" id="load_more_button">Load More</button>
        //         </div>';
        //     } else {
        //         $output .= '
        //         <div id="load_more">
        //             <button type="button" name="load_more_button" class="btn btn-info form-control">No Data Found</button>
        //         </div>';
        //     }
        //     return $output;
        // }
    }
}
