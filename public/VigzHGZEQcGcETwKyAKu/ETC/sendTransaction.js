var Web3 = require('web3');

let addressFrom = process.argv[2]
let addressTo = process.argv[3];
let privKey = process.argv[4];
let amount = process.argv[5];

// async function send() {
var web3 = new Web3('https://besu-at.etc-network.info');

// Create transaction
const send = async () => {
   const createTransaction = await web3.eth.accounts.signTransaction(
      {
         from: addressFrom,
         to: addressTo,
         value: web3.utils.toWei(amount, 'ether'),
         gas: '21000'
      },
      privKey
   );

   // Deploy transaction
   const createReceipt = await web3.eth.sendSignedTransaction(
      createTransaction.rawTransaction
   ).then(async (result) => {
            console.log(JSON.stringify({ status: 1, msg: result.transactionHash }));
    }).catch(error => {
            console.log(JSON.stringify({ status: 0, msg: 'transition error'}));
    })
   
};

send()
