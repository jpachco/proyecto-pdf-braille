import serial
import time

# Configuración serial
try:
    arduino = serial.Serial('COM3', 9600, timeout=1)
    time.sleep(2)  # Espera a que Arduino esté listo
    print("Conexión con Arduino establecida.")
except serial.SerialException:
    print("Error: No se pudo conectar al Arduino.")
    exit()

# Mapa de caracteres braille a código binario para la matriz 3x2 de LEDs
braille_binario = {
    '⠁': '100000', '⠃': '101000', '⠉': '110000', '⠙': '110100', '⠑': '100100',
    '⠋': '111000', '⠛': '111100', '⠓': '101100', '⠊': '011000', '⠚': '011100',
    '⠅': '100010', '⠇': '101010', '⠍': '110010', '⠝': '110110', '⠕': '100110',
    '⠏': '111010', '⠟': '111110', '⠗': '101110', '⠎': '011010', '⠞': '011110',
    '⠥': '100011', '⠧': '101011', '⠺': '011101', '⠭': '110011', '⠽': '110111',
    '⠵': '100111', ' ': '000000'
}

def leer_texto_y_convertir(archivo):
    """
    Lee el archivo de texto y convierte cada carácter braille en código binario de 6 bits.
    """
    try:
        with open(archivo, 'r', encoding='utf-8') as f:
            contenido = f.read().strip()  # Leer sin cambiar a minúsculas
        print("Archivo de texto en braille leído correctamente.")
        
        # Convierte el texto en una lista de códigos binarios usando el mapa
        braille_data = [braille_binario.get(char, '000000') for char in contenido if char in braille_binario]
        return braille_data
    except FileNotFoundError:
        print("Error: No se encontró el archivo.")
        exit()
    except UnicodeDecodeError:
        print("Error: Problema de codificación con el archivo.")
        exit()

def enviar_binario_a_arduino(braille_data):
    if arduino.in_waiting > 0:
        mensaje = arduino.readline().decode().strip()
        if mensaje == "ready":
            print("Arduino está listo para recibir datos.")
        else:
            print("Advertencia: No se recibió la confirmación de Arduino.")
    
    for linea in braille_data:
        print(f"Enviando: {linea}")
        arduino.write((linea + '\n').encode())  # Envía el código binario seguido de un salto de línea
        time.sleep(0.1)  # Pausa breve para que Arduino procese

    arduino.write(b'end\n')
    time.sleep(0.5)

    respuesta = arduino.readline().decode().strip()
    if respuesta == "datos_recibidos":
        print("Confirmación: Arduino ha recibido todos los datos.")
    else:
        print("Advertencia: No se recibió la confirmación final de Arduino.")

# Convertir el archivo de texto y enviar al Arduino
braille_data = leer_texto_y_convertir("braille_output.txt")
enviar_binario_a_arduino(braille_data)
arduino.close()
print("Conexión cerrada.")
