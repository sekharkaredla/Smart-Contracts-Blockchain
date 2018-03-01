Web3 = require('web3');
var fs = require("fs");
//var prompt = require('prompt');
web3 = new Web3(new Web3.providers.HttpProvider("http://localhost:8545"));
web3.eth.accounts;
code = fs.readFileSync('Voting.sol').toString();
solc = require('solc');
compiledCode = solc.compile(code);
abiDefinition = JSON.parse(compiledCode.contracts[':Voting'].interface);
VotingContract = web3.eth.contract(abiDefinition);
byteCode = compiledCode.contracts[':Voting'].bytecode;
deployedContract = VotingContract.new(['Aijaaz','Sekhar','Pranith'],{data: byteCode, from: web3.eth.accounts[0], gas: 4700000});
setTimeout(function(){
	contractInstance = VotingContract.at(deployedContract.address);
	console.log("contractInstance address:" + contractInstance.address);
	//prompt.start();
	//prompt.get(['Enter to quit'], function (err, result) {
	//	console.log('Finished');
	//});
}, 5000);
