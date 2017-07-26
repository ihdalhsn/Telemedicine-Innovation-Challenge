import nyamuk

def on_connect(mqttc, obj, flags, rc):
    print("rc: " + str(rc))

def on_message(mqttc, obj, msg):
    print(msg.topic + " " + str(msg.qos) + " " + str(msg.payload))

def on_subscribe(mqttc, obj, mid, granted_qos):
    print("Subscribed: " + str(mid) + " " + str(granted_qos))


clientbaru = nyamuk.mqtt_client()
clientbaru.on_message = on_message
clientbaru.on_connect = on_connect
clientbaru.on_subscribe = on_subscribe
nyamuk.start_client(clientbaru)