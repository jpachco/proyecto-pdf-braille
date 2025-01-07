from flask import Flask, request, jsonify
import pyttsx3

app = Flask(__name__)

@app.route('/text-to-speech', methods=['POST'])
def text_to_speech():
    data = request.get_json()  # Recibe el texto del archivo PDF
    text = data.get('text', '')  # Extrae el nombre del archivo

    if text:
        try:
            engine = pyttsx3.init()  # Inicializa el motor de pyttsx3
            engine.say(text)  # Convierte el texto a voz
            engine.runAndWait()  # Ejecuta la conversión
            return jsonify({"success": True})
        except Exception as e:
            return jsonify({"success": False, "error": str(e)})

    return jsonify({"success": False, "error": "No se proporcionó texto"})

if __name__ == "__main__":
    app.run(debug=True, port=5000)  # Asegúrate de que Flask esté ejecutándose en el puerto correcto
