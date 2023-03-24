<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Movie_model;
use Illuminate\Http\Request;
use DB;
use Validator;

class MovieController extends Controller
{
    public function getList()
    {
        $datum = Movie_model::get()
            ->transform(function ($item) {
                $new_array = (object) [
                    "id" => $item->id,
                    "title" => $item->title,
                    "description" => $item->description,
                    "rating" => $item->rating,
                    "image" => $item->image ? $item->image : "",
                    "created_at" => date("Y-m-d H:i:s", strtotime($item->created_at)),
                    "updated_at" => date("Y-m-d H:i:s", strtotime($item->updated_at))
                ];

                return $new_array;
            })
            ->all();
        return response()->json($datum, 200);
    }

    public function getDetail($title)
    {
        if(!$title) return response()->json(["success"=> "false","error" => "Harap masukkan id"], 422);
        
        $data = Movie_model::whereRaw("title like '%".$title."%'")->first();
        if(!$data) return response()->json(["success"=> "false","error" => "Movie tidak ditemukan"], 422);

        $src = 'data:image/png;base64,'.$data->image;

        $detail = [
            "id" => $data->id,
            "title" => $data->title,
            "description" => $data->description,
            "rating" => $data->rating,
            "image" => $data->image ? '<img src="'.$src.'">' : "",
            "created_at" => date("Y-m-d H:i:s", strtotime($data->created_at)),
            "updated_at" => date("Y-m-d H:i:s", strtotime($data->updated_at))
        ];
        return response()->json([$detail], 200);
    }

    public function addMovie(Request $request){
        $validator = Validator::make($request->all(), [
            'id' => 'bail|required|integer|unique:movies,id',
            'title' => 'bail|required|max:100',
            'description' => 'bail|required|max:255',
            'rating' => 'bail|required|numeric|max:10',
            'created_at' => 'bail|required|date',
            'updated_at' => 'bail|date',
            'image' => 'max:50'
        ]);
        if ($validator->fails()) {
            return response()->json(["success"=> "false","error" => $validator->errors()->first()], 422);
        }
        try {
            DB::beginTransaction();
            $image="";
            if ($request->hasFile('image')) {
                $image = base64_encode(file_get_contents($request->file('image')));
            }
            $movie = new Movie_model;
            $movie->id = $request->input("id");
            $movie->title = $request->input("title");
            $movie->description = $request->input("description");
            $movie->rating = $request->input("rating");
            $movie->image = $image;
            $movie->created_at = $request->input("created_at");
            $movie->updated_at = $request->input("updated_at");
            $movie->save();
            
            $response = [
                'success' => true,
                'data_saved' => $movie
            ];
            DB::commit();

            return response()->json($response,200);
        }
        catch(\Exception $e) {
            DB::rollback();
            \Log::info($e);
            return response()->json(["success"=> "false","error" => "Insert gagal"], 422);
        }
    }

    public function updateMovie(Request $request,$id){
        $validator = Validator::make($request->all(), [
            'title' => 'bail|required|max:100',
            'description' => 'bail|required|max:255',
            'rating' => 'bail|required|numeric|max:10',
            'created_at' => 'bail|required|date',
            'updated_at' => 'bail|date',
        ]);
        if ($validator->fails()) {
            return response()->json(["success"=> "false","error" => $validator->errors()->first()], 422);
        }
        
        if(!$id) return response()->json(["success"=> "false","error" => "Harap masukkan id"], 422);
        
        $movie = Movie_model::where("id",$id)->first();
        if(!$movie) return response()->json(["success"=> "false","error" => "Movie tidak ditemukan"], 422);

        try {
            DB::beginTransaction();

            $movie->title = $request->input("title");
            $movie->description = $request->input("description");
            $movie->rating = $request->input("rating");
            $movie->created_at = $request->input("created_at");
            $movie->updated_at = $request->input("updated_at");
            $movie->save();
            
            $response = [
                'success' => true,
                'data_saved' =>$movie
            ];
            DB::commit();

            return response()->json($response,200);
        }
        catch(\Exception $e) {
            DB::rollback();
            \Log::info($e);
            return response()->json(["success"=> "false","error" => "Update gagal"], 422);
        }
    }

    public function deleteMovie($id){
        if(!$id) return response()->json(["success"=> "false","error" => "Harap masukkan id"], 422);
        $movie=Movie_model::find($id);
        if(!$movie) return response()->json(["success"=> "false","error" => "Movie tidak ditemukan"], 422);

        try {
            DB::beginTransaction();

            $movie->delete();
            
            $response = [
                'success' => true,
                'deleted_id' =>$id
            ];

            DB::commit(); 
            return response()->json($response,200);

        }
        catch(\Exception $e) {
            DB::rollback();
            \Log::info($e);
            return response()->json(["success"=> "false","error" => "Delete gagal"], 422);
        }
    }
}
