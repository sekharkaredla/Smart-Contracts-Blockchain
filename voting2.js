//web3 = new Web3(new Web3.providers.HttpProvider("http://localhost:8545")); //for local
web3 = new Web3(new Web3.providers.HttpProvider("http://18.236.247.185:8545")); //for aws
abi = JSON.parse(
  '[{"constant":true,"inputs":[{"name":"voterHash","type":"bytes32"}],"name":"validVoter","outputs":[{"name":"","type":"bool"}],"payable":false,"stateMutability":"view","type":"function"},{"constant":true,"inputs":[{"name":"candidate","type":"bytes32"}],"name":"totalVotesFor","outputs":[{"name":"","type":"uint8"}],"payable":false,"stateMutability":"view","type":"function"},{"constant":true,"inputs":[{"name":"","type":"bytes32"}],"name":"voters","outputs":[{"name":"","type":"bool"}],"payable":false,"stateMutability":"view","type":"function"},{"constant":true,"inputs":[{"name":"candidate","type":"bytes32"}],"name":"validCandidate","outputs":[{"name":"","type":"bool"}],"payable":false,"stateMutability":"view","type":"function"},{"constant":true,"inputs":[{"name":"","type":"bytes32"}],"name":"votesReceived","outputs":[{"name":"","type":"uint8"}],"payable":false,"stateMutability":"view","type":"function"},{"constant":false,"inputs":[{"name":"voterHash","type":"bytes32"}],"name":"setVoted","outputs":[],"payable":false,"stateMutability":"nonpayable","type":"function"},{"constant":false,"inputs":[{"name":"candidate","type":"bytes32"},{"name":"voterHash","type":"bytes32"}],"name":"voteForCandidate","outputs":[],"payable":false,"stateMutability":"nonpayable","type":"function"},{"constant":true,"inputs":[{"name":"","type":"uint256"}],"name":"candidateList","outputs":[{"name":"","type":"bytes32"}],"payable":false,"stateMutability":"view","type":"function"},{"inputs":[{"name":"candidateNames","type":"bytes32[]"},{"name":"voterNames","type":"bytes32[]"}],"payable":false,"stateMutability":"nonpayable","type":"constructor"}]'
);
VotingContract = web3.eth.contract(abi);
event_id = document.getElementById("event_id").value;
var candidates = {};
var contractAddress = "";
const url_contract =
  "https://s3.ap-south-1.amazonaws.com/smart-contracts-blockchain/contract_" +
  event_id +
  ".json";

const url_candidate =
    "https://s3.ap-south-1.amazonaws.com/smart-contracts-blockchain/candidate_" +
    event_id +
    ".json";

function getNames(handle) {
          $.ajax({
            type: 'GET',
            url: url_candidate,
            async: false,
            contentType: "application/json",
            dataType: 'json',
            success: function (json) {
                handle(json);
            },
            error: function (e) {
                alert("error");
            }
        });
    }
function getContract(handle) {
          $.ajax({
            type: 'GET',
            url: url_contract,
            async: false,
            contentType: "application/json",
            dataType: 'json',
            success: function (json) {
                handle(json);
            },
            error: function (e) {
                alert("error");
            }
        });
    }
getNames(function(data){
  var length = data.candidateDetails.candidateLength;
  var candidateList = data.candidateDetails.candidates;
  for(var i = 0;i<length;i++){
    var temp = i+1;
    candidates[candidateList[i]] = 'candidate-'+temp;
  }
});

getContract(function(data){
  contractAddress = data.contract;
});
contractInstance = VotingContract.at(
  contractAddress
);
console.log(candidates);
console.log(contractAddress);

function voteForCandidate() {
  candidateName = $("#candidate").val();
  voterHash = $("#voterHash").val();
  contractInstance.voteForCandidate(candidateName, voterHash,{from: web3.eth.accounts[0]}, function() {
    let div_id = candidates[candidateName];
    $("#" + div_id).html(contractInstance.totalVotesFor.call(candidateName).toString());
  });
}

$(document).ready(function() {
  candidateNames = Object.keys(candidates);
  for (var i = 0; i < candidateNames.length; i++) {
    let name = candidateNames[i];
    let val = contractInstance.totalVotesFor.call(name).toString()
    $("#" + candidates[name]).html(val);
  }
});
