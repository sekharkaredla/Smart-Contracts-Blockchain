Web3 = require('web3');
require('dotenv').config();
const AWS = require('aws-sdk');

const s3 = new AWS.S3({
    accessKeyId: process.env.AWS_ACCESS_KEY,
    secretAccessKey: process.env.AWS_SECRET_ACCESS_KEY
});
const request = require('request');
request('https://s3.ap-south-1.amazonaws.com/smart-contracts-blockchain/candidate_'+process.argv[2]+'.json', { json: true }, (err, res, body) => {
if (err) { return console.log(err); }
var candidate_data = body;
var fs = require("fs");
var prompt = require('prompt');
web3 = new Web3(new Web3.providers.HttpProvider("http://localhost:8545"));
console.log(web3.eth.accounts);
code = fs.readFileSync('Voting.sol').toString();
solc = require('solc');
compiledCode = solc.compile(code);
abiDefinition = JSON.parse(compiledCode.contracts[':Voting'].interface);
VotingContract = web3.eth.contract(abiDefinition);
byteCode = compiledCode.contracts[':Voting'].bytecode;
deployedContract = VotingContract.new(candidate_data['candidateDetails']['candidates'],web3.eth.accounts,{data: byteCode, from: web3.eth.accounts[0], gas: 2900000});
setTimeout(function(){
	contractInstance = VotingContract.at(deployedContract.address);
	obj = {'contract':contractInstance.address};
	s3.putObject({Bucket: 'smart-contracts-blockchain',Key: 'contract_'+process.argv[2]+'.json',Body: JSON.stringify(obj),ACL:'public-read' ,ContentType: "application/json"},function(err,data){console.log(JSON.stringify(err));});
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
});
