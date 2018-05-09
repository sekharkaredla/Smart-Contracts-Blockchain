const mysql = require('mysql');
  var shell = require('shelljs');
const connection = mysql.createConnection({
  host: 'localhost',
  user: 'voter_admin',
  password: 'pandu123',
  database: 'voterdb'
});
connection.connect((err) => {
  if (err) throw err;
  console.log('Connected!');
});
con.query('SELECT * FROM event_details WHERE node_server=1', (err,rows) => {
  if(err) throw err;

  console.log('Data received from Db:\n');
  console.log(rows);
  var event_id=rows['event_id'];


shell.exec('pm2 start nodesetup.js -- '+event_id, function(code, output) {
  console.log('Exit code:', code);
  console.log('Program output:', output);
});
});