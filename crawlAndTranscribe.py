# usage: sudo -E python crawlAndTranscribe.py
# I always have to run
# export GOOGLE_APPLICATION_CREDENTIALS="/Users/tanner/fixed.json"
# In my terminal window even though it is in ~/.bashrc

# This script is to be allowed to run while the server is active.
# It automatically calls transcribe.py whenever a new file is uploaded.

# developed on python 2.7.14



import mysql.connector
from mysql.connector import errorcode
import time
from transcribe import *


TABLE_NAME = "VIDEO"



try:
  cont= True
  while cont:
    time.sleep(1)
    cnx = mysql.connector.connect(user='root',
                                  database='ProjectDB', host="127.0.0.1")
    cursor = cnx.cursor()
    cursor.execute(
        "SELECT VIDEO_ID, VIDEO_PATH, TEXT, VIDEO_CONFIDENCE, VIDEO_TITLE FROM " + TABLE_NAME)
    """
    for (video_id, video_path, text, video_confidence, video_title) in cursor:
      print(video_id, video_path, text, video_confidence, video_title)
    transcript = "TannersText"
    video_id=1
    cursor.execute(
                       "UPDATE " + TABLE_NAME + " SET TEXT='" + transcript + "' WHERE VIDEO_ID=" + str(video_id) + ";"
                       )
    cnx.commit()
    """
    
    records_to_update = []
    
    for (video_id, video_path, text, video_confidence, video_title) in cursor:
      
        print(video_id, video_path, text, video_confidence, video_title)
        if( text == u'empty'):
            records_to_update.append((video_id, video_path, text, video_confidence, video_title))
            print("Empty transcription text detected")

    
    for (video_id, video_path, text, video_confidence, video_title) in records_to_update:
      print("transcribing")
      print(video_id, video_path, text, video_confidence, video_title)
      transcriber = Transcribe()
      transcript, confidence = transcriber.transcribe(convert_video_to_wav_file(video_path))
      print(transcript)
      cursor.execute(
                     "UPDATE " + TABLE_NAME + " SET TEXT='" + transcript + "' WHERE VIDEO_ID=" + str(video_id) + ";"
                     )
      cnx.commit()
      time.sleep(1)
    cursor.close()
    cnx.close()

    #except mysql.connector.Error as err:
    #   print("Tanner's code had an error (yhnmju) : ".format(err))
    #   exit(1)
  cursor.close()
  cnx.close()
  
except mysql.connector.Error as err:
  if err.errno == errorcode.ER_ACCESS_DENIED_ERROR:
    print("Something is wrong with your user name or password")
  elif err.errno == errorcode.ER_BAD_DB_ERROR:
    print("Database does not exist")
  else:
    print(err)
