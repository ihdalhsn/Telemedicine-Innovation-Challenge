# == import needed file ==
import paho.mqtt.client as nyamuk
import ssl
from parse import *
# == Detection Algoritm ==
import main_detection as detect

# == Global Variable Definition == 
listPatient = [[],[],[],[]]

# == function definition ==
def on_message(client, userdata, message):
    #appending data to list
    # list = list+message
    patientID = search("pat_id:{id}",message.payload)
    lines = search(",[{item}]",message.payload)
    # pat_id:1,[123,123]
    #{
    #   pat_id:0,
    #   data: []
    # }
    patID = int(patientID['id'])
    linesResult = lines['item'].split(",")
    listPatient[patID] = listPatient[patID] + linesResult
    on_list_full()
    return

def on_connect(mqttc, obj, flags, rc):
    if rc == 0 :
        print "Connected"
    else :
        print "Connection Error"
    return

def on_list_full():
    #check if list full, call detection algoritm
    print "checking buffer......"
    for x in range(len(listPatient)):
        if len(listPatient[x]) >= 10:
            print "Buffer Sufficient"
            detect(listPatient[x]);
    return


# == Variable defitiniton == 

# == Initialize MQTT ==
client = nyamuk.Client()

# == Override servClient Function ==
client.on_message = on_message
client.on_connect = on_connect

# == Initialize Username & Password ==
client.username_pw_set("R",password="RhythmD3Vel")
client.tls_set('/etc/ssl/certs/ca-certificates.crt',tls_version=ssl.PROTOCOL_SSLv23)
client.connect("nyamuk.scrapforparts.com",8883,60)
client.subscribe("Rhythym",0)

# == Start MQTT as main thread ==
client.loop_forever()