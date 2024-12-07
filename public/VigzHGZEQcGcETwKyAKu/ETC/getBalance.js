var Web3 = require('web3');

let walletAdd = process.argv[2];

async function balance() {
var web3 = new Web3('https://besu-at.etc-network.info');
// var web3 = new Web3('https://ethereumclassic.org');
var walletAddress = walletAdd;
  web3.eth.getBalance(walletAddress, function(err, result)
  {

	  if(err)
	  {
	    console.log(0);
	  }
	  else
	  {
	  	console.log(result / 1000000000000000000);
	  }
});
}

balance()