//web3 = new Web3(new Web3.providers.HttpProvider("http://localhost:8545")); //for local
web3 = new Web3(new Web3.providers.HttpProvider("http://18.236.247.185:8545")); //for aws
abi = JSON.parse(
  '[{"constant":true,"inputs":[{"name":"voterHash","type":"bytes32"}],"name":"validVoter","outputs":[{"name":"","type":"bool"}],"payable":false,"stateMutability":"view","type":"function"},{"constant":true,"inputs":[{"name":"candidate","type":"bytes32"}],"name":"totalVotesFor","outputs":[{"name":"","type":"uint8"}],"payable":false,"stateMutability":"view","type":"function"},{"constant":true,"inputs":[{"name":"","type":"bytes32"}],"name":"voters","outputs":[{"name":"","type":"bool"}],"payable":false,"stateMutability":"view","type":"function"},{"constant":true,"inputs":[{"name":"candidate","type":"bytes32"}],"name":"validCandidate","outputs":[{"name":"","type":"bool"}],"payable":false,"stateMutability":"view","type":"function"},{"constant":true,"inputs":[{"name":"","type":"bytes32"}],"name":"votesReceived","outputs":[{"name":"","type":"uint8"}],"payable":false,"stateMutability":"view","type":"function"},{"constant":false,"inputs":[{"name":"voterHash","type":"bytes32"}],"name":"setVoted","outputs":[],"payable":false,"stateMutability":"nonpayable","type":"function"},{"constant":false,"inputs":[{"name":"candidate","type":"bytes32"},{"name":"voterHash","type":"bytes32"}],"name":"voteForCandidate","outputs":[],"payable":false,"stateMutability":"nonpayable","type":"function"},{"constant":true,"inputs":[{"name":"","type":"uint256"}],"name":"candidateList","outputs":[{"name":"","type":"bytes32"}],"payable":false,"stateMutability":"view","type":"function"},{"inputs":[{"name":"candidateNames","type":"bytes32[]"},{"name":"voterNames","type":"bytes32[]"}],"payable":false,"stateMutability":"nonpayable","type":"constructor"}]'
);
VotingContract = web3.eth.contract(abi);
event_id = document.getElementById("event_id").value;
var data_contract;
var contractInstance;
var candidates;
const url_contract =
  "https://s3.ap-south-1.amazonaws.com/smart-contracts-blockchain/contract_" +
  event_id +
  ".json";
const url_candidate =
  "https://s3.ap-south-1.amazonaws.com/smart-contracts-blockchain/candidate_" +
  event_id +
  ".json";
// console.log(contractInstance.getCandidates.call())
// contractInstance = VotingContract.at(
//   "0x76fdfede957f09685862d67328224a876f914d76"
// ); //aws

//setTimeout(function(){}, 5000);
function voteForCandidate() {
  fetch(url_candidate)
    .then(resp => resp.json()) // Transform the data into json
    .then(function(data) {
      candidate_list = data_candidate.candidateDetails.candidates;
      candidateName = $("#candidate").val();
      console.log(candidateName);
      voterHash = $("#voterHash").val();
      var temp = candidate_list.indexOf(candidateName);
      temp = temp + 1;
      contractInstance.voteForCandidate(
        candidateName,
        voterHash,
        { from: web3.eth.accounts[0] },
        function() {
          let div_id = "candidate-" + temp;
          console.log(
            contractInstance.totalVotesFor.call(candidateName).toString()
          );
          $("#" + div_id).html(
            contractInstance.totalVotesFor.call(candidateName).toString()
          );
        }
      );
    });
  console.log("helloo");
  setTimeout(function() {
    var x =
      "<?php if(!$_SESSION['user']){ header('Location:index.php'); die(); } ?>";
  }, 5000);
}

$(document).ready(function() {
  fetch(url_contract)
    .then(resp => resp.json()) // Transform the data into json
    .then(function(data) {
      data_contract = data;
      setContractInstance();
    });
  function setContractInstance() {
    contractInstance = VotingContract.at(data_contract.contract);
    fetch(url_candidate)
      .then(resp => resp.json()) // Transform the data into json
      .then(function(data) {
        data_candidate = data;
        setCandidates();
      });
    function setCandidates() {
      // candidates = {
      //   Aijaaz: "candidate-1",
      //   Sekhar: "candidate-2",
      //   Pranith: "candidate-3",
      //   Alekhya: "candidate-4"
      // };
      candidate_list = data_candidate.candidateDetails.candidates;
      // console.log(candidate_list);
      candidate_length = data_candidate.candidateDetails.candidatelength;
      // for(var iter = 0;iter<candidate_length;iter++){
      //    var temp = iter+1;
      //    candidates[candidate_list[iter]] = 'candidate-'+temp;
      // }
      /* candidateNames = Object.keys(candidates);
  for (var i = 0; i < candidateNames.length; i++) {
    let name = candidateNames[i];
    let val = contractInstance.totalVotesFor.call(name).toString();
    $("#" + candidates[name]).html(val);
  } */
      candidateNames = candidate_list;
      for (var i = 0; i < candidateNames.length; i++) {
        let temp = i + 1;
        let name = candidateNames[i];
        let val = contractInstance.totalVotesFor.call(name).toString();
        // $("#" + "candidate-" + temp).html(val);
      }
    }
  }
});
