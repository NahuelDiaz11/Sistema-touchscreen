<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'profile'
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
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public static function rules($id)
    {
        if($id<=0){
            return[
                'name' => 'required|min:3|max:50|string|unique:users',
                'email'=> 'required|email|unique:users',

                'profile'=>'required|not_in:eleger'
            ];
        }else{
            return[
                'name' => "required|min:3|max:50|string|unique:users,name,{$id}",
                'email'=> "required|email|unique:users,email,{$id}",

                'profile'=>'required|not_in:eleger'
            ];
        }
    }

    public static $messages =[
        'name.required' => 'Nombre requerido',
        'name.min' => 'El nombre debe tener al menos 3 caracteres',
        'name.max' => 'EL nombre puede tener maximo 50 caracteres',
        'name.unique' => 'El nombre ya existe',
        'email.required' => 'Email requerido',
        'email.email' => 'El email es invalido',
        'password.required' => 'Contraseña requerida',
        'password.min' => 'La Contraseña debe tener al menos 3 caracteres',
        'profile.required' => 'Perfil requerido',
        'profile.not_in' => 'Selecciona un perfil valido'

    ];

    public function image()
    {
        //falta logica de avatars

        return $this->morphOne(Image::class, 'model')->withDefault();
    }

    //accesores y mutadores
    //obtenemos avatares
    public function getAvatarAttribute()
    {
        $img=$this->image->file;
        if($img !=null){
            if(file_exists('storage/avatars/'.$img))
            return 'storage/avatars'.$img;
            else
            return 'storage/default_avatar.png/';
        }

        return 'storage/default_avatar.png';
    }

    //relaciones
    public function sales()
    {
        return $this->hasMany(Order::class);
    }
}
