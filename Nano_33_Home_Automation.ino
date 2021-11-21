
#define D1 2
#define D2 3
#define D3 4
#define D4 5

#define BUZZ 6 
#define LDR A6
#define TH A7
#define GAS A5

int Vo;
float R1 = 10000;
float logR2, R2, T;
float c1 = 1.009249522e-03, c2 = 2.378405444e-04, c3 = 2.019202697e-07;

int td1=1,td2=1,td3=1,td4=1; 
int flag=0;


void setup() {
  pinMode(D1,OUTPUT);
  pinMode(D2,OUTPUT);
  pinMode(D3,OUTPUT);
  pinMode(D4,OUTPUT);
  
  pinMode(BUZZ,OUTPUT);
  pinMode(LDR,INPUT);
  pinMode(TH,INPUT);
  pinMode(GAS,INPUT);
  Serial.begin(9600);
  digitalWrite(BUZZ, LOW);
  digitalWrite(D1, td1);  
  digitalWrite(D2, td2);  
  digitalWrite(D3, td3);  
  digitalWrite(D4, td4);   

}


void loop() {
  int ldr=analogRead(LDR);
  ldr=map(ldr,0,1023,0,100);
  Vo = analogRead(TH);
  R2 = R1 * (1023.0 / (float)Vo - 1.0);
  logR2 = log(R2);
  T = (1.0 / (c1 + c2*logR2 + c3*logR2*logR2*logR2));
  T = T - 273.15;
  int gas=analogRead(GAS);
  gas=map(gas,800,1023,0,100);
  if(gas<0){gas=0;}
   if (Serial.available()) {
     char Val = (char)Serial.read();
 
     if (Val>=49 && Val<=53)
     {
       if (flag!=Val){
           flag=Val;           
       if (Val==49)
         {td1=!td1;}     
        if (Val==50)
         {td2=!td2;}    
        if (Val==51)
         {td3=!td3;}  
        if (Val==52)
        {td4=!td4;} 
        if (Val==53)
        {td1=1;td2=1;td3=1;td4=1;} 
        
        digitalWrite(D1, td1);  
        digitalWrite(D2, td2);  
        digitalWrite(D3, td3);  
        digitalWrite(D4, td4);       
       }
     }
   } 

  Serial.print("L");
  Serial.print(ldr);
  Serial.print("T");
  Serial.print(T);
  Serial.print("G");
  Serial.print(gas);
  Serial.println();
  delay(1000);
  Serial.flush();


  if(gas>60)
    {digitalWrite(BUZZ, HIGH); } 
  else{digitalWrite(BUZZ,LOW); } 
  

}
