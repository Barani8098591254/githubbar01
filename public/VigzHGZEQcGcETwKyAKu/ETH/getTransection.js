var Web3 = require('web3');

let walletAdd = process.argv[2];
async function getTransection() {
var web3 = new Web3('http://35.167.239.165:8545');
var walletAddress = walletAdd;
var transaction = web3.eth.getTransactionFromBlock('latest', 10)
.then(console.log(transaction));


}

getTransection()