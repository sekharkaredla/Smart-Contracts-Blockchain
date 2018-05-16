//web3 = new Web3(new Web3.providers.HttpProvider("http://localhost:8545")); //for local
function display(event_id) {
  web3 = new Web3(
    new Web3.providers.HttpProvider("http://54.213.179.152:8545")
  ); //for aws
  abi = JSON.parse(
    '[{"constant":true,"inputs":[{"name":"voterHash","type":"bytes32"}],"name":"validVoter","outputs":[{"name":"","type":"bool"}],"payable":false,"stateMutability":"view","type":"function"},{"constant":true,"inputs":[{"name":"candidate","type":"bytes32"}],"name":"totalVotesFor","outputs":[{"name":"","type":"uint8"}],"payable":false,"stateMutability":"view","type":"function"},{"constant":true,"inputs":[{"name":"","type":"bytes32"}],"name":"voters","outputs":[{"name":"","type":"bool"}],"payable":false,"stateMutability":"view","type":"function"},{"constant":true,"inputs":[{"name":"candidate","type":"bytes32"}],"name":"validCandidate","outputs":[{"name":"","type":"bool"}],"payable":false,"stateMutability":"view","type":"function"},{"constant":true,"inputs":[{"name":"","type":"bytes32"}],"name":"votesReceived","outputs":[{"name":"","type":"uint8"}],"payable":false,"stateMutability":"view","type":"function"},{"constant":false,"inputs":[{"name":"voterHash","type":"bytes32"}],"name":"setVoted","outputs":[],"payable":false,"stateMutability":"nonpayable","type":"function"},{"constant":false,"inputs":[{"name":"candidate","type":"bytes32"},{"name":"voterHash","type":"bytes32"}],"name":"voteForCandidate","outputs":[],"payable":false,"stateMutability":"nonpayable","type":"function"},{"constant":true,"inputs":[{"name":"","type":"uint256"}],"name":"candidateList","outputs":[{"name":"","type":"bytes32"}],"payable":false,"stateMutability":"view","type":"function"},{"inputs":[{"name":"candidateNames","type":"bytes32[]"},{"name":"voterNames","type":"bytes32[]"}],"payable":false,"stateMutability":"nonpayable","type":"constructor"}]'
  );
  VotingContract = web3.eth.contract(abi);
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
      type: "GET",
      url: url_candidate,
      async: false,
      contentType: "application/json",
      dataType: "json",
      success: function(json) {
        handle(json);
      },
      error: function(e) {
        alert("error");
      }
    });
  }
  function getContract(handle) {
    $.ajax({
      type: "GET",
      url: url_contract,
      async: false,
      contentType: "application/json",
      dataType: "json",
      success: function(json) {
        handle(json);
      },
      error: function(e) {
        alert("error");
      }
    });
  }
  getNames(function(data) {
    var length = data.candidateDetails.candidateLength;
    var candidateList = data.candidateDetails.candidates;
    for (var i = 0; i < length; i++) {
      var temp = i + 1;
      candidates[candidateList[i]] = "candidate-" + temp;
    }
  });

  getContract(function(data) {
    contractAddress = data.contract;
  });
  contractInstance = VotingContract.at(contractAddress);
  console.log(candidates);
  console.log(contractAddress);
  var mydataPoints = [];
  var mydataPoints1 = [];
  for (var name in candidates) {
    var tempDict = {};
    var tempDict1 = {};
    tempDict["y"] = contractInstance.totalVotesFor.call(name).toString();
    tempDict["label"] = name;
    // tempDict1["y"] = Number(contractInstance.totalVotesFor.call(name));
    // tempDict1["label"] = name;
    mydataPoints.push(tempDict);
    // mydataPoints1.push(tempDict1);
  }
  console.log(mydataPoints, mydataPoints1);

  console.log("onclck", event_id);
  var chart1 = new CanvasJS.Chart("mcontent1", {
    animationEnabled: true,
    title: {
      text: "Event: " + event_id
    },
    data: [
      {
        type: "pie",
        showInLegend: true,
        startAngle: 240,
        yValueFormatString: '##0.00"%"',
        indexLabel: "{label} {y}",
        dataPoints: mydataPoints
      }
    ]
  });
  chart1.render();

  // var chart2 = new CanvasJS.Chart("mcontent2", {
  //   // animationEnabled: true,
  //   title: {
  //     text: "Event: " + event_id
  //   },
  //   data: [
  //     {
  //       type: "bar",
  //       dataPoints: mydataPoints1
  //     }
  //   ]
  // });
  // chart2.render();
  // var chart3 = new CanvasJS.Chart("mcontent3", {
  //   animationEnabled: true,
  //   title: {
  //     text: "Event: " + event_id
  //   },
  //   data: [
  //     {
  //       type: "pie",
  //       showInLegend: true,
  //       startAngle: 240,
  //       yValueFormatString: '##0.00"%"',
  //       indexLabel: "{label} {y}",
  //       dataPoints: mydataPoints
  //     }
  //   ]
  // });
  // chart3.render();
  // var chart4 = new CanvasJS.Chart("mcontent4", {
  //   animationEnabled: true,
  //   title: {
  //     text: "Event: " + event_id
  //   },
  //   data: [
  //     {
  //       type: "pie",
  //       showInLegend: true,
  //       startAngle: 240,
  //       yValueFormatString: '##0.00"%"',
  //       indexLabel: "{label} {y}",
  //       dataPoints: mydataPoints
  //     }
  //   ]
  // });
  // chart4.render();
  $("#myModal").modal();
}
