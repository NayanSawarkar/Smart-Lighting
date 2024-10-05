#include "WiFi.h"
#include <HTTPClient.h>
#include "ESPAsyncWebServer.h"

String URL ="http://172.22.4.112/smart_light/test_data.php" ;

const char *ssid = "IITRPR";
const char *password = "V#6qF?pyM!bQ$%NX";
const int ldrPin = 34 ; // LDR sensor pin
const int irpin = 27 ;
const int ledpin = 23 ;
const int ldrReadingInterval = 5000; // Reading interval in milliseconds

const String lightid = "LHT6287";
int checklight=1  ;
unsigned long lastLDRReadingTime = 0;
String ldrValueString; // Store LDR value as string for web page display
String msg ; 

void setup() {
  Serial.begin(115200);
  pinMode(ledpin, OUTPUT); 
  connectWiFi() ; 

}

void loop() {

  delay(4000);

  unsigned long currentMillis = millis();

  if (currentMillis - lastLDRReadingTime >= ldrReadingInterval) {
    delay(2000);
    int ldrValue = readLDRValue();
    int ir_val ;
    Serial.print("LDR Value before: ");
    Serial.println(ldrValue);
    ldrValueString = String(ldrValue); // Convert LDR value to string for webpage display
    lastLDRReadingTime = currentMillis;
    while(ldrValue>=2000)
    {
      ir_val=digitalRead(irpin) ;
      if(ir_val==0)
      {
        digitalWrite(ledpin,HIGH);
        while(ir_val==0) 
        { 
          delay(100) ;
          ir_val=digitalRead(irpin) ;
          delay(100) ;
        }
       delay(1000) ;
       ldrValue = readLDRValue();
       Serial.print("LDR Value after: ");
       Serial.println(ldrValue);
        digitalWrite(ledpin,LOW);
       if(ldrValue>=1000)
       {
         Serial.println("bulb  is not working");
         checklight=0 ;
         senddata() ;
       }

       else
       {
        Serial.println("bulb  is working");
        checklight=1 ;
        senddata() ;
       }
       
      }
      else 
      {
        digitalWrite(ledpin,LOW);
      }
      ldrValue = readLDRValue();
    }  
     digitalWrite(ledpin,LOW);
  }
  delay(100); // Add a small delay to improve stability
}

int readLDRValue() {
  delay(1000);
  int ldrValue = analogRead(ldrPin);
  delay(1000);
  return ldrValue;
}

void senddata() {
  HTTPClient http;
  http.begin(URL);
  String postdata = "id=" + String(lightid) + "&status=" + String(checklight); // Use "&" to separate parameters
  http.addHeader("Content-Type", "application/x-www-form-urlencoded");

  int httpCode = http.POST(postdata);
  String payload = http.getString();

  Serial.print(" URL : ");
  Serial.println(URL);
  Serial.print("Data :");
  Serial.println(postdata);
  Serial.print("httpCode : ");
  Serial.println(httpCode);
  Serial.print("payload : ");
  Serial.println(payload);
  Serial.println("-----------------------------------------------------");
  http.end();
}


void connectWiFi(){
  WiFi.mode(WIFI_OFF) ;
  delay(1000) ;
  WiFi.mode(WIFI_STA) ;
  WiFi.begin(ssid, password);
   Serial.println("[+] Connecting to Wifi.");
  while (WiFi.status() != WL_CONNECTED) {
    delay(500);
   Serial.print(".") ;
  }
   Serial.print("connected to : "); Serial.println(ssid) ;
   Serial.print("IP address:") ; Serial.println(WiFi.localIP());
}
