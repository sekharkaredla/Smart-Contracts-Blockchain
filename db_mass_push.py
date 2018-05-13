import mysql.connector
try:
	cnx = mysql.connector.connect(user='uopAdmin123', password='pandu123', host='uopinstance.cisutjhhzfjh.us-west-2.rds.amazonaws.com',database='voterdb')
except mysql.connector.Error as err:
	print err
f = open('nodesetup_output.txt','r');
count=1
for account in f.readlines():
	account = account[:-1]
	print account
	cursor1 = cnx.cursor()
	query1 = ('insert into voter_credentials values("testuser_'+str(count)+'","5f4dcc3b5aa765d61d8327deb882cf99","'+str(account)+'","id100");')
	print query1
	cursor1.execute(query1)
	cursor1.close()
	cursor2 = cnx.cursor()
	query2 = ('insert into event_details_id100 values("testuser_'+str(count)+'",false);')
	cursor2.execute(query2)
	cursor2.close()
	count+=1
cnx.commit()