<?php

namespace App\Http\Controllers\users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Board;
use DB;

class MyBoardController extends Controller
{

    function createBoard($directId){

        $totalUsers = Board::count();

        $userId     = $totalUsers + 1;
        $directId   = $param1;

        $isUsrExist = Board::where('user_id',$userId)->count();

        if($isUsrExist === 0) {

            $isRefExist = Board::where('user_id',$directId)->count();

            if($isRefExist > 0) {

                $array = array('user_id' => $userId, 'directId' => $directId, 'current_board' => 1);

                $insert = Board::insert($array);

                if($insert) {

                    $directCount = Board::where('user_id', $directId)->increment('direct_count', 1);

                    if($directCount) {

                        self::updateBoard($userId, 0, $userId);

                        echo 'Insert successfully.'; exit;

                    } else {

                        echo 'Insert failed'; exit;
                    }

                } else {

                    echo 'Insert failed'; exit;
                }

            } else {

                echo 'Invalid Direct Id'; exit;
            }

        } else {

            echo 'Already Exist'; exit;
        }
    }







}
