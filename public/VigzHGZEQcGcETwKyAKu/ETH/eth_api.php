<?php
header('Content-Type: application/json');

$ipAddr = $_SERVER['REMOTE_ADDR'];

function bchexdec($hex) {
  if (strlen($hex) == 1) {
    return hexdec($hex);
  } else {
    $remain = substr($hex, 0, -1);
    $last = substr($hex, -1);
    return bcadd(bcmul(16, bchexdec($remain)), hexdec($last));
  }
}



function bcdechex($dec) {
    $hex = '';
    do {    
        $last = bcmod($dec, 16);
        $hex = dechex($last).$hex;
        $dec = bcdiv(bcsub($dec, $last), 16);
    } while($dec>0);
    return $hex;
}

function get_gas($cur){
  if($cur == 'ETH'){
    return 260000000000;
  }else if($cur == 'OTHER'){
    return 260000000000;
  }
}

function get_limit($cur){
  if($cur == 'ETH'){
    
    return 60000;
  }else if($cur == 'OTHER'){
    
    return 60000;
  }
}

$rawData = file_get_contents("php://input");

if (isset($rawData)) {
  
  $json_data = json_decode($rawData, true);
  
  
  $method = @$json_data['method'];
  $keyword = @$json_data['keyword'];

  $url = 'http://35.167.239.165:8545';
  
  if (!isset($method)) {
    $response = array('type' => 'fail', 'result' => 'Invalid parameters');
  } else if (!isset($keyword)) {
    $response = array('type' => 'fail', 'result' => 'Invalid parameters');
  } else {
    
    if ($keyword != "Crovvaapi") {
      
      $response = array('type' => 'fail', 'result' => 'Invalid requests.');
      echo json_encode($response);
      exit;
    }

    if ($method == "createAddr") {

      $key = $json_data['data']['key'];
       
      if ($key != "") {

        $output = shell_exec('curl -H "Content-Type: application/json" -X POST --data \'{"jsonrpc":"2.0","method":"personal_newAccount","params":["' . $key . '"],"id":1}\' '.$url);
        $res = json_decode($output);
        $createAddress = $res->result;
        $response = array('type' => 'success', 'result' => $createAddress);
      } else {
        
        $response = array('type' => 'fail', 'result' => "Invalid key");
      }
    } else if ($method == "blockCount") {
      $output = shell_exec('curl -X POST -H "Content-Type: application/json" --data \'{"jsonrpc":"2.0","method":"eth_blockNumber","params":[],"id":83}\' '.$url);
      $res = json_decode($output);
      $count = bchexdec($res->result);
      $response = array('type' => 'success', 'result' => $count);
    }  else if($method == "peerCount") {
      $output = shell_exec('curl -X POST -H "Content-Type: application/json" --data \'{"jsonrpc":"2.0","method":"net_peerCount","params":[],"id":83}\' '.$url);
      $res  = json_decode($output);
      $count =  bchexdec($res->result); 
      $response = array('type'=>'success','result'=>$count);      
    } else if($method == "txpool_status") {
      $output = shell_exec('curl -X POST -H "Content-Type: application/json" --data \'{"jsonrpc":"2.0","method":"txpool_status","params":[],"id":83}\' '.$url);
      $res  = json_decode($output);
       
      $response = array('type'=>'success','result'=>$res);      
    } else if ($method == "accounts") {
      $output = shell_exec('curl -X POST -H "Content-Type: application/json" --data \'{"jsonrpc":"2.0","method":"eth_accounts","params":[],"id":1}\' '.$url);
      $res = json_decode($output,true);
      $response = array('type' => 'success', 'result' => $res);
    } else if ($method == "checkbalance") {
      $address = $json_data['data']['address'];
      $getBal = shell_exec('curl -X POST -H "Content-Type: application/json" --data \'{"jsonrpc":"2.0","method":"eth_getBalance","params":["' . $address . '", "latest"],"id":2}\' '.$url);
      $decodeBal = json_decode($getBal, true);
      $userBal = bchexdec($decodeBal['result']);
      $balance = $userBal / 1000000000000000000;
      $response = array('type' => 'success', 'result' => $balance);
    } 
    else if ($method == "tokencheckbalance") {
      $address      = $json_data['data']['address'];
      $contract     = $json_data['data']['contract'];
      $address      = "0x70a08231000000000000000000000000" . substr($address, 2);
      $getBal       = shell_exec('curl -X POST -H "Content-Type: application/json" --data \'{"jsonrpc":"2.0","method":"eth_call","params":[{"to":"' . $contract . '", "data":"' . $address . '"}, "latest"],"id":2}\' ' . $url);
      $decodeBal    = json_decode($getBal, true);
      $userBal      = bchexdec($decodeBal['result']);
      $response     = array('type' => 'success', 'result' => $userBal);
    } else if ($method == "withdraw") {

      
    } else if ($method == "getBlockTransactions") {
      
        $oldBlock = $json_data['data']['block'];
        $newBlock = $json_data['data']['new_block'];
        $transactions = array();

        $output = shell_exec('curl -X POST -H "Content-Type: application/json" --data \'{"jsonrpc":"2.0","method":"eth_blockNumber","params":[],"id":83}\' '.$url);
        $res = json_decode($output, true);
        
        $hexCount = $res['result'];
        $count = bchexdec($hexCount);

        if($newBlock!=''){
          $count = $newBlock;
        }else{
          /*Avoid unlimited calls*/
          if(($count - $oldBlock) > 30){
            $count = $oldBlock+30;
          }
        }

        $updatable_count = $oldBlock;

        for ($i = $oldBlock; $i <= $count; $i++) {
          
            $blockNum = '0x' . bcdechex($i);
          
          $ch = curl_init();
          curl_setopt($ch, CURLOPT_URL, $url);
          curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
          curl_setopt($ch, CURLOPT_POSTFIELDS, "{\"jsonrpc\":\"2.0\",\"method\":\"eth_getBlockByNumber\",\"params\":[\"" . trim($blockNum) . "\", true],\"id\":1}");
          curl_setopt($ch, CURLOPT_POST, 1);
          $headers = array();
          $headers[] = "Content-Type: application/json";
          curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
          $result = curl_exec($ch);
          if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
          }
          curl_close($ch);

          $decodeResult = json_decode($result, true);
          $transactions[] = $decodeResult['result']['transactions'];

          $updatable_count = $i;
        }
        
        $get_res = ['trans_result' => $transactions, 'block' => $updatable_count];
        $response = array('type' => 'success', 'result' => $get_res,'block' => $updatable_count);

      //  $response = array('type' => 'success', 'result' => $transactions, 'block' => $updatable_count);
        
       } else if ($method == "checkReceipt") {
        $hash = trim($json_data['data']['hash']);

        $output = shell_exec('curl -X POST -H "Content-Type: application/json" --data \'{"jsonrpc":"2.0","method":"eth_getTransactionReceipt","params":["' . $hash . '"],"id":1}\' '.$url);
        $res = json_decode($output, true);

        if (!isset($res['error'])) {
          $receipt = $res['result'];
          if (!empty($receipt)) {
            $response = array('type' => 'success', 'result' => $receipt);
          } else {
            $response = array('type' => 'fail', 'result' => "Invalid txid");
          }
        } else {
          $response = array('type' => 'fail', 'result' => "Invalid txid");
        }
    }
    else if ($method == "moveFundsToAdmin") {
      $key = $json_data['data']['key'];
      $adminAddr = $json_data['data']['to'];
      $userAddr = $json_data['data']['from'];

      $gasPrice = $json_data['data']['gas_price'];
     

      $gasLimit = $json_data['data']['gas_limit'];
      

      $getBal = shell_exec('curl -X POST -H "Content-Type: application/json" --data \'{"jsonrpc":"2.0","method":"eth_getBalance","params":["' . $userAddr . '", "latest"],"id":2}\' ' . $url);
      $decodeBal = json_decode($getBal, true);

      if(!isset($decodeBal['error']))
      {

        $userBal = bchexdec($decodeBal['result']);
        
        $fee = bcmul($gasPrice, $gasLimit);

        if ($getBal && $userBal > $fee) {
          $balance = $userBal / 1000000000000000000;
          
        $transAmount = bcsub($userBal, $fee);
        $gasPrice = '0x' . bcdechex($gasPrice);
        $gasLimit = '0x' . bcdechex($gasLimit);
        $amount = '0x' . bcdechex($transAmount);


        $unlockAddr = shell_exec('curl -X POST -H "Content-Type: application/json" --data \'{"jsonrpc":"2.0","method":"personal_unlockAccount","params":["' . $userAddr . '","' . $key . '",null],"id":1}\' ' . $url);
        $unlockRes = json_decode($unlockAddr, true);

        if (!isset($unlockRes['error'])) {
          $unlockEth = $unlockRes['result'];
          if ($unlockEth == 1 || $unlockEth == "true" || $unlockEth == true) {


            $get_p = shell_exec('curl -X POST -H "Content-Type: application/json" --data \'{"jsonrpc":"2.0","method":"net_peerCount","params":[],"id":83}\' '.$url);
            $get_peer  = json_decode($get_p, true);
            if(!isset($get_peer['error'])){
              $count =  bchexdec($get_peer['result']); 

              if($count > 2){

                $output = shell_exec('curl -X POST -H "Content-Type: application/json" --data \'{"jsonrpc":"2.0","method":"eth_sendTransaction","params":[{"from":"' . $userAddr . '","to":"' . $adminAddr . '","gas":"' . $gasLimit . '","gasPrice":"' . $gasPrice . '","value":"' . $amount . '"}],"id":22}\' ' . $url);

                $result = json_decode($output, true);
                if (!isset($result['error'])) {
                  $res = $result['result'];
                  if ($res == '' || $res == null) {
                    $response = array('type' => 'fail', 'result' => "Failed to transfer ETH.");
                  } else {
                    $response = array('type' => 'success', 'result' => $res);
                  }
                } else {
                  $response = array('type' => 'fail', 'result' => $result['error']['message']);
                }

              }else{
                $response = array('type' => 'error', 'result' => 'Please wait for peercount to reach 3');
              }

            }
            else{
              $response = array('type' => 'error', 'result' => $get_peer['error']['message']);
            }


          } else {
            $response = array('type' => 'fail', 'result' => "Invalid passsword!");
          }
        } else {
          $response = array('type' => 'fail', 'result' => $get_peer['error']['message'], 'in_unlock' => 1);
        }
      } else {
        $response = array('type' => 'fail', 'result' => "Low balance or coudnt get balance", 'dt' => $userBal, 'move_admin' => 1);
      }

    }
    else{
      $response = array('type' => 'error', 'result' => $decodeBal['error']['message']);
    }

  }

    else if ($method == "move_eth") {
      $key = $json_data['data']['key'];
      $adminAddr = $json_data['data']['to'];
      $userAddr = $json_data['data']['from'];
      $gas_price = $json_data['data']['gas_price'];


      $getBal = shell_exec('curl -X POST -H "Content-Type: application/json" --data \'{"jsonrpc":"2.0","method":"eth_getBalance","params":["' . $userAddr . '", "latest"],"id":2}\' ' . $url);
      $decodeBal = json_decode($getBal, true);

      if(!isset($decodeBal['error']))
      {

      $userBal = bchexdec($decodeBal['result']);
      if ($getBal && $userBal > 6100000000000000) {
        $balance = $userBal / 1000000000000000000;
        $gasPrice = 11000000000;
        $gasLimit = 22000;
        $fee = bcmul($gasPrice, $gasLimit);
        $transAmount = bcsub($userBal, $fee);
        $gasPrice = '0x' . bcdechex($gasPrice);
        $gasLimit = '0x' . bcdechex($gasLimit);
        $amount = '0x' . bcdechex($transAmount);

        $unlockAddr = shell_exec('curl -X POST -H "Content-Type: application/json" --data \'{"jsonrpc":"2.0","method":"personal_unlockAccount","params":["' . $userAddr . '","' . $key . '",null],"id":1}\' ' . $url);
        $unlockRes = json_decode($unlockAddr, true);

        if (!isset($unlockRes['error'])) {
          $unlockEth = $unlockRes['result'];
          if ($unlockEth == 1 || $unlockEth == "true" || $unlockEth == true) {


            $non = shell_exec('curl -X POST -H "Content-Type: application/json" --data \'{"jsonrpc":"2.0","method":"eth_getTransactionCount","params":["' . $userAddr . '", "latest"],"id":1}\'  ' . $url);
            $nonc = json_decode($non, true);
            
            if(!isset($nonc['error'])){
              $nonce = trim($nonc['result']);
              $nonce = '"' . $nonce . '"';


            $output = shell_exec('curl -X POST -H "Content-Type: application/json" --data \'{"jsonrpc":"2.0","method":"eth_sendTransaction","params":[{"from":"' . $userAddr . '","to":"' . $adminAddr . '","gas":"' . $gasLimit . '","gasPrice":"' . $gasPrice . '","value":"' . $amount . '","nonce":'.$nonce.'}],"id":22}\' ' . $url);
          
            $result = json_decode($output, true);
            if (!isset($result['error'])) {
              $res = $result['result'];
              if ($res == '' || $res == null) {
                $response = array('type' => 'fail', 'result' => "Failed to transfer ETH.");
              } else {
                $response = array('type' => 'success', 'result' => $res);
              }
            } else {
              $response = array('type' => 'fail', 'result' => $result['error']['message']);
            }
          
            }
           else{
            $response = array('type' => 'error', 'result' => $nonc['error']['message']);
           }


          } else {
            $response = array('type' => 'fail', 'result' => "Invalid passsword!");
          }
        } else {
          $response = array('type' => 'fail', 'result' => $unlockRes['error']['message']);
        }
      } else {
        $response = array('type' => 'fail', 'result' => "Low balance or coudnt get balance", 'dt' => $userBal);
      }

      }
     else{
      $response = array('type' => 'error', 'result' => $decodeBal['error']['message']);
     }

    }
  
    else if ($method == "token_transfer") {

      $key = $json_data['data']['key'];       
      $fromaddress = strtolower($json_data['data']['from']);
      $touseraddress = strtolower($json_data['data']['to']);
      $contract_address = strtolower($json_data['data']['contract']);

      $amount = trim($json_data['data']['amount']);
      $devide_val =  $json_data['data']['devide_val'];


      $gasPrice = get_gas('OTHER');
      $gasLimit = get_limit('OTHER');

      $gasLimit = '0x' . dechex($gasLimit);
      $gasLimit = '"' . trim($gasLimit) . '"';

      $gasPrice = '0x' . dechex($gasPrice);
      $gasPrice = '"' . trim($gasPrice) . '"';

      $amount = bcmul($amount, $devide_val);

      $amount = bcdechex($amount);
      $amount = str_pad($amount, 64, '0', STR_PAD_LEFT);
      $touseraddress = substr($touseraddress, 2);
      $input = '0xa9059cbb000000000000000000000000' . $touseraddress . $amount;
      $input = '"' . trim($input) . '"';
      $fromaddress = '"' . trim($fromaddress) . '"';

      $toaddress = '"' . trim($contract_address) . '"';
      $unlockAddr = shell_exec('curl -X POST -H "Content-Type: application/json" --data \'{"jsonrpc":"2.0","method":"personal_unlockAccount","params":[' . $fromaddress . ',"' . $key . '",null],"id":1}\' ' . $url);
      $unlockRes = json_decode($unlockAddr, true);
      if (!isset($unlockRes['error'])) {
       $unlockEth = $unlockRes['result'];
       if ($unlockEth == 1 || $unlockEth == "true" || $unlockEth == true) {


        $get_p = shell_exec('curl -X POST -H "Content-Type: application/json" --data \'{"jsonrpc":"2.0","method":"net_peerCount","params":[],"id":83}\' '.$url);
        $get_peer  = json_decode($get_p, true);
        if(!isset($get_peer['error'])){
          $count =  bchexdec($get_peer['result']); 


          if($count > 2){

            $output = shell_exec('curl -X POST -H "Content-Type: application/json" --data \'{"jsonrpc":"2.0","method":"eth_sendTransaction","params":[{"from":' . $fromaddress . ',"to":' . $toaddress . ',"gasPrice":' . $gasPrice . ',"gas":' . $gasLimit . ',"data":' . $input . '}],"id":22}\' ' . $url);      
            $result = json_decode($output, true);

            if (!isset($result['error'])) {

              $res = $result['result'];

              if ($res == '' || $res == null) {
                $response = array('type' => 'error', 'result' => "Failed to transfer.");
              } else {
                $response =array('type' => 'success', 'result' => $res);
              }
            } else {
             $response = array('type' => 'error', 'result' => $result['error']['message'] . ' ' . $input);
           }

         }else{
          $response = array('type' => 'error', 'result' => 'Please wait for peercount to reach 3');
        }


      }
      else{
        $response = array('type' => 'error', 'result' => $get_peer['error']['message']);
      }
    } else {
      $response = array('type' => 'error', 'result' => "Invalid passsword!");
    }
  } else {
   $response = array('type' => 'error', 'result' => $unlockRes['error']['message']);
 }

}
else if ($method == "token_transfer_common") {

  $key = $json_data['data']['key'];       
  $fromaddress = strtolower($json_data['data']['from']);
  $touseraddress = strtolower($json_data['data']['to']);
  $contract_address = strtolower($json_data['data']['contract']);

  $amount = trim($json_data['data']['amount']);
  $devide_val =  $json_data['data']['devide_val'];

  $gasPrice = $json_data['data']['gas_price'];


  $gasLimit = $json_data['data']['gas_limit'];


  $gasLimit = '0x' . dechex($gasLimit);
  $gasLimit = '"' . trim($gasLimit) . '"';

  $gasPrice = '0x' . dechex($gasPrice);
  $gasPrice = '"' . trim($gasPrice) . '"';

  $amount = bcmul($amount, $devide_val);

  $amount = bcdechex($amount);
  $amount = str_pad($amount, 64, '0', STR_PAD_LEFT);
  $touseraddress = substr($touseraddress, 2);
  $input = '0xa9059cbb000000000000000000000000' . $touseraddress . $amount;
  $input = '"' . trim($input) . '"';
  $fromaddress = '"' . trim($fromaddress) . '"';

   $get_p = shell_exec('curl -X POST -H "Content-Type: application/json" --data \'{"jsonrpc":"2.0","method":"net_peerCount","params":[],"id":83}\' '.$url);
     $get_peer  = json_decode($get_p, true);
     if(!isset($get_peer['error'])){
      $count =  bchexdec($get_peer['result']); 

  if($count >= 2){

  $toaddress = '"' . trim($contract_address) . '"';
  $unlockAddr = shell_exec('curl -X POST -H "Content-Type: application/json" --data \'{"jsonrpc":"2.0","method":"personal_unlockAccount","params":[' . $fromaddress . ',"' . $key . '",null],"id":1}\' ' . $url);
  $unlockRes = json_decode($unlockAddr, true);
  if (!isset($unlockRes['error'])) {
   $unlockEth = $unlockRes['result'];
   if ($unlockEth == 1 || $unlockEth == "true" || $unlockEth == true) {

        $output = shell_exec('curl -X POST -H "Content-Type: application/json" --data \'{"jsonrpc":"2.0","method":"eth_sendTransaction","params":[{"from":' . $fromaddress . ',"to":' . $toaddress . ',"gasPrice":' . $gasPrice . ',"gas":' . $gasLimit . ',"data":' . $input . '}],"id":22}\' ' . $url);      
        $result = json_decode($output, true);

        if (!isset($result['error'])) {

          $res = $result['result'];

          if ($res == '' || $res == null) {
            $response = array('type' => 'error', 'result' => "Failed to transfer.");
          } else {
            $response =array('type' => 'success', 'result' => $res);
          }
        } else {
         $response = array('type' => 'error', 'result' => $result['error']['message'] . ' ' . $input);
       }

  }
  else{
    $response = array('type' => 'error', 'result' => $get_peer['error']['message']);
  }
} else {
  $response = array('type' => 'error', 'result' => "Invalid passsword!");
}

 }else{
  $response = array('type' => 'error', 'result' => 'Please wait for peercount to reach 3');
}
} else {
 $response = array('type' => 'error', 'result' => $unlockRes['error']['message']);
}

}
    else if ($method == "sendEthereum") {
      $fromaddress = $json_data['data']['from'];
      $toaddress = $json_data['data']['to'];
      $amount = $json_data['data']['amount'];
      $amount = bcmul($amount, 1000000000000000000);
      $key = $json_data['data']['key'];

      $peer_should = (isset($json_data['data']['peer_can'])) ? $json_data['data']['peer_can'] : 2;

      $gasPrice = $json_data['data']['gas_price'];


      $gasLimit = $json_data['data']['gas_limit'];
    

      $gasPrice = '0x' . bcdechex($gasPrice);
      $gasPrice = '"' . trim($gasPrice) . '"';

      $amount1 = '0x' . bcdechex($amount);
      $amount = '"' . trim($amount1) . '"';
      $fromaddress = '"' . trim($fromaddress) . '"';

      $toaddress = '"' . trim($toaddress) . '"';

      
      $gasLimit = '0x' . bcdechex($gasLimit);
      $gasLimit = '"' . trim($gasLimit) . '"';



      $get_p = shell_exec('curl -X POST -H "Content-Type: application/json" --data \'{"jsonrpc":"2.0","method":"net_peerCount","params":[],"id":83}\' '.$url);
      $get_peer  = json_decode($get_p, true);
      if(!isset($get_peer['error'])){
        $count =  bchexdec($get_peer['result']); 

      if($count >= 2){

      $unlockAddr = shell_exec('curl -X POST -H "Content-Type: application/json" --data \'{"jsonrpc":"2.0","method":"personal_unlockAccount","params":[' . $fromaddress . ',"' . $key . '",null],"id":67}\' ' . $url);


      $unlockRes = json_decode($unlockAddr, true);

      if (!isset($unlockRes['error'])) {
        $unlockEth = $unlockRes['result'];

        if ($unlockEth == 1 || $unlockEth == "true" || $unlockEth == true) {


            $output = shell_exec('curl -X POST -H "Content-Type: application/json" --data \'{"jsonrpc":"2.0","method":"eth_sendTransaction","params":[{"from":' . $fromaddress . ',"to":' . $toaddress . ',"gas":' . $gasLimit . ',"gasPrice":' . $gasPrice . ',"value":' . $amount . '}],"id":22}\' ' . $url);


            $result = json_decode($output, true);
            if (!isset($result['error'])) {
              $res = $result['result'];
              if ($res == '' || $res == null) {
                $response = array('type' => 'fail', 'result' => "Failed to transfer ETH.");
              } else {
                $response = array('type' => 'success', 'result' => $res);
              }
            } else {
              $response = array('type' => 'fail', 'result' => $result['error']['message'], 'gggg'=>$gasLimit);
            }


          }
          else{
            $response = array('type' => 'error', 'result' => $get_peer['error']['message']);
          }

        } else {
          $response = array('type' => 'fail', 'result' => "Invalid passsword!");
        }
        }else{
          $response = array('type' => 'error', 'result' => 'Please wait for peercount to reach 3 currenct peer count '.$count);
        }
      } else {
        $response = array('type' => 'fail', 'result' => $unlockRes['error']['message']);
      }
    }
     else if ($method == "toadminwallet") {
      $key = $json_data['data']['key'];
      $adminAddr = $json_data['data']['adminaddress'];
      $userAddr = $json_data['data']['address'];

      $getBal = shell_exec('curl -X POST -H "Content-Type: application/json" --data \'{"jsonrpc":"2.0","method":"eth_getBalance","params":["' . $userAddr . '", "latest"],"id":2}\' ' . $url);
      $decodeBal = json_decode($getBal, true);
      $userBal = bchexdec($decodeBal['result']);
      if ($userBal > 100000000000) {
        $balance = $userBal / 1000000000000000000;
        $gasPrice1 = 22000000000;
        $gasLimit1 = 30000;
        $fee = bcmul($gasPrice1, $gasLimit1);
        $transAmount = bcsub((string) $userBal, (string) $fee);
        $gasPrice = '0x' . bcdechex($gasPrice1);
        $gasLimit = '0x' . bcdechex($gasLimit1);
        $amount = '0x' . bcdechex($transAmount);
      
        $unlockAddr = shell_exec('curl -X POST -H "Content-Type: application/json" --data \'{"jsonrpc":"2.0","method":"personal_unlockAccount","params":["' . $userAddr . '","' . $key . '",null],"id":1}\' ' . $url);
        $unlockRes = json_decode($unlockAddr, true);
        if (!isset($unlockRes['error'])) {
          $unlockEth = $unlockRes['result'];
          if ($unlockEth == 1 || $unlockEth == "true" || $unlockEth == true) {
            $output = shell_exec('curl -X POST -H "Content-Type: application/json" --data \'{"jsonrpc":"2.0","method":"eth_sendTransaction","params":[{"from":"' . $userAddr . '","to":"' . $adminAddr . '","gas":"' . $gasLimit . '","gasPrice":"' . $gasPrice . '","value":"' . $amount . '"}],"id":22}\' ' . $url);
            $result = json_decode($output, true);
            if (!isset($result['error'])) {
              $res = $result['result'];
              if ($res == '' || $res == null) {
                $response = array('type' => 'fail', 'result' => "Failed to transfer ETH.");
              } else {
                $response = array('type' => 'success', 'result' => $res);
              }
            } else {
              $response = array('type' => 'fail', 'result' => $result['error']['message']);
            }
          } else {
            $response = array('type' => 'fail', 'result' => "Invalid passsword!");
          }
        } else {
          $response = array('type' => 'fail', 'result' => $unlockRes['error']['message']);
        }
      } else {
        $response = array('type' => 'fail', 'result' => "Low balance");
      }       
    }

     else if ($method == "clear_pending") {
      $key = $json_data['data']['key'];
      $from_adr = $json_data['data']['from'];
      $to_adr = $json_data['data']['to'];
      $nonce = $json_data['data']['nonce'];
      


      $getBal = shell_exec('curl -X POST -H "Content-Type: application/json" --data \'{"jsonrpc":"2.0","method":"eth_getBalance","params":["' . $from_adr . '", "latest"],"id":2}\' ' . $url);
      $decodeBal = json_decode($getBal, true);
      $userBal = bchexdec($decodeBal['result']);
      if ($userBal > 15700000000000000) {
        $gasPrice = 164000000000;
        $gasLimit = 90000;
        $transAmount =0;
        $gasPrice = '0x' . bcdechex($gasPrice);
        $gasLimit = '0x' . bcdechex($gasLimit);
        $amount = '0x' . bcdechex($transAmount);

        

        $unlockAddr = shell_exec('curl -X POST -H "Content-Type: application/json" --data \'{"jsonrpc":"2.0","method":"personal_unlockAccount","params":["' . $from_adr . '","' . $key . '",null],"id":1}\' ' . $url);
        $unlockRes = json_decode($unlockAddr, true);

        if (!isset($unlockRes['error'])) {
          $unlockEth = $unlockRes['result'];
          if ($unlockEth == 1 || $unlockEth == "true" || $unlockEth == true) {
            $output = shell_exec('curl -X POST -H "Content-Type: application/json" --data \'{"jsonrpc":"2.0","method":"eth_sendTransaction","params":[{"from":"' . $from_adr . '","to":"' . $to_adr . '","gas":"' . $gasLimit . '","gasPrice":"' . $gasPrice . '","value":"' . $amount . '","nonce":"'.$nonce.'"}],"id":22}\' ' . $url);
          
            $result = json_decode($output, true);

            if (!isset($result['error'])) {
              $res = $result['result'];
              if ($res == '' || $res == null) {
                $response = array('type' => 'fail', 'result' => "Failed to transfer ETH.");
              } else {
                $response = array('type' => 'success', 'result' => $res);
              }
            } else {
              $response = array('type' => 'fail', 'result' => $result['error']['message']);
            }
          } else {
            $response = array('type' => 'fail', 'result' => "Invalid passsword!");
          }
        } else {
          $response = array('type' => 'fail', 'result' => $unlockRes['error']['message']);
        }
      } else {
        $response = array('type' => 'fail', 'result' => "Low balance", 'dt' => $userBal);
      }
    } 
    else if ($method == "get_block_transactions") {

        $oldBlock = $json_data['data']['block'];
        $newBlock = $json_data['data']['new_block'];
        $transactions = array();


        $output = shell_exec('curl -X POST -H "Content-Type: application/json" --data \'{"jsonrpc":"2.0","method":"eth_blockNumber","params":[],"id":83}\' '.$url);


        $res = json_decode($output, true);
        $hexCount = $res['result'];
        $count = bchexdec($hexCount);
        if($newBlock!=''){
          $count = $newBlock;
        }else{
          /*Avoid unlimited calls*/
          if(($count - $oldBlock) > 30){
            $count = $oldBlock+30;
          }
        }

        $updatable_count = $oldBlock;

        for ($i = $oldBlock; $i <= $count; $i++) {
          
          $blockNum = '0x' . bcdechex($i);

          $ch = curl_init();
          curl_setopt($ch, CURLOPT_URL, "http://172.31.22.17:8585");
          curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
          curl_setopt($ch, CURLOPT_POSTFIELDS, "{\"jsonrpc\":\"2.0\",\"method\":\"eth_getBlockByNumber\",\"params\":[\"" . trim($blockNum) . "\", true],\"id\":1}");
          curl_setopt($ch, CURLOPT_POST, 1);
          $headers = array();
          $headers[] = "Content-Type: application/json";
          curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
          $result = curl_exec($ch);
          if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
          }
          curl_close($ch);

          $decodeResult = json_decode($result, true);
          $transactions[] = $decodeResult['result']['transactions'];

          $updatable_count = $i;
          
        }
        
        $get_res = ['trans_result' => $transactions, 'block' => $updatable_count];
        $response = array('type' => 'success', 'result' => $get_res);

    }
    else if ($method == "txpool") {

        $output = shell_exec('curl -X POST -H "Content-Type: application/json" --data \'{"jsonrpc":"2.0","method":"txpool_status","params":[],"id":83}\' ' . $url);

        $res = json_decode($output);

        $txpool = $res->result;

        $response = array('type' => 'success', 'result' => $txpool);
     
    } else if ($method == "txlist") {

        $output = shell_exec('curl -H "Content-Type: application/json" -X POST --data \'{"jsonrpc":"2.0","method":"eth_pendingTransactions","id":1}\' ' . $url);

        $res = json_decode($output);

        $txlist = $res->result;

        $response = array('type' => 'success', 'result' => $txlist);
      
    }
    else if ($method == "checkbalance1") {
      $address = $json_data['data']['address'];
      $getBal = shell_exec('curl -X POST -H "Content-Type: application/json" --data \'{"jsonrpc":"2.0","method":"eth_getBalance","params":["' . $address . '", "latest"],"id":2}\' '.$url);
      $decodeBal = json_decode($getBal, true);
      $userBal = bchexdec($decodeBal['result']);
      $balance = $userBal / 1000000000000000000;
      $response = array('type' => 'success', 'result' => $decodeBal, 'bal' => $balance);
    }

   else {
      $response = array('type' => 'fail', 'result' => "Invalid method");
    }

  }
} else {
  
  $response = array('type' => 'fail', 'result' => "No parameters");
}
echo json_encode($response);
?>