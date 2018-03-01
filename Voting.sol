pragma solidity ^0.4.18;

contract Voting {
  
  mapping (bytes32 => uint8) public votesReceived;
  
  bytes32[] public candidateList;
  bytes32[] public votedList;

  function Voting(bytes32[] candidateNames) public {
    candidateList = candidateNames;
    
  }

  function totalVotesFor(bytes32 candidate) view public returns (uint8) {
    require(validCandidate(candidate));
    return votesReceived[candidate];
  }

  
  function voteForCandidate(bytes32 candidate, bytes32 voterHash) public {
    require(validCandidate(candidate));
    votesReceived[candidate] += 1;
    require(validVoter(voterHash));
    votedList.push(voterHash);
  }

  function validVoter(bytes32 voterHashNew) view public returns (bool) {
    for(uint i=0; i< votedList.length; i++){
      if(votedList[i] == voterHashNew){
        return false;
      }
    }
    return true;
  }

  function validCandidate(bytes32 candidate) view public returns (bool) {
    for(uint i = 0; i < candidateList.length; i++) {
      if (candidateList[i] == candidate) {
        return true;
      }
    }
    return false;
  }
}

