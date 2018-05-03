pragma solidity ^0.4.18;

contract Voting {
  
  mapping (bytes32 => uint8) public votesReceived;
  
  bytes32[] public candidateList;
  bytes32[] public votedList;
  bytes32[] public voterList;

  function Voting(bytes32[] candidateNames,bytes32[] voterNames) public {
    candidateList = candidateNames;
    voterList = voterNames;
  }

  function totalVotesFor(bytes32 candidate) view public returns (uint8) {
    require(validCandidate(candidate));
    return votesReceived[candidate];
  }

  
  function voteForCandidate(bytes32 candidate, bytes32 voterHash) public {
    require(validCandidate(candidate));
    require(validVoter(voterHash));
    require(validVoterNotRepeat(voterHash));
    votesReceived[candidate] += 1;
    votedList.push(voterHash);
  }

  function validVoterNotRepeat(bytes32 voterHashNew) view public returns (bool) {
    for(uint i=0; i< votedList.length; i++){
      if(votedList[i] == voterHashNew){
        return false;
      }
    }
    return true;
  }

  function validVoter(bytes32 voterHash) view public returns (bool) {
  for(uint i=0;i< voterList.length; i++){
    if(voterHash == voterList[i]){
    return true;
      }
    }
    return false;
  }

  function validCandidate(bytes32 candidate) view public returns (bool) {
    for(uint i = 0; i < candidateList.length; i++) {
      if (candidateList[i] == candidate) {
        return true;
      }
    }
    return false;
  }
  /*
  function getCandidates() view public returns (bytes){
  bytes memory b = new bytes(candidateList.length*32);
  uint temp=0;
  for(uint i = 0;i<candidateList.length;i++)
  {
  for(uint j = 0;j<32;j++)
  {
  b[temp++] = candidateList[i][j];
  }
  }
  return b;
  }
  */
}

