#import needed file
import paho.mqtt.client as nyamuk

def on_message(client, userdata, message):
    #appending data to list
    # list = list+message
    return
def on_list_full():
    #check if list full, call detection algoritm
    #wait for husna
    return

#Initialize MQTT
servClient = nyamuk.Client()

#Override servClient Function
servClient.on_message = on_message

#Initialize Username & Password
servClient.username_pw_set("R",password="RhythmD3Vel")
servClient.connect("nyamuk.scrapforparts.com",1883,60)
servClient.subscribe("Rhythym",0)

servClient.loop_forever()