# == import needed file ==
import paho.mqtt.client as nyamuk
import ssl
from algorithm import main
from parse import *
from bpm import main as bpmfind
# == Detection Algoritm ==
# import main_detection as detect

# == Global Variable Definition == 
listPatient = [[],[],[],[]]
def clear_list(listIn):
    for i in listIn:
        del i

# == function definition ==
def on_message(client, userdata, message):
    #appending data to list
    # list = list+message
    # patientID = search("pat_id:{id}",message.payload)
    # lines = search(",[{item}]",message.payload)
    # # pat_id:1,[123,123]
    # #{
    # #   pat_id:0,
    # #   data: []
    # # }
    # patID = int(patientID['id'])
    # linesResult = lines['item'].split(",")
    # listPatient[patID] = listPatient[patID] + linesResult
    # on_list_full()
    splittedString = message.payload.split(':')
    # print splittedString[1]
    if (message._topic == 'rhythm/r01/visual'):
        on_list_full()
        listPatient[0].append(int(splittedString[1]))
    elif (message._topic == 'rhythm/r02/visual'):
        on_list_full()
        listPatient[1].append(int(splittedString[1]))
    elif (message._topic == 'rhythm/r03/visual'):
        on_list_full()
        listPatient[2].append(int(splittedString[1]))
    return

def on_connect(mqttc, obj, flags, rc):
    if rc == 0 :
        print "Connected"
    else :
        print "Connection Error"
    return

def on_list_full():
    #check if list full, call detection algoritm
    for x in range(len(listPatient)):
        if len(listPatient[x]) == 1000:
            # print main(listPatient[x])
            hasil = main(listPatient[x])
            # topic = 'rhythm/r0'+str(x+1)+'/b'
            # client.publish(topic,str(listPatient[x]),0)
            if (hasil == 'pvc'):
                topic = 'rhythm/r0'+str(x+1)+'/n'
                client.publish(topic,hasil,0)
                print topic
            else :
                topic = 'rhythm/r0'+str(x+1)+'/n'
                client.publish(topic,hasil,0)
                print 'ok'
           
            topbpm = 'rhythm/r0'+str(x+1)+'/bpm'
            bpmhasil = bpmfind(listPatient[x])
            client.publish(topbpm,64,0)
            listPatient[x] = []
            #panggil algoritma
    return


# == Variable defitiniton == 

# == Initialize MQTT ==
client = nyamuk.Client()

# == Override servClient Function ==
client.on_message = on_message
client.on_connect = on_connect

# == Initialize Username & Password ==
client.connect("127.0.0.1",1883,60)
client.subscribe("rhythm/#",0)

# == Start MQTT as main thread ==
client.loop_forever()