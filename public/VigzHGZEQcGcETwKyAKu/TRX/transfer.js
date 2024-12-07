let contract_address    = process.argv[2];
let toAddress           = process.argv[3];
let privateKey          = process.argv[4];
let Amount              = process.argv[5];

// TRX 
const TronWeb 		= require('tronweb');
const HttpProvider  = TronWeb.providers.HttpProvider;

// const fullNode      = new HttpProvider('https://api.shasta.trongrid.io');
// const solidityNode  = new HttpProvider('https://api.shasta.trongrid.io');
// const eventServer   = 'https://api.shasta.trongrid.io';

const fullNode      = new HttpProvider('https://api.trongrid.io');
const solidityNode  = new HttpProvider('https://api.trongrid.io');
const eventServer   = 'https://api.trongrid.io';

const tronWeb = new TronWeb(
    fullNode,
    solidityNode,
    eventServer,
    privateKey
);

// Withdraw
async function tokenwithdrawFund(){
	let trc20ContractAddress = contract_address;//contract address

    var amount = noExpo(Amount);
  
	try {
        let contract = await tronWeb.contract().at(trc20ContractAddress);
        await contract.transfer(
            toAddress, //address _to
            amount   //amount
        ).send({
            feeLimit: 10000000
        }).then(output => {
        	console.log(output);
        });
    } catch(error) {
        console.log("error-",error)
    }

}

tokenwithdrawFund();

function noExpo(x) {
     let deci = String(x).split(/[eE]/);
     if(deci.length== 1) return deci[0];
     let z= '', sign= x<0? '-':'',
     str= deci[0].replace('.', ''),
     mag= Number(deci[1])+ 1;
     if(mag<0){
     z= sign + '0.';
     while(mag++) z += '0';
     return z + str.replace(/^\-/,'');
     }
     mag -= str.length;
     while(mag--) z += '0';
     return str + z;
}
