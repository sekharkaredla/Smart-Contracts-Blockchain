import datetime
import time
import mysql.connector
from mysql.connector import errorcode
from shutil import copyfile
import os
while True:
	try:
		cnx = mysql.connector.connect(user='uopAdmin123', password='pandu123', host='uopinstance.cisutjhhzfjh.us-west-2.rds.amazonaws.com',database='bidDB')
	except mysql.connector.Error as err:
		print err
	cursor = cnx.cursor()
	query = ('SELECT * FROM event_details WHERE running=true')
	cursor.execute(query)
	result = cursor.fetchall()
	cursor.close()
	if len(result) == 0:
		time.sleep(10)
		continue
	for each_row in result:
		os.system("rm ./biddingsetup_"+each_row[0]+".js")
		os.system('pm2 delete biddingsetup_'+each_row[0])
		cursor = cnx.cursor()
		cursor.execute('update event_details set running=false where event_id="'+each_row[0]+'"')
		cursor.close()
		cnx.commit()
	print datetime.datetime.now()
	time.sleep(10)
