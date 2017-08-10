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

extern "C" {
  #include "user_interface.h"
}

/**
 * Constant Variable Section 
 */
WiFiClient espClient;
PubSubClient client(espClient);
const char* mqtt_server_addr = "192.168.43.74";

/**
 * Variable Section
 */
int curval = 0;
String dataString = "";
/**
 * Function Section
 */
os_timer_t myTimer;

bool tickOccured;

// start of timerCallback
void timerCallback(void *pArg) {

      tickOccured = true;

} // End of timerCallback

void user_init(void) {
 /*
  os_timer_setfn - Define a function to be called when the timer fires

void os_timer_setfn(
      os_timer_t *pTimer,
      os_timer_func_t *pFunction,
      void *pArg)

Define the callback function that will be called when the timer reaches zero. The pTimer parameters is a pointer to the timer control structure.

The pFunction parameters is a pointer to the callback function.

The pArg parameter is a value that will be passed into the called back function. The callback function should have the signature:
void (*functionName)(void *pArg)

The pArg parameter is the value registered with the callback function.
*/

      os_timer_setfn(&amp;myTimer, timerCallback, NULL);

/*
      os_timer_arm -  Enable a millisecond granularity timer.

void os_timer_arm(
      os_timer_t *pTimer,
      uint32_t milliseconds,
      bool repeat)

Arm a timer such that is starts ticking and fires when the clock reaches zero.

The pTimer parameter is a pointed to a timer control structure.
The milliseconds parameter is the duration of the timer measured in milliseconds. The repeat parameter is whether or not the timer will restart once it has reached zero.

*/

      os_timer_arm(&amp;myTimer, 1000, true);
} // End of user_init



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
  tickOccured = false;
  user_init();

}

void loop() {
  
  //MQTT connection checker
  
  if (tickOccured == true)
  {
    if (!client.connected()) {
      reconnect_MQTT();
    }
    client.loop();

    Serial.println("Tick Occurred");
    tickOccured = false;
  }

  yield();  // or delay(0);
  // //Data start Reading
  // if((digitalRead(D1) != 1)||(digitalRead(D0) != 1)){
  //   // send the value of analog input 0
  //       int msgint = analogRead(0);
  //       String msg = String(msgint,DEC);
  //       char msgBuffer[4];
  //       msg.toCharArray(msgBuffer,5);
  //       client.publish("RhythmR01",msgBuffer);
  //       Serial.println(msgBuffer);
  // }

}

