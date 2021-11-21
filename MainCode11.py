#!/usr/bin/env python
# coding: utf-8
import pyttsx3
import sounddevice as sd
import speech_recognition as sr
import wavio
import serial, time
from pocketsphinx import LiveSpeech
import urllib.request


def RecTxt():   # for recognition
    global speech
    mycmd=["FAN","HEATER",'TUBELIGHT','MACHINE']
    for phrase in speech:
        for cmd in phrase.segments(detailed=True):
            if cmd[0] in mycmd and cmd[1]>-1000:
                CMD=cmd[0]
                return CMD


def SerialCommWrite(num):
    global ser
    ser.write(num.encode())

def SerialCommRead():
    global ser
    if ser.in_waiting>0:
        Val=ser.readline().decode("ascii").rstrip()
        ser.flush()
        return Val


  



# Main Script
speech = LiveSpeech(audio_device="plughw:2,0",
                    verbose=False,
                    sampling_rate=16000,
                    buffer_size=2048,
                    no_search=False,
                    full_utt=False,
                    lm= '/home/pi/Documents/MyFiles/3494.lm',     # lm how to speak file
                    dic = '/home/pi/Documents/MyFiles/3494.dic',  # dictionary of given words
                    kws = '/home/pi/Documents/MyFiles/3494.vocab')  # keywords or vocal

ser=serial.Serial('/dev/ttyACM0',9600)
ser.flush()

import RPi.GPIO as GPIO
GPIO.setwarnings(False)
GPIO.setmode(GPIO.BOARD)
GPIO.setup(10,GPIO.IN,pull_up_down=GPIO.PUD_UP)

engine = pyttsx3.init()
text="Welcome To Automate World"
rate = engine.getProperty("rate")
engine.setProperty("rate", 130)
engine.say(text)
engine.runAndWait()

print("Starting System...")
engine.say("System Started")
engine.runAndWait()
Ncmnd=''
SerialCommWrite("5")
while True:
    if GPIO.input(10)==GPIO.LOW:
        print("Button Pressed")
        text="Please speak I am Listening"
        rate = engine.getProperty("rate")
        engine.setProperty("rate", 130)
        engine.say(text)
        engine.runAndWait()
        while True:
            Out=RecTxt()
            print("Detected Command "+Out)
            if Out=="FAN":
                print("F Command")
                engine.say("FAN Control")
                SerialCommWrite("1")
            elif Out=="HEATER":
                print("H Command")
                engine.say("Heater Control")
                SerialCommWrite("2")
            elif Out=="MACHINE":
                print("M Command")
                engine.say("Machine Control")
                SerialCommWrite("3")
            elif Out=="TUBELIGHT":
                print("T Command")
                engine.say("Tube Control")
                SerialCommWrite("4")
            engine.runAndWait()
            engine.say("Command Forwarded")
            engine.runAndWait()
            break
    else:
        Val=SerialCommRead()
        LocL=Val.find("L")
        LocT=Val.find("T")
        LocG=Val.find("G")
        
        Link='https://techpacsrobo.000webhostapp.com/IOT/Home_Hardware.php?light='+Val[1:LocT]+'&temp='+Val[LocT+1:LocG]+'&gas='+Val[LocG+1:]
        Rsp=urllib.request.urlopen(Link)

        LinkR='https://techpacsrobo.000webhostapp.com/IOT/getdevice.php'
        RspR=urllib.request.urlopen(LinkR)
        Data=str(RspR.read())
        Ind=Data.find("#")
        Comnd=Data[Ind+1]
        if Comnd=="T" and Comnd!=Ncmnd:
            print("Tube")
            SerialCommWrite("4")
            Ncmnd='T'
        elif Comnd=="F" and Comnd!=Ncmnd:
            print("Fan")
            SerialCommWrite("1")
            Ncmnd='F'
        elif Comnd=="M" and Comnd!=Ncmnd:
            print("Machine")
            SerialCommWrite("3")
            Ncmnd='M'
        elif Comnd=="H" and Comnd!=Ncmnd:
            print("Heater")
            SerialCommWrite("2")
            Ncmnd='H'

    time.sleep(1)
    

