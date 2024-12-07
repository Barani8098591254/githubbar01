const Web3 = require('web3');
let Address = process.argv[2];
async function checkAddress() {
const web3 = new Web3('https://ethereumclassic.org');
const address = Address;
let result = web3.utils.isAddress(address)
console.log(result)
}

checkAddress();