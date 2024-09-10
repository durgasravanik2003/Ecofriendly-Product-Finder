# app.py
from flask import Flask, request, jsonify

app = Flask(__name__)

# Define some example responses
responses = {
    "hi": "Hello! How can I assist you with your sustainability queries today?",
    "hello": "Hello! How can I assist you with your sustainability queries today?",
    "how to reduce plastic": "To reduce plastic usage, consider using reusable bags, bottles, and containers. Avoid single-use plastics whenever possible.",
    "what are sustainable products": "Sustainable products include items like bamboo toothbrushes, reusable shopping bags, and solar-powered gadgets.",
    "how to save energy": "You can save energy by using energy-efficient appliances, turning off lights when not in use, and using natural light during the day.",
    "how to reduce carbon footprint": "To reduce your carbon footprint, consider using public transportation, reducing meat consumption, and supporting renewable energy sources.",
    "bye": "Goodbye! Have a sustainable day!"
}

@app.route('/chat', methods=['POST'])
def chat():
    user_input = request.json.get('message', '').lower()
    response = responses.get(user_input, "I'm not sure how to answer that. Can you ask something else related to sustainability?")
    return jsonify({"response": response})

if __name__ == '_main_':
    app.run(debug=True)