<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use App\Models\Common;
use App\Models\UserRole;
use Exception;
use Carbon\Carbon;
use App\Mail\AccountCreatedMail;
use Illuminate\Support\Facades\Mail;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'full_name',
        'email',
        'gender',
        'password',
        'phone_number',
        'image',
        'address',
        'role_id'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function role()
    {
        return $this->belongsTo(Role::class,'role_id');

    }

    public function userRole()
    {
        return $this->hasMany(UserRole::class,'user_id');
    }

    public static function saveData($post)
    {
        try {
            // Check for unique email
            $emailExists = User::where('email', $post['email'])
                ->where('status', 'Y')
                ->where('id', '!=', $post['id'] ?? null)
                ->exists();
            // if ($emailExists) {
            //     throw new Exception("The email address has already been taken.", 1);
            // }
    
            // Check for unique phone number
            $phoneExists = User::where('phone_number', $post['mobile_number'])
                ->where('status', 'Y')
                ->where('id', '!=', $post['id'] ?? null)
                ->exists();
            // if ($phoneExists) {
            //     throw new Exception("The mobile number has already been taken.", 1);
            // }
            if($emailExists && $phoneExists){
                throw new Exception("The email address and the mobile number has already been taken");
            }else if($emailExists){
                throw new Exception("The email address has already been taken.", 1);
            }else if($phoneExists){
                throw new Exception("The mobile number has already been taken.", 1);
            }
    
            $password = Str::random(8);
            $dataArray = [
                'full_name' => $post['name'],
                'gender' => $post['gender'],
                'email' => $post['email'],
                'password' => Hash::make($password),
                'phone_number' => $post['mobile_number'],
                'address' => $post['address'],
                'role_id' => $post['role']
            ];
            $dataArray = filterData($dataArray);

            $update = [
                'full_name' => $post['name'],
                'gender' => $post['gender'],
                'email' => $post['email'],
                'phone_number' => $post['mobile_number'],
                'address' => $post['address'],
                'role_id' => $post['role']
            ];
            $update = filterData($update);

            if (!empty($post['image'])) {
                $fileName = Common::uploadFile('user-account', $post['image']);
                if (!$fileName) {
                    return false;
                }
                $dataArray['image'] = $fileName;
            }
    
            if (!empty($post['id'])) {
                $dataArray['updated_at'] = Carbon::now();
                $user = User::where('id', $post['id'])->first();
                if ($user) {
                    $user->update($update);
                } else {
                    throw new Exception("User not found", 1);
                }
            } else {
                $user = User::create($dataArray);
                Mail::to($post['email'])->send(new AccountCreatedMail($password, $post));
            }
    
            return $user;
        } catch (Exception $e) {
            throw $e;
        }
    }
    

public static function list($post)
{
    try {
        $get =$post;
        foreach($get['columns'] as $key=>$value){
            $get['columns'][$key]['search']['value']=trim(strtolower(htmlspecialchars($value['search']['value'],ENT_QUOTES)));
        }
        $cond = "status = 'Y'";
        if(!empty($post['type']&&$post['type']==='trashed')){
            $cond = "status = 'N'";
        }
        if ($get['columns'][1]['search']['value'])
            $cond .=" and lower(name) like '%" . $get['columns'][1]['search']['value'] . "%'";
        if ($get['columns'][2]['search']['value'])
            $cond .=" and lower(email) like '%" . $get['columns'][2]['search']['value'] . "%'";
        $limit = 15;
        $offset = 0;
        if (!empty($get["length"]) && $get["length"]) {
            $limit = $get['length'];
            $offset = $get["start"];
        }
        $query = User::selectRaw("(SELECT count(*) from users) As totalrecs,id,full_name,email,phone_number,address,gender,image")->whereRaw($cond)->whereHas('userrole.role',function($query){
            $query->where('role','=','Admin');
        })->with('userrole.role');
        if($limit>-1){
            $result =$query->orderBy('id','desc')->offset($offset)->limit($limit)->get();
        }else{
            $result = $query->orderBy('id','desc')->get();
        }
        if($result){
            $ndata = $result;
            $ndata['totalrecs']=@$result[0]->totalrecs ? $result[0]->totalrecs : 0;
            $ndata['totalfilteredrecs'] = @$result[0]->totalrecs ? $result[0]->totalrecs : 0;
        }else{
            $ndata = array();
        }
        return $ndata;        
    } catch (Exception $e) {
        throw $e;
    }
}

public static function deleteData($post){
    try {
        if($post['type']==='trashed'){
            $filepath = storage_path('app/public/user-account');
            $userAccount = User::where('id',$post['id'])->first();
            if(!empty($userAccount->image)){
                $previousImagePath = $filepath . $userAccount->image;
                if(file_exists($previousImagePath)){
                    unlink($previousImagePath);
                }
            }
            if(!DB::table('user_roles')->where('user_id',$post['id'])->delete()){
                throw new Exception("Couldn't Delete data ");
            }
            if(!$userAccount->delete()){
                throw new Exception("Couldn't Delete Data. Please try again",1);
            }
        }else{
            if(!User::where(['id'=>$post['id']])->update(['status'=>'N','updated_at'=>Carbon::now()])){
                throw new Exception("Couldn't Delete Data. Please try again", 1);
            }
        }
        return true;
    } catch (Exception $e) {
        throw $e;
    }

}

public static function regenerateData($post){

    try{
        $updateArray = [
            'status'=>'y',
            'updated_at'=>Carbon::now(),
        ];
        if(!User::where(['id'=>$post['id']])->update($updateArray)){
            throw new Exception("Couldn't Regenerate Data. Please try again",1);

        }
        return true;
    }catch(Exception $e){
        throw $e;
    }
}

}
    