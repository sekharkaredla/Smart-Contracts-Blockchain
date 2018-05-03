require('dotenv').config();
const AWS = require('aws-sdk');

const s3 = new AWS.S3({
    accessKeyId: process.env.AWS_ACCESS_KEY,
    secretAccessKey: process.env.AWS_SECRET_ACCESS_KEY
});
var fs = require('fs');
var obj;
fs.readFile('contract_id1.json', 'utf8', function (err, data) {
  if (err) throw err;
  obj = JSON.parse(data);
  s3.putObject({Bucket: 'smart-contracts-blockchain',Key: 'contract_id1.json',Body: JSON.stringify(obj),ACL:'public-read' ,ContentType: "application/json"},function(err,data){console.log(JSON.stringify(err)+" "+JSON.stringify(data));});
});