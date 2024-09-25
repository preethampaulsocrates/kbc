from flask import Flask, render_template, request, jsonify
import time
import json
import os

app = Flask(__name__)

# Define the file to store submissions
SUBMISSIONS_FILE = 'submissions.json'


# Function to read submissions from JSON
def read_submissions():
    if os.path.exists(SUBMISSIONS_FILE):
        with open(SUBMISSIONS_FILE, 'r') as file:
            return json.load(file)
    return []


# Function to write submissions to JSON
def write_submissions(submissions):
    with open(SUBMISSIONS_FILE, 'w') as file:
        json.dump(submissions, file)


# Route to serve the user page (index)
@app.route('/')
def index():
    return render_template('index.html')


# Route to handle the submission of answers
@app.route('/submit', methods=['POST'])
def submit_answer():
    data = request.get_json()

    if not data.get('participant') or not data.get('order') or not data.get('time'):
        return jsonify({'message': 'Invalid submission data'}), 400

    # Map numbers to letters (1 -> A, 2 -> B, 3 -> C, 4 -> D)
    number_to_letter = {'1': 'A', '2': 'B', '3': 'C', '4': 'D'}
    order_selected = ','.join([number_to_letter[num] for num in data['order'].split(',')])

    # Prepare the submission
    submission = {
        'participant': data['participant'],
        'order_selected': order_selected,
        'submission_time': round(data['time'], 2)  # Use the elapsed time from the client
    }

    # Read existing submissions
    submissions = read_submissions()

    # Add the new submission
    submissions.append(submission)

    # Write back to the JSON file
    write_submissions(submissions)

    return jsonify({'message': 'Submission received successfully'}), 200




# Route to serve the admin page
@app.route('/admin')
def admin():
    # Get all submissions
    submissions = read_submissions()

    # Sort submissions by time (earliest first)
    submissions.sort(key=lambda x: x['submission_time'])

    return render_template('admin.html', submissions=submissions)


if __name__ == '__main__':
    app.run(debug=True)
