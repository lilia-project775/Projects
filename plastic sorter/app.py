import cv2
from ultralytics import YOLO
from flask import Flask, Response, render_template, request
import tempfile
import os

# Flask APPLICATION
app = Flask(__name__)
app.config['UPLOAD_FOLDER'] = tempfile.gettempdir()

# --- MODEL PATH FIX ---
# Is se server ko file ka exact rasta milega
BASE_DIR = os.path.dirname(os.path.abspath(__file__))
model_path = os.path.join(BASE_DIR, 'last.pt') # Ya 'best.pt' jo bhi aap use kar rahe hain
model = YOLO(model_path)

# Flag to indicate if the script should terminate
terminate_flag = False

def generate(file_path):
    # Shared hosting par camera (cv2.VideoCapture(0)) aksar kaam nahi karta
    if file_path == "camera":
        cap = cv2.VideoCapture(0)
    else:
        cap = cv2.VideoCapture(file_path)
        
    while cap.isOpened():
        success, frame = cap.read()
        if success:
            results = model(frame)
            annotated_frame = results[0].plot()
            ret, jpeg = cv2.imencode('.jpg', annotated_frame)
            
            yield (b'--frame\r\n'
                   b'Content-Type: image/jpeg\r\n\r\n' + jpeg.tobytes() + b'\r\n')
            
            if terminate_flag:
                break
        else:
            break
            
    cap.release()
    # os._exit(0) ko nikal diya hai taake server crash na ho

@app.route('/video_feed')
def video_feed():
    file_path = request.args.get('file')
    return Response(generate(file_path),
                    mimetype='multipart/x-mixed-replace; boundary=frame')

@app.route('/', methods=['GET', 'POST'])
def index():
    global terminate_flag
    if request.method == 'POST':
        if request.form.get("camera") == "true":
            file_path = "camera"
        elif 'file' in request.files:
            file = request.files['file']
            file_path = os.path.join(app.config['UPLOAD_FOLDER'], file.filename)
            file.save(file_path)
        else:
            file_path = None
        return render_template('index.html', file_path=file_path)
    else:
        terminate_flag = False
        return render_template('index.html')

@app.route('/stop', methods=['POST'])
def stop():
    global terminate_flag
    terminate_flag = True
    return "Process has been Terminated"

if __name__ == '__main__':
    app.run()