<?php

namespace App\Http\Controllers;

use App\Passenger;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
class SearchController extends Controller
{
    public function index(){
        $passengers = Passenger::get();
        $columns = DB::getSchemaBuilder()->getColumnListing('passengers');
        //dd($columns);
        $field_val_arr = array();
        return view('welcome')->with('passengers', $passengers)
                              ->with('columns',$columns)
                              ->with('field_val_arr',$field_val_arr);
    }

    public function search($field_name,$field_val){
       $columns = DB::getSchemaBuilder()->getColumnListing('passengers');
       if($field_name == 'id'||$field_name == 'remarks'||$field_name == 'customer_id'||$field_name == 'campaign_id'||$field_name=='contact_no'||$field_name=='dropoff'||$field_name=='pickup'){
          $passengers = Passenger::where($field_name,$field_val)->get();
       }else if($field_name == 'name' || $field_name == 'email'){
           $passengers = Passenger::where($field_name, 'LIKE', '%' . $field_val . '%')->get();
       }else if($field_name == 'created_at'){
         
          $field_val_arr = explode('-', $field_val);
          if($field_val_arr[0] == 'current'){
             if($field_val_arr[1] == 'day'){
              $passengers = Passenger::
                            where('created_at', Carbon::now())->get();
             }else if($field_val_arr[1] == 'week'){
              $passengers = Passenger::
                                 where('created_at', '>', Carbon::now()->startOfWeek())
                                 ->where('created_at', '<', Carbon::now()->endOfWeek())
                                 ->get();
             }else if($field_val_arr[1] == 'month'){
              $currentMonth = date('m');
              $passengers = Passenger::whereRaw('MONTH(created_at) = ?',[$currentMonth])
                            ->get();
             }else if($field_val_arr[1] == 'year'){
              $currentYear = date('Y');
              $passengers = Passenger::whereRaw('YEAR(created_at) = ?',[$currentYear])
                            ->get();
             }
          }else if($field_val_arr[0] == 'previous'){
             if($field_val_arr[1] == 'day'){
              $passengers = Passenger::
                            whereBetween('created_at', [Carbon::now()->subDays($field_val_arr[2]),Carbon::now()])
                            ->get();
             }
             else if($field_val_arr[1] == 'month'){
              $fromDate = Carbon::now()->subMonth($field_val_arr[2])->startOfMonth()->toDateString();
              $tillDate = Carbon::now()->subMonth(0)->endOfMonth()->toDateString();
              $passengers = Passenger::whereBetween('created_at', [$fromDate, $tillDate])
                            ->get();
              //dd($passengers);
             }
             else if($field_val_arr[1] == 'week'){
              $fromDate = Carbon::now()->subWeeks($field_val_arr[2])->startOfWeek()->toDateString();
              $tillDate = Carbon::now()->subWeeks(0)->endOfWeek()->toDateString();
              $passengers = Passenger::whereBetween('created_at', [$fromDate, $tillDate])
                            ->get();
              //dd($passengers);
             }
          }
          
           //dd($field_val_arr);
       }

       return view('welcome')
                  ->with('passengers', $passengers)
                  ->with('columns',$columns);

    }

    public function getData($data_field){
      $columns = DB::getSchemaBuilder()->getColumnListing('passengers');
      $field_val_arr = explode(',', $data_field);
      
      $query = Passenger::select('*');
      foreach($field_val_arr as $f_v_a){
         $f_v_arr = explode('-', $f_v_a);
         // dd($f_v_arr);
         //dd(Carbon::now()->toDateString());
         $field_name = $f_v_arr[0];
         $field_value_arr = array();
         for($i=1;$i<sizeof($f_v_arr);$i++){
             array_push($field_value_arr,$f_v_arr[$i]);
         }
         //dd($f_v_arr);
         $field_value = $f_v_arr[1];
         if($field_name == 'created_at' || $field_name == 'updated_at'){
            if($f_v_arr[1] == 'current'){
               if($f_v_arr[2] == 'day'){
                  $query->whereDate($field_name, Carbon::now());
                }
                else if($f_v_arr[2] == 'month'){
                   $query->whereMonth($field_name, Carbon::now()->month);
                }
                else if($f_v_arr[2] == 'week'){
                   $fromDate = Carbon::now()->startOfWeek();
                   $tillDate = Carbon::now()->endOfWeek();
                   $query->whereBetween($field_name, [$fromDate, $tillDate]);
                }

            }else if($f_v_arr[1] == 'previous'){
                  if($f_v_arr[3] == 'day'){
                    $query->whereBetween($field_name, [Carbon::now()->subDays($f_v_arr[2]),Carbon::now()]);
                  }
                  else if($f_v_arr[3] == 'month'){
                     $fromDate = Carbon::now()->subMonth($f_v_arr[2])->startOfMonth()->toDateString();
                     $tillDate = Carbon::now()->subMonth(0)->endOfMonth()->toDateString();
                     $query->whereBetween($field_name, [$fromDate, $tillDate]);
                  }
                  else if($f_v_arr[3] == 'week'){
                     $fromDate = Carbon::now()->subWeeks($f_v_arr[2])->startOfWeek()->toDateString();
                     $tillDate = Carbon::now()->subWeeks(0)->endOfWeek()->toDateString();
                     $query->whereBetween($field_name, [$fromDate, $tillDate]);
                  }
            }

         }
        
         else{
            $query->whereIn($field_name,$field_value_arr);
         }
        
        
      }
     
      return $passengers = $query->get();
      return view('welcome')->with('passengers',$passengers)
                           ->with('columns',$columns)
                           ->with('field_val_arr', $field_val_arr);
    }

    public function groupSearch($field_name,$field_val){
      $field_val_arr = explode('-', $field_val);
      if($field_val_arr[0] == 'previous'){
            if($field_val_arr[1] == 'day'){
              $passengers = Passenger::
                            whereBetween('created_at', [Carbon::now()->subDays($field_val_arr[2]),Carbon::now()])
                            ->get()->groupBy($field_val_arr[3])->toArray();

               dd($passengers);
             }
             else if($field_val_arr[1] == 'month'){
              $fromDate = Carbon::now()->subMonth($field_val_arr[2])->startOfMonth()->toDateString();
              $tillDate = Carbon::now()->subMonth(0)->endOfMonth()->toDateString();
              $passengers = Passenger::whereBetween('created_at', [$fromDate, $tillDate])
                            ->get()->groupBy($field_val_arr[3])->toArray();
              dd($passengers);
             }
             else if($field_val_arr[1] == 'week'){
              $fromDate = Carbon::now()->subWeeks($field_val_arr[2])->startOfWeek()->toDateString();
              $tillDate = Carbon::now()->subWeeks(0)->endOfWeek()->toDateString();
              $passengers = Passenger::whereBetween('created_at', [$fromDate, $tillDate])
                            ->get()->groupBy($field_val_arr[3])->toArray();
              dd($passengers);
             }
             
      }
      if($field_val_arr[0] == 'current'){
             if($field_val_arr[1] == 'day'){
              $passengers = Passenger::
                            where('created_at', Carbon::now())->get()->groupBy($field_val_arr[3])->toArray();
             }else if($field_val_arr[1] == 'week'){
              $passengers = Passenger::
                                 where('created_at', '>', Carbon::now()->startOfWeek())
                                 ->where('created_at', '<', Carbon::now()->endOfWeek())
                                 ->get()->groupBy($field_val_arr[3])->toArray();
             }else if($field_val_arr[1] == 'month'){
              $currentMonth = date('m');
              $passengers = Passenger::whereRaw('MONTH(created_at) = ?',[$currentMonth])
                            ->get()->groupBy($field_val_arr[3])->toArray();
             }else if($field_val_arr[1] == 'year'){
              $currentYear = date('Y');
              $passengers = Passenger::whereRaw('YEAR(created_at) = ?',[$currentYear])
                            ->get()->groupBy($field_val_arr[3])->toArray();
             }
      }
      dd($field_val_arr);
    }

    public function group(){
      $columns = DB::getSchemaBuilder()->getColumnListing('passengers');
      $passengers = Passenger::get();
      $field_val_arr = [];
      return view('group')->with('columns',$columns)
                          ->with('passengers',$passengers)
                          ->with('field_val_arr', $field_val_arr);
    }

    public function getAutocompleteData($item,$search){
      $data = Passenger::Where($item, 'like', '%' .$search. '%')->select($item)->distinct()->get();
      return response()->json($data);
    }

    public function groupData($data_field,$group_name){
          $columns = DB::getSchemaBuilder()->getColumnListing('passengers');
          $field_val_arr = array();
          if($data_field == 'none'){
            $raw_data = "year(".$group_name.")";
            $passengerData = DB::table("passengers")
                                ->select(DB::raw("COUNT(*) as total"),$group_name)
                                //->orderBy($group_name)
                                // ->groupBy(DB::raw($raw_data))
                                 ->groupBy($group_name)
                                ->get();
            //dd($passengerData);
            return $passengerData;
            return view('group_by')->with('data',$passengerData)
                                ->with('columns',$columns)
                                ->with('field_val_arr', $field_val_arr)
                                ->with('group_name',$group_name);
            
          }else{
              $columns = DB::getSchemaBuilder()->getColumnListing('passengers');
              $field_val_arr = explode(',', $data_field);
              //dd($field_val_arr);
              $query = Passenger::select($group_name,DB::raw("COUNT(*) as total"));
              foreach($field_val_arr as $f_v_a){
                 $f_v_arr = explode('-', $f_v_a);
                 // dd($f_v_arr);
                 //dd(Carbon::now()->toDateString());
                 $field_name = $f_v_arr[0];
                 $field_value_arr = array();
                 for($i=1;$i<sizeof($f_v_arr);$i++){
                     array_push($field_value_arr,$f_v_arr[$i]);
                 }
                 //dd($field_value_arr);
                 $field_value = $f_v_arr[1];
                 if($field_name == 'created_at' || $field_name == 'updated_at'){
                    if($f_v_arr[1] == 'current'){
                       if($f_v_arr[3] == 'day'){
                          $query->whereDate($field_name, Carbon::now());
                        }
                        else if($f_v_arr[3] == 'month'){
                           $query->whereMonth($field_name, Carbon::now()->month);
                        }
                        else if($f_v_arr[3] == 'week'){
                           $fromDate = Carbon::now()->startOfWeek();
                           $tillDate = Carbon::now()->endOfWeek();
                           $query->whereBetween($field_name, [$fromDate, $tillDate]);
                        }

                    }else if($f_v_arr[1] == 'previous'){
                          if($f_v_arr[3] == 'day'){
                            $query->whereBetween($field_name, [Carbon::now()->subDays($f_v_arr[2]),Carbon::now()]);
                          }
                          else if($f_v_arr[3] == 'month'){
                             $fromDate = Carbon::now()->subMonth($f_v_arr[2])->startOfMonth()->toDateString();
                             $tillDate = Carbon::now()->subMonth(0)->endOfMonth()->toDateString();
                             $query->whereBetween($field_name, [$fromDate, $tillDate]);
                          }
                          else if($f_v_arr[3] == 'week'){
                             $fromDate = Carbon::now()->subWeeks($f_v_arr[2])->startOfWeek()->toDateString();
                             $tillDate = Carbon::now()->subWeeks(0)->endOfWeek()->toDateString();
                             $query->whereBetween($field_name, [$fromDate, $tillDate]);
                          }
                    }

                 }
                 
                 else{
                    $query->whereIn($field_name,$field_value_arr);
                 } 
              }
              $passengerData = $query->groupBy($group_name)->get();
              return $passengerData;
              return view('group_by')->with('data',$passengerData)
                                ->with('columns',$columns)
                                ->with('field_val_arr', $field_val_arr)
                                ->with('group_name',$group_name);
          }
    }


   //  public function getData($data_field){
   //    $columns = DB::getSchemaBuilder()->getColumnListing('passengers');
   //    $field_val_arr = explode(',', $data_field);
   //    //dd($field_val_arr);
   //    $query = Passenger::select('*');
   //    foreach($field_val_arr as $f_v_a){
   //       $f_v_arr = explode('-', $f_v_a);
   //       // dd($f_v_arr);
   //       //dd(Carbon::now()->toDateString());
   //       $field_name = $f_v_arr[0];
   //       $field_value_arr = array();
   //       for($i=1;$i<sizeof($f_v_arr)-1;$i++){
   //           array_push($field_value_arr,$f_v_arr[$i]);
   //       }
   //       //dd($field_value_arr);
   //       $field_value = $f_v_arr[1];
   //       if($field_name == 'created_at' || $field_name == 'updated_at'){
   //          if($f_v_arr[1] == 'current'){
   //             if($f_v_arr[3] == 'day'){
   //                $query->whereDate($field_name, Carbon::now());
   //              }
   //              else if($f_v_arr[3] == 'month'){
   //                 $query->whereMonth($field_name, Carbon::now()->month);
   //              }
   //              else if($f_v_arr[3] == 'week'){
   //                 $fromDate = Carbon::now()->startOfWeek();
   //                 $tillDate = Carbon::now()->endOfWeek();
   //                 $query->whereBetween($field_name, [$fromDate, $tillDate]);
   //              }

   //          }else if($f_v_arr[1] == 'previous'){
   //                if($f_v_arr[3] == 'day'){
   //                  $query->whereBetween($field_name, [Carbon::now()->subDays($f_v_arr[2]),Carbon::now()]);
   //                }
   //                else if($f_v_arr[3] == 'month'){
   //                   $fromDate = Carbon::now()->subMonth($f_v_arr[2])->startOfMonth()->toDateString();
   //                   $tillDate = Carbon::now()->subMonth(0)->endOfMonth()->toDateString();
   //                   $query->whereBetween($field_name, [$fromDate, $tillDate]);
   //                }
   //                else if($f_v_arr[3] == 'week'){
   //                   $fromDate = Carbon::now()->subWeeks($f_v_arr[2])->startOfWeek()->toDateString();
   //                   $tillDate = Carbon::now()->subWeeks(0)->endOfWeek()->toDateString();
   //                   $query->whereBetween($field_name, [$fromDate, $tillDate]);
   //                }
   //          }

   //       }
        
   //       else{
   //          $query->whereIn($field_name,$field_value_arr);
   //       }
        
        
   //    }
     
   //    $passengers = $query->get();
   //    return view('group')->with('passengers',$passengers)
   //                         ->with('columns',$columns)
   //                         ->with('field_val_arr', $field_val_arr);
   //  }
}
