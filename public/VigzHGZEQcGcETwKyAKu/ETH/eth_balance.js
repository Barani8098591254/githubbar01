var Web3 = require('web3');

let walletAdd = process.argv[2];
async function bnbbalance() {
var web3 = new Web3('http://35.167.239.165:8545');
var walletAddress = walletAdd;
  web3.eth.getBalance(walletAddress, function(err, result)
  {
	  if(err)
	  {
	    console.log(0);
	  }
	  else
	  {
	  	console.log(result);
	  }
});
}

bnbbalance()