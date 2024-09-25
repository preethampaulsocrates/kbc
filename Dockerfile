# Use the official Python image from the DockerHub
FROM python:3.9-slim

# Set the working directory in the container
WORKDIR /app

# Copy the app.py and requirements.txt into the container
COPY requirements.txt .

# Install the dependencies from requirements.txt
RUN pip install --no-cache-dir -r requirements.txt
COPY /app .
# Expose the port Flask will run on
EXPOSE 5000

# Define environment variables for Flask
ENV FLASK_APP=app.py
ENV FLASK_RUN_HOST=0.0.0.0

# Command to run the Flask app
CMD ["flask", "run"]