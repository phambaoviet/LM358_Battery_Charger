#include <Adafruit_SSD1306.h> 
#include <ESP8266WiFi.h>
#include <WiFiClient.h> 
#include <ESP8266WebServer.h>
#include <ESP8266HTTPClient.h>
#include "DHT.h"
#define chandht D3
#define loaidht DHT11
DHT dht(chandht,loaidht);
float nhietdo;
float doam;
#define SCREEN_WIDTH 128 // OLED display width, in pixels
#define SCREEN_HEIGHT 64 // OLED display height, in pixels
Adafruit_SSD1306 display(SCREEN_WIDTH, SCREEN_HEIGHT, &Wire, -1);
/* Set these to your desired credentials. */
//const char *ssid = "Red";
//const char *password = "123456788";
//const char *host = "192.168.43.159";
const char *ssid = "Red";
const char *password = "123456788";
const char *host = "192.168.43.159"; 
//=======================================================================
//                    Power on setup
//=======================================================================
void setup() {
  delay(1000);
  Serial.begin(115200);
  WiFi.mode(WIFI_OFF);        //Prevents reconnection issue (taking too long to connect)
  delay(1000);
  WiFi.mode(WIFI_STA);        //This line hides the viewing of ESP as wifi hotspot
  WiFi.begin(ssid, password);     //Connect to your WiFi router
  Serial.println("");
  Serial.print("Connecting");
  // Wait for connection
  while (WiFi.status() != WL_CONNECTED) {
    delay(500);
    Serial.print(".");
  }

  //If connection successful show IP address in serial monitor
  Serial.println("");
  Serial.print("Connected to ");
  Serial.println(ssid);
  Serial.print("IP address: ");
  Serial.println(WiFi.localIP());  //IP address assigned to your ESP
  pinMode (chandht,INPUT);
  dht.begin();
  if(!display.begin(SSD1306_SWITCHCAPVCC, 0x3C)) { // Address 0x3C for 128x64
    Serial.println(F("SSD1306 allocation failed"));
    for(;;);
  }
  display.display(); //Display logo
  delay(1000); 
  display.clearDisplay();
}
//=======================================================================
//                    Main Program Loop
//=======================================================================
void loop() {
  HTTPClient http;    //Declare object of class HTTPClient
  nhietdo = dht.readTemperature();
  doam = dht.readHumidity();
  Serial.println(nhietdo);
  Serial.println(doam);
  String ADCData, station, postData;
  int adcvalue=analogRead(A0);  //Read Analog value of LDR
  ADCData = String(adcvalue);   //String to interger conversion
  station = "A";
  //Post Data
  postData = "nhietdo=" + String(nhietdo) + "&doam=" + String(doam) ;
  Serial.println(postData);
  http.begin("http://192.168.43.159/demo/postdemo.php");              //Specify request destination
  http.addHeader("Content-Type", "application/x-www-form-urlencoded");    //Specify content-type header
  int httpCode = http.POST(postData);   //Send the request
  String payload = http.getString();    //Get the response payload
  Serial.println(httpCode);   //Print HTTP return code
  Serial.println(payload);    //Print request response payload
  http.end();  //Close connection
  delay(50000);  //Post Data at every 5 seconds
Serial.print("doam:");
 Serial.print(doam,0);
 Serial.print("%");
 Serial.print(" nhietdo:");
 Serial.print(nhietdo,1);
 Serial.print("C ~ ");
 display.clearDisplay();
 oledDisplayHeader();
 oledDisplay(3,5,28,doam,"%");
 oledDisplay(2,70,16,nhietdo,"C");
 display.display(); 
}
void oledDisplayHeader(){
 display.setTextSize(1);
 display.setTextColor(WHITE);
 display.setCursor(0, 0);
 display.print("doam");
 display.setCursor(60, 0);
 display.print("nhietdo");
}
void oledDisplay(int size, int x,int y, float value, String unit){
 int charLen=12;
 int xo=x+charLen*3.2;
 int xunit=x+charLen*3.6;
 int xval = x; 
 display.setTextSize(size);
 display.setTextColor(WHITE);
 if (unit=="%"){
   display.setCursor(x, y);
   display.print(value,0);
   display.print(unit);
 } else {
   if (value>99){
    xval=x;
   } else {
    xval=x+charLen;
   }
   display.setCursor(xval, y);
   display.print(value,0);
   display.drawCircle(xo, y+2, 2, WHITE);  // print degree symbols (  )
   display.setCursor(xunit, y);
   display.print(unit);
 }  
}
//=======================================================================
