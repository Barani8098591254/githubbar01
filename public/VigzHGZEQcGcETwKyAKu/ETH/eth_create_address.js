const Web3 = require('web3');
async function address() {
const web3 = new Web3('http://35.167.239.165:8545');
const account = web3.eth.accounts.create();
console.log(JSON.stringify(account));
}

address();