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
function nodeCreate(){
connection.query('SELECT * FROM event_details WHERE node_server=1', (err,rows) => {
  if(err) throw err;

  // console.log('Data received from Db:\n');
  // console.log(rows);
  for(var each = 0; each < rows.length; each++)
  {
    // console.log(rows[each]['event_id']);
shell.exec('pm2 start nodesetup.js -- '+rows[each]['event_id'], function(code, output) {
  console.log('Exit code:', code);
  console.log('Program output:', output);
});
  }
});
connection.query('update event_details set node_server=0', (err,rows) => {
  if(err) throw err;
    });
setTimeout(nodeCreate,5*1000);
}
nodeCreate();