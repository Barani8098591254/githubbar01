<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\UserAddress;


class UserModel extends Authenticatable{


   public static function createAddress($currency,$userId,$network){

         $userModel = new UserModel();

        $checkUseradd = UserAddress::where('currency',$currency)->where('user_id',$userId);


            if($checkUseradd->count() == 0){


                $userAdd = $checkUseradd->first();
                if($currency == 'TRX'){
                    if($_SERVER['HTTP_HOST'] == 'localhost'){
                        $response = shell_exec('cd ' . public_path() . '/VigzHGZEQcGcETwKyAKu/TRX; node tron.js createAddress');
                    }else{
                        $response = shell_exec('cd ' . public_path() . '/VigzHGZEQcGcETwKyAKu/TRX; node tron.js createAddress');
                    }

                    $res = json_decode($response);

                    if($res->address){
                        $address = $res->address->base58;
                        $hex = encrypt_decrypt('encrypt',$res->address->hex);
                        $key = encrypt_decrypt('encrypt',$res->privateKey);

                        $userModel->insertAddress($userId,strtolower($address),$currency,'','',encrypt_decrypt('encrypt',$key),encrypt_decrypt('encrypt',$hex));
                    }
                }else if($currency == 'ETH'){

                    if($_SERVER['HTTP_HOST'] == 'localhost'){
                        $response = shell_exec('cd ' . public_path() . '/VigzHGZEQcGcETwKyAKu/ETH; node eth_create_address.js');
                    }else{
                        $response = shell_exec('cd ' . public_path() . '/VigzHGZEQcGcETwKyAKu/ETH; node eth_create_address.js');
                    }

                    $res = json_decode($response);
                
                    if($res->address){
                        $address = $res->address;
                        $hex = encrypt_decrypt('encrypt',$res->address);
                        $key = encrypt_decrypt('encrypt',$res->privateKey);

                        $userModel->insertAddress($userId,strtolower($address),$currency,'','',encrypt_decrypt('encrypt',$key),'');
                    }
                }  
                

                $result = ['status' => 1,'address' => $address,'currency' => $currency,'tag' => ''];
                return $result; die;

            }else{
                $userAdd = $checkUseradd->first();
                $result = ['status' => 1,'address' => $userAdd->address,'currency' => $currency,'tag' => ($userAdd->tag) ? $userAdd->tag : ''];
                return $result;
            }

   }


   function insertAddress($userId,$address,$currency,$network,$tag='',$key='',$hex=''){

        $insertData = [
            'user_id' => $userId,
            'address' => $address,
            'currency' => $currency,
            'network' => $network,
            'tag' => $tag,
            'hex' => $hex,
            'key'      =>  $key,
            'created_at' => date('Y-m-d H:i:s')
        ];

        $insert = UserAddress::insert($insertData);

        if($insert){
            return true;
        }else{
            return '';
        }

   }


}



?>


