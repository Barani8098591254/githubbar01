const Web3 = require('web3');
async function address() {
const web3 = new Web3('https://ethereumclassic.org');
const account = web3.eth.accounts.create();
console.log(JSON.stringify(account));
}

address();