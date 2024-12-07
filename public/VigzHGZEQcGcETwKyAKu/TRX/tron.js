let type = process.argv[2];
let fromAddress = process.argv[3];
let contract_address = process.argv[4];
let toAddress = process.argv[5];
let privateKey = process.argv[6];
let Amount = process.argv[7];

// TRX 
const TronWeb 		= require('tronweb');
const HttpProvider  = TronWeb.providers.HttpProvider;
const fullNode      = new HttpProvider('https://api.shasta.trongrid.io');
const solidityNode  = new HttpProvider('https://api.shasta.trongrid.io');
const eventServer   = 'https://api.shasta.trongrid.io';


// const fullNode      = new HttpProvider('https://api.trongrid.io');
// const solidityNode  = new HttpProvider('https://api.trongrid.io');
// const eventServer   = 'https://api.trongrid.io';

const tronWeb = new TronWeb(
    fullNode,
    solidityNode,
    eventServer
);
//Create Address
async function createAddr(){
	let newAddress = await tronWeb.createAccount();
	console.log(JSON.stringify(newAddress));
}
// Withdraw
async function withdrawFund(){
	let tradeobj = await tronWeb.transactionBuilder.sendTrx(toAddress, Amount,fromAddress,1);
	let signedtxn = await tronWeb.trx.sign(tradeobj, privateKey);
	let receipt = await tronWeb.trx.sendRawTransaction(signedtxn);
	if(receipt.result){
		var transaction_id= receipt.transaction.txID;
		console.log(transaction_id);
		return true;
	}
}

async function trxBalance(){
	await tronWeb.trx.getBalance(fromAddress).then(result => console.log(result))
}

// Token balance
async function tokenBalance(){
	let trc20ContractAddress = contract_address;//contract address
    let address = fromAddress;
	try{
    	tronWeb.setAddress(address);
	    try {
	        let contract = await tronWeb.contract().at(trc20ContractAddress);
	        //Use call to execute a pure or view smart contract method.
	        // These methods do not modify the blockchain, do not cost anything to execute and are also not broadcasted to the network.
	        let result = await contract.balanceOf(address).call();
	        console.log(JSON.stringify(parseInt(result._hex,16)));
	    } catch(error) {
	        console.log('error')
	    }
	}catch(error){
		console.log('error');
	}

}

async function validateaddress()
{
	let result = await tronWeb.isAddress(fromAddress);
	console.log(JSON.stringify(result));
}

if(type == 'createAddress'){
	createAddr();
} else if(type == 'withdraw') {
	withdrawFund();
} else if(type == 'trxBalance') {
	trxBalance();
}else if(type == 'tokenBalance') {
	tokenBalance();
}
else if(type == 'validateaddress') {
	validateaddress();
}
