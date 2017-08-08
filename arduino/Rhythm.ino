/*
 * 
 * RYTHYM Software Code
 * 
 * Last Change : 09- July - 2017
 * 
 * Changelog : 
 * 1. Initial Code
 * 2. Wifi Capability
 * 3. Publish To MQTT 
 */

/**
 * Include Section
 */
 
#include <ESP8266WiFi.h>
#include <PubSubClient.h>
#include <SPI.h>
/**
 * Constant Variable Section 
 */
WiFiClient espClient;
PubSubClient client(espClient);
const char* mqtt_server_addr = "broker.hivemq.com";

/**
 * Variable Section
 */
int curval = 0;
String dataString = "";
/**
 * Function Section
 */
//Connect To Wifi
void wifi_conn(){
  const char* ssid     = "Rhythm";
  const char* password = "rdevelopment";
  Serial.println();
  Serial.print("Rhythym Connecting to ");
  Serial.println(ssid);
  
  WiFi.begin(ssid, password);
  
  while (WiFi.status() != WL_CONNECTED) {
    delay(500);
    Serial.print(".");
  }

  Serial.println("");
  Serial.println("WiFi connected");  
  Serial.println("IP address: ");
  Serial.println(WiFi.localIP());
  delay(100);
  client.setServer(mqtt_server_addr, 1883);
}

void reconnect_MQTT() {
  // Loop until we're reconnected
  while (!client.connected()) {
    Serial.print("Attempting MQTT connection...");
    // Create a random client ID
    String clientId = "Rhythym-";
    clientId += String(random(0xffff), HEX);
    // Attempt to connect
    if (client.connect(clientId.c_str())) {
      Serial.println("connected");
      // Once connected, publish an announcement...
    } else {
      Serial.print("failed, rc=");
      Serial.print(client.state());
      Serial.println(" try again in 5 seconds");
      // Wait 5 seconds before retrying
      delay(5000);
    }
  }
}



/*
 * Main Program Section
 */
void setup() {
  // initialize the serial communication:
  Serial.begin(9600);
  pinMode(D1, INPUT); // Setup for leads off detection LO +
  pinMode(D0, INPUT); // Setup for leads off detection LO -
  wifi_conn();
}

void loop() {
  
  //MQTT connection checker
  if (!client.connected()) {
    reconnect_MQTT();
  }
  client.loop();
  

  //Data start Reading
  if((digitalRead(D1) != 1)||(digitalRead(D0) != 1)){
    // send the value of analog input 0
        int msgint = analogRead(0);
        String msg = String(msgint,DEC);
        char msgBuffer[4];
        msg.toCharArray(msgBuffer,5);
        client.publish("RhythmR01",msgBuffer);
        Serial.println(msgBuffer);
  }

}

