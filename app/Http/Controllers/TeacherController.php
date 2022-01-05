<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use PDOException;

class TeacherController extends Controller
{
    public function login(Request $request){
        $validator = \Validator::make($request->all(), [
            'phone' => 'required|exists:users,phone',
            'password' => 'required',
        ]);
    
        $responseArr=array();
        if ($validator->fails()) {
            $responseArr['status']=false;
            $responseArr['data']=[];
            $responseArr['message'] = $validator->messages()->first();
            $responseArr['is_valid']=0;
            $responseArr['token'] = '';
            return response()->json($responseArr,Response::HTTP_BAD_REQUEST);
        }

        $user=User::where('phone',$request->phone)->get()->first();

        if (Hash::check($request->password, $user->password)){
            $responseArr['status']=true;
            $responseArr['data']=$user;
            $responseArr['message'] = '¡El usuario se ha logeado correctamente!';
            $responseArr['is_valid']=1;
            $responseArr['token'] = $user->createToken('myapptoken',['teacher'])->plainTextToken;
            return response()->json($responseArr,Response::HTTP_OK);
        }

        $responseArr['status']=false;
        $responseArr['data']=[];
        $responseArr['message'] = '¡La contraseña es incorrecta!';
        $responseArr['is_valid']=0;
        $responseArr['token'] = '';
        return response()->json($responseArr,Response::HTTP_UNAUTHORIZED);
    }

    public function signup(Request $request){
        $validator = \Validator::make($request->all(), [
            'name' => ['required','string','max:50'],
            //'email' => 'required|email|string|unique:users,email',
            'password' => 'required|min:8|same:password_confirm',
            'password_confirm'=>'required',
            'phone'=>['required','min:8','max:8','unique:users,phone']
        ]);
    
        $responseArr=array();
        if ($validator->fails()) {
            $responseArr['status']=false;
            $responseArr['data']=[];
            $responseArr['message'] = $validator->messages()->first();
            $responseArr['is_valid']=0;
            $responseArr['token'] = '';
            return response()->json($responseArr,Response::HTTP_BAD_REQUEST);
        }

        $data=[
            'name'=>$request->name,
            //'email'=>$request->email,
            'password'=>Hash::make($request->password),
            
            'phone'=>$request->phone,
        
            'student'=>false,
            'teacher'=>true,

            'image'=>'',
            'qr_code'=>'',
            'price'=>0,
            'about'=>'',

            'university_id'=>null,
            
            'end_subscription'=>null
        ];

        $user=User::create($data);

        $responseArr['status']=true;
        $responseArr['data']=$user;
        $responseArr['message'] = '¡El usuario se ha registrado correctamente!';
        $responseArr['is_valid']=1;
        $responseArr['token'] = $user->createToken('myapptoken',['teacher'])->plainTextToken;
        return response()->json($responseArr,Response::HTTP_OK);
    }

    public function logout(Request $request){
        auth()->user()->currentAccessToken()->delete();

        $responseArr=array();
        $responseArr['status']=true;
        $responseArr['data']=[];
        $responseArr['message'] = '¡El usuario ha cerrado sesion correctamente!';
        $responseArr['is_valid']=1;
        $responseArr['token'] = '';
        return response()->json($responseArr,Response::HTTP_OK);
    }


    public function logoutAll(Request $request){
        auth()->user()->tokens()->delete();

        $responseArr=array();
        $responseArr['status']=true;
        $responseArr['data']=[];
        $responseArr['message'] = '¡El usuario ha cerrado sesion correctamente en todas sus cuentas!';
        $responseArr['is_valid']=1;
        $responseArr['token'] = '';
        return response()->json($responseArr,Response::HTTP_OK);
    }

    public function updateImage(Request $request){
        $validator = \Validator::make($request->all(), [
            'image' => ['required','mimes:jpeg,png,jpg,gif,svg','max:2048'],
        ]);

        $responseArr=array();
        if ($validator->fails()) {
            $responseArr['status']=false;
            $responseArr['data']=[];
            $responseArr['message'] = $validator->messages()->first();
            $responseArr['is_valid']=0;
            $responseArr['token'] = '';
            return response()->json($responseArr,Response::HTTP_BAD_REQUEST);
        }

        $user = User::find(auth()->user()->id);
        
        $data=[];
        if ($request->hasFile('image')) {
            if (!is_null($user->image)){
                Storage::disk('public')->delete($user->image);
            }
            $data['image'] = Storage::disk('public')->put('teachers', $request->image);
        }

        try {
            $user->update([
                'image'=>$data['image'],
            ]);
        } catch (PDOException $e) {
            Storage::disk('public')->delete($data['image']);

            $responseArr['status']=false;
            $responseArr['data']=[];
            $responseArr['message'] ='Error al subir la imagen';
            $responseArr['is_valid']=0;
            $responseArr['token'] = '';
            return response()->json($responseArr,Response::HTTP_BAD_REQUEST);
        }

        $responseArr['status']=true;
        $responseArr['data']=$user;
        $responseArr['message'] = '¡El usuario ha cerrado sesion correctamente en todas sus cuentas!';
        $responseArr['is_valid']=1;
        $responseArr['token'] = '';
        return response()->json($responseArr,Response::HTTP_OK);
    }


    public function update(Request $request){
        $validator = \Validator::make($request->all(), [
            'name' => ['required','string','max:50'],
            'about' => ['required','string','max:2000'],
            'price' => ['required','string','max:4'],
        ]);

        $responseArr=array();
        if ($validator->fails()) {
            $responseArr['status']=false;
            $responseArr['data']=[];
            $responseArr['message'] = $validator->messages()->first();
            $responseArr['is_valid']=0;
            $responseArr['token'] = '';
            return response()->json($responseArr,Response::HTTP_BAD_REQUEST);
        }

        $user = User::find(auth()->user()->id);
        
        $data=[
            'name'=>$request->name,
            'about'=>$request->about,
            'price'=>$request->price
        ];


        try {
            $user->update($data);
        } catch (PDOException $e) {
            $responseArr['status']=false;
            $responseArr['data']=[];
            $responseArr['message'] ='Error al subir la imagen';
            $responseArr['is_valid']=0;
            $responseArr['token'] = '';
            return response()->json($responseArr,Response::HTTP_BAD_REQUEST);
        }

        $responseArr['status']=true;
        $responseArr['data']=$user;
        $responseArr['message'] = 'Datos actualizados correctamente';
        $responseArr['is_valid']=1;
        $responseArr['token'] = '';
        return response()->json($responseArr,Response::HTTP_OK);
    }

    public function updatePassword(Request $request){
        $validator = \Validator::make($request->all(), [
            'password' => ['required'],
            'new_password' => ['required','min:8','same:password_confirm'],
            'password_confirm'=>['required'],
        ]);

        $responseArr=array();
        if ($validator->fails()) {
            $responseArr['status']=false;
            $responseArr['data']=[];
            $responseArr['message'] = $validator->messages()->first();
            $responseArr['is_valid']=0;
            $responseArr['token'] = '';
            return response()->json($responseArr,Response::HTTP_BAD_REQUEST);
        }

        $user = User::find(auth()->user()->id);

        if (!Hash::check($request->password,$user->password)){
            $responseArr['status']=false;
            $responseArr['data']=[];
            $responseArr['message'] ='Error contrasena incorrecta';
            $responseArr['is_valid']=0;
            $responseArr['token'] = '';
            return response()->json($responseArr,Response::HTTP_BAD_REQUEST);
        }

        $data=[
            'password'=>Hash::make($request->new_password),
        ];


        try {
            $user->update($data);
        } catch (PDOException $e) {
            $responseArr['status']=false;
            $responseArr['data']=[];
            $responseArr['message'] ='Error al actualizar la clave';
            $responseArr['is_valid']=0;
            $responseArr['token'] = '';
            return response()->json($responseArr,Response::HTTP_BAD_REQUEST);
        }

        $responseArr['status']=true;
        $responseArr['data']=$user;
        $responseArr['message'] = 'Datos actualizados correctamente';
        $responseArr['is_valid']=1;
        $responseArr['token'] = '';
        return response()->json($responseArr,Response::HTTP_OK);
    }
}
