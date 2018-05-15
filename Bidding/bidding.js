//web3 = new Web3(new Web3.providers.HttpProvider("http://localhost:8545")); //for local
web3 = new Web3(new Web3.providers.HttpProvider("http://54.213.179.152:8545")); //for aws
abi = JSON.parse(
'[{"constant":true,"inputs":[{"name":"","type":"bytes32"}],"name":"bidsReceived","outputs":[{"name":"","type":"uint32"}],"payable":false,"stateMutability":"view","type":"function"},{"constant":true,"inputs":[{"name":"bidder","type":"bytes32"}],"name":"totalBidBy","outputs":[{"name":"","type":"uint32"}],"payable":false,"stateMutability":"view","type":"function"},{"constant":false,"inputs":[{"name":"bidder","type":"bytes32"},{"name":"bid","type":"uint32"}],"name":"placeBid","outputs":[],"payable":false,"stateMutability":"nonpayable","type":"function"},{"inputs":[{"name":"bidderNames","type":"bytes32[]"}],"payable":false,"stateMutability":"nonpayable","type":"constructor"}]'
);
VotingContract = web3.eth.contract(abi);
var contractAddress = "";
const url_contract =
  "https://s3.ap-south-1.amazonaws.com/bidding-system/contract_" +
  event_id +
  ".json";

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

getContract(function(data){
  contractAddress = data.contract;
});
contractInstance = VotingContract.at(
  contractAddress
);
console.log(contractAddress);

function placeBid(event_id) {
//  document.getElementById('vote_button').setAttribute("disabled","disabled");
  bidderHash = $("#bidderHash").val();
  bidAmount = $("#"+event_id+"_bid").val();
  contractInstance.placeBid(bidderHash,bidAmount,{from: bidderHash}, function() {
    console.log("bid placed");
  });
}