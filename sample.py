import time
import mysql.connector
from mysql.connector import errorcode
from shutil import copyfile
import os
while True:
	try:
		cnx = mysql.connector.connect(user='uopAdmin123', password='pandu123', host='uopinstance.cisutjhhzfjh.us-west-2.rds.amazonaws.com',database='voterdb')
	except mysql.connector.Error as err:
		print err
	cursor = cnx.cursor()
	query = ('SELECT * FROM event_details WHERE node_server=1')
	cursor.execute(query)
	result = cursor.fetchall()
	cursor.close()
	if len(result) == 0:
		time.sleep(5)
		continue
	for each_row in result:
		copyfile('./nodesetup.js', './nodesetup_'+each_row[0]+'.js')
		os.system('pm2 start nodesetup_'+each_row[0]+'.js -- '+each_row[0])
		cursor = cnx.cursor()
		cursor.execute('update event_details set node_server=0 where event_id='+each_row[0])
		cursor.close()
		cnx.commit()
	time.sleep(5)
