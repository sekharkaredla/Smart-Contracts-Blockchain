Web3 = require('web3');
var fs = require("fs");
var prompt = require('prompt');
web3 = new Web3(new Web3.providers.HttpProvider("http://localhost:8545"));
console.log(web3.eth.accounts);
let rawdata = fs.readFileSync('./candidate_'+process.argv[2]+'.json');
let candidate_data = JSON.parse(rawdata);
code = fs.readFileSync('Voting.sol').toString();
solc = require('solc');
compiledCode = solc.compile(code);
abiDefinition = JSON.parse(compiledCode.contracts[':Voting'].interface);
VotingContract = web3.eth.contract(abiDefinition);
byteCode = compiledCode.contracts[':Voting'].bytecode;
deployedContract = VotingContract.new(candidate_data[process.argv[2]]['candidates'],web3.eth.accounts,{data: byteCode, from: web3.eth.accounts[0], gas: 2900000});
setTimeout(function(){
	contractInstance = VotingContract.at(deployedContract.address);
	console.log("contractInstance address:" + contractInstance.address);
	var fs = require('fs');
	fs.writeFile("./nodesetup_output.txt", contractInstance.address + "  " + web3.eth.accounts, function(err) {
    if(err) {
        return console.log(err);
    }

    console.log("nodesetup_output saved!");
}); 
	prompt.start();
	prompt.get(['Enter to quit'], function (err, result) {
		console.log('Finished');
	});
}, 5000);
