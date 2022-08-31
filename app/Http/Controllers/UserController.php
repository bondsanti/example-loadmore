<?php

namespace App\Http\Controllers;

use App\Models\Team;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

// use Illuminate\Support\Facades\Request;

class UserController extends Controller
{

    public function index(Request $request){
        $count = 0;
        $teams = Team::get();
        $data = [];
        $moreUsers='';

        foreach ($teams as $key => $team) {

           $subteams = User::where('team_id', $team->id)->where('department_id', 14)->count();
                // if ($subteams == 0 || $subteams == null) {
                //     continue;
                // }
                $subteams = DB::select(" SELECT DISTINCT(sub_team_id) FROM users WHERE team_id = $team->id AND department_id = 14 ");
            // $subteams =User::where('team_id', $team->id)->where('department_id', 14)->distinct("sub_team_id");
            // dd($subteams);
            $data[$key]['teams'] = $team;

            foreach ($subteams as $sub_key => $subteam) {
                if ($subteam->sub_team_id == 0) {
                    continue;
                }
              
                $users = User::where('sub_team_id', $subteam->sub_team_id)
                ->where('team_id', $team->id)->where('department_id', 14)
                ->paginate(10);
                // ->get();
          
                $data[$key]['subteams'][$sub_key]['sub'] = User::where('department_id', 14)->find($subteam->sub_team_id);

                if (empty($data[$key]['subteams'][$sub_key]['sub'])) {
                    $data[$key]['subteams'][$sub_key]['sub'] = User::where('department_id', 14)->where('team_id', $team->id)->where('sub_team_id', $subteam->sub_team_id)->first();
                }
                $data[$key]['subteams'][$sub_key]['users'] = $users;
               
                
                // $data[$key]['subteams'][$sub_key]['users']->roles = $users->role();
                // $count += count($users);

                

       //dd($users); 

        //dd([$data, $count]);

        //  $moreUsers = '';
        // if ($request->ajax()) {

        //     foreach($users as $user) {
                
        //         $moreUsers.= '<tr>
        //         <td><i class="fas fa-minus"></i></td>
        //         <td>' . $user->code . '</td>
        //         <td>' . $user->name_th . '</td>
        //         <td></td>
        //         <td>
        //             <ul class="m-auto p-0 list-unstyled">
        //                 <li class="dropdown action-menu">
        //                     <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown">
        //                         <i class="fas fa-ellipsis-h pointer-cursor"></i>
        //                     </a>
        //                     <div class="dropdown-menu dropdown-menu-right">
        //                         <a href="" class="dropdown-item">Edit</a>


        //                         <div class="dropdown-divider"></div>



        //                     </div>
        //                 </li>
        //             </ul>

        //         </td>
        //     </tr>
        //    ';
        //     }
        //     $moreUsers.=' <tr class="auto-load">
        //     <td colspan="5"><div class="bg-danger color-palette text-center py-2 text-sm text-while">กด โหลดข้อมูลเพิ่มเติม..</div></td>

        //     </tr>';
        //     return $moreUsers;

        // }
            }
        }

         return view('users2')->withAgents($data)->withCount($count);
        //return view('users');

    }

    public function load_data(Request $request){

        if($request->ajax())
            {
                if($request->id > 0)
                {
                $data = User::where('id', '<', $request->id)
                    ->orderBy('id', 'ASC')
                    ->limit(10);
                    // ->paginate(10);
                }
                else
                {
                $data = User::orderBy('id', 'ASC')
                    ->limit(10);
                    
                }
                $output = '';
                $last_id = '';

                if(!$data->isEmpty())
                {
                foreach($data as $row)
                {
                    $output .= '
                    <li><b>'.$row->name_th.'</b></li>
                    ';
                    $last_id = $row->id;
                }
                $output .= '
                <div id="load_more">
                    <button type="button" name="load_more_button" class="btn btn-success form-control" data-id="'.$last_id.'" id="load_more_button">Load More</button>
                </div>
                ';
                }
                else
                {
                $output .= '
                <div id="load_more">
                    <button type="button" name="load_more_button" class="btn btn-info form-control">No Data Found</button>
                </div>
                ';
                }
                echo $output;
            }
    }



}
