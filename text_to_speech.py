import pyttsx3
import sys

def speak(text):
    engine = pyttsx3.init()
    engine.say(text)
    engine.runAndWait()

if __name__ == "__main__":
    if len(sys.argv) > 1:
        text = sys.argv[1]
        speak(text)
    else:
        print("Error: No se proporcionó texto como argumento.")
        print("Uso: python text_to_speech.py \"Texto a convertir a voz\"")
