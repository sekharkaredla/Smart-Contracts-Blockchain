// web3 = new Web3(new Web3.providers.HttpProvider("http://localhost:8545")); //for local
web3 = new Web3(new Web3.providers.HttpProvider("http://34.210.96.63:8545"));  //for aws
abi = JSON.parse(
  '[{"constant":true,"inputs":[{"name":"","type":"uint256"}],"name":"votedList","outputs":[{"name":"","type":"bytes32"}],"payable":false,"stateMutability":"view","type":"function"},{"constant":true,"inputs":[{"name":"voterHashNew","type":"bytes32"}],"name":"validVoterNotRepeat","outputs":[{"name":"","type":"bool"}],"payable":false,"stateMutability":"view","type":"function"},{"constant":true,"inputs":[{"name":"voterHash","type":"bytes32"}],"name":"validVoter","outputs":[{"name":"","type":"bool"}],"payable":false,"stateMutability":"view","type":"function"},{"constant":true,"inputs":[{"name":"candidate","type":"bytes32"}],"name":"totalVotesFor","outputs":[{"name":"","type":"uint8"}],"payable":false,"stateMutability":"view","type":"function"},{"constant":true,"inputs":[{"name":"candidate","type":"bytes32"}],"name":"validCandidate","outputs":[{"name":"","type":"bool"}],"payable":false,"stateMutability":"view","type":"function"},{"constant":true,"inputs":[{"name":"","type":"uint256"}],"name":"voterList","outputs":[{"name":"","type":"bytes32"}],"payable":false,"stateMutability":"view","type":"function"},{"constant":true,"inputs":[{"name":"","type":"bytes32"}],"name":"votesReceived","outputs":[{"name":"","type":"uint8"}],"payable":false,"stateMutability":"view","type":"function"},{"constant":false,"inputs":[{"name":"candidate","type":"bytes32"},{"name":"voterHash","type":"bytes32"}],"name":"voteForCandidate","outputs":[],"payable":false,"stateMutability":"nonpayable","type":"function"},{"constant":true,"inputs":[{"name":"","type":"uint256"}],"name":"candidateList","outputs":[{"name":"","type":"bytes32"}],"payable":false,"stateMutability":"view","type":"function"},{"inputs":[{"name":"candidateNames","type":"bytes32[]"},{"name":"voterNames","type":"bytes32[]"}],"payable":false,"stateMutability":"nonpayable","type":"constructor"}]'
  );
VotingContract = web3.eth.contract(abi);

// contractInstance = VotingContract.at(
//  "0x02d67eda96ce8ec7ad5ea3686f1106b93f81115a"
// );

contractInstance = VotingContract.at(
  "0x76fdfede957f09685862d67328224a876f914d76"
); //aws
candidates = {
  Aijaaz: "candidate-1",
  Sekhar: "candidate-2",
  Pranith: "candidate-3",
  Alekhya: "candidate-4"
};


function voteForCandidate() {
  candidateName = $("#candidate").val();
  voterHash = $("#voterHash").val();
  contractInstance.voteForCandidate(
    candidateName,
    voterHash,
    { from: web3.eth.accounts[0] },
    function () {
      let div_id = candidates[candidateName];
      console.log(
        contractInstance.totalVotesFor.call(candidateName).toString()
      );
      $("#" + div_id).html(
        contractInstance.totalVotesFor.call(candidateName).toString()
      );
    }
  );
}

$(document).ready(function () {
  candidateNames = Object.keys(candidates);
  for (var i = 0; i < candidateNames.length; i++) {
    let name = candidateNames[i];
    let val = contractInstance.totalVotesFor.call(name).toString();
    $("#" + candidates[name]).html(val);
  }
});
